<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Tag;
use Illuminate\Support\Str;

class ArticleService
{


    public function store(array $data): Article
    {

        $data['slug'] = Article::generateUniqueSlug(Str::slug($data['title_en']));
        $data['author_id'] = request()->user()->id;
        $data['en'] = [
            'title' => $data['title_en'],
            'content' => $data['content_en']
        ];
        $data['ar'] = [
            'title' => $data['title_ar'],
            'content' => $data['content_ar']
        ];

        $article = Article::create($data);

        $article->addMediaFromRequest('image')->toMediaCollection('images');

        // Tags
        collect($data['tags'])->map(function ($tag) {
            Tag::firstOrCreate(['name' => $tag]);
        });

        $article->tags()->sync(Tag::whereIn('name', $data['tags'])->pluck('id'));

        return $article;
    }

    public function update(array $data, Article $article): void
    {
        $data['en'] = [
            'title' => $data['title_en'],
            'content' => $data['content_en']
        ];
        $data['ar'] = [
            'title' => $data['title_ar'],
            'content' => $data['content_ar']
        ];

        if ($data['title_en'] !== $article->translate('en')->title) { // Title changed
            $data['slug'] = Article::generateUniqueSlug(Str::slug($data['title_en']));
        }

        if (isset($data['image'])) $article->clearMediaCollectionExcept('images', $article->addMediaFromRequest('image')->toMediaCollection('images'));

        $article->update($data);

        // Tags
        collect($data['tags'])->map(function ($tag) {
            Tag::firstOrCreate(['name' => $tag]);
        });

        $article->tags()->sync(Tag::whereIn('name', $data['tags'])->pluck('id'));
    }
}
