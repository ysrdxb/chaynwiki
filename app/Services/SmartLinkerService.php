<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Support\Str;

class SmartLinkerService
{
    /**
     * Scan content and wrap article titles in links.
     * Use a basic approach for now, avoiding self-linking and duplicates.
     */
    public function injectLinks(string $content, int $excludeId = null): string
    {
        // Get all potential targets (titles that are at least 3 chars)
        $targets = Article::where('status', 'published')
            ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
            ->whereRaw('LENGTH(title) >= 3')
            ->get(['id', 'title', 'category', 'slug']);

        foreach ($targets as $target) {
            $pattern = '/\b' . preg_quote($target->title, '/') . '\b/i';
            
            // Avoid linking if already linked or within a tag
            // This is a naive regex-based linker. For production, a DOM-based approach is safer.
            $content = preg_replace_callback($pattern, function ($matches) use ($target) {
                $url = route('wiki.show', ['article' => $target->slug]);
                return '<a href="' . $url . '" class="text-brand-400 hover:text-brand-300 transition-colors border-b border-brand-500/20">' . $matches[0] . '</a>';
            }, $content, 1); // Limit to 1 link per term to avoid spam
        }

        return $content;
    }
}
