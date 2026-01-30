<?php

namespace App\Livewire;

use App\Services\ChatService;
use App\Services\OllamaService;
use Livewire\Component;

class ChatAssistant extends Component
{
    public bool $isOpen = false;
    public bool $isLoading = false;
    public bool $ollamaAvailable = false;
    
    public string $message = '';
    public array $messages = [];
    public array $suggestions = [];
    
    public ?string $articleContext = null;

    protected $listeners = [
        'openChat' => 'open',
        'updateContext' => 'updateContext'
    ];

    public function mount(?string $articleContext = null): void
    {
        $this->articleContext = $articleContext;
        $this->checkOllama();
        $this->loadSuggestions();
    }

    public function updateContext(?string $context = null): void
    {
        $this->articleContext = $context;
        
        // If chat is open and we just got new context, maybe add a small hint?
        // For now, just silently update for the next message.
        if ($this->isOpen && $context) {
            $this->loadSuggestions(); // Refresh suggestions based on new context
        }
    }

    public function checkOllama(): void
    {
        $this->ollamaAvailable = app(OllamaService::class)->isAvailable();
    }

    public function open(): void
    {
        $this->isOpen = true;
        $this->checkOllama();
    }

    public function close(): void
    {
        $this->isOpen = false;
    }

    public function toggle(): void
    {
        $this->isOpen = !$this->isOpen;
        if ($this->isOpen) {
            $this->checkOllama();
        }
    }

    public function sendMessage(): void
    {
        if (empty(trim($this->message))) {
            return;
        }

        if (!$this->ollamaAvailable) {
            $this->messages[] = [
                'role' => 'assistant',
                'content' => 'Sorry, the AI service is not available right now. Please make sure Ollama is running.',
            ];
            return;
        }

        $userMessage = trim($this->message);
        $this->messages[] = ['role' => 'user', 'content' => $userMessage];
        $this->message = '';
        $this->isLoading = true;

        try {
            $chatService = app(ChatService::class);
            
            // Get response with context
            $response = $chatService->chat(
                $userMessage,
                $this->messages,
                $this->articleContext
            );

            if ($response) {
                $this->messages[] = ['role' => 'assistant', 'content' => $response];
                
                // Update suggestions based on conversation
                $this->suggestions = $chatService->getSuggestions($userMessage);
            } else {
                $this->messages[] = [
                    'role' => 'assistant',
                    'content' => 'I apologize, but I couldn\'t generate a response. Please try again.',
                ];
            }
        } catch (\Exception $e) {
            $this->messages[] = [
                'role' => 'assistant',
                'content' => 'An error occurred. Please try again.',
            ];
        } finally {
            $this->isLoading = false;
        }
    }

    public function askSuggestion(string $suggestion): void
    {
        $this->message = $suggestion;
        $this->sendMessage();
    }

    public function clearHistory(): void
    {
        $this->messages = [];
        $this->loadSuggestions();
    }

    private function loadSuggestions(): void
    {
        $this->suggestions = [
            "What genres are trending right now?",
            "Tell me about the history of jazz",
            "Who influenced modern hip hop?",
        ];
    }

    public function render()
    {
        return view('livewire.chat-assistant');
    }
}
