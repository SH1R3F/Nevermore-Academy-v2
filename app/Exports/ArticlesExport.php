<?php

namespace App\Exports;

use App\Models\Article;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ArticlesExport implements FromCollection, WithHeadings, WithMapping
{

    /**
     * Write a heading row in the exported file
     */
    public function headings(): array
    {
        return [
            '#',
            'title',
            'content',
            'author',
            'tags',
        ];
    }

    /**
     * Map records
     */
    public function map($article): array
    {
        return [
            $article->id,
            $article->title,
            $article->content,
            $article->author->name,
            implode(', ', $article->tags->pluck('name')->toArray()),
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Article::with('author', 'tags')->get();
    }
}
