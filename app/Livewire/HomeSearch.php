<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Article;

class HomeSearch extends Component
{
    public $query = '';
    public $results = [];

    public function updatedQuery()
    {
        if (strlen($this->query) < 2) {
            $this->results = [];
            return;
        }

        $this->results = Article::where('title', 'like', '%' . $this->query . '%')
            ->orWhere('content', 'like', '%' . $this->query . '%')
            ->select('id', 'title', 'slug', 'category', 'featured_image') // Optimize selection
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.home-search');
    }
}
