<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Article;

class HeaderSearch extends Component
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
            ->select('id', 'title', 'slug', 'category', 'featured_image')
            ->take(5)
            ->get();
    }

    public function goToSearch()
    {
        if (!empty($this->query)) {
            return redirect()->route('search', ['q' => $this->query]);
        }
    }

    public function render()
    {
        return view('livewire.header-search');
    }
}
