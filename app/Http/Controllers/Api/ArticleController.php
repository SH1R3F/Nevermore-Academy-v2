<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;

class ArticleController extends Controller
{

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Article::class, 'article');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = request()->user();
        $articles = Article::with('author')
            // If not superadmin only show his articles.
            ->when(!$user->hasRole('superadmin'), fn ($query) => $query->where('author_id', $user->id))
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return ArticleResource::collection($articles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ArticleRequest  $request
     * @param  \App\Services\ArticleService  $service
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request, ArticleService $service)
    {
        $article = $service->store($request->validated());

        return $this->apiResponse(__('Article created successfully'), ['article' => new ArticleResource($article)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return new ArticleResource($article);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @param  \App\Services\ArticleService  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article, ArticleService  $service)
    {
        $service->update($request->validated(), $article);

        return $this->apiResponse(__('Article updated successfully'), ['article' => new ArticleResource($article)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article  $article)
    {
        // Delete his media!
        $article->clearMediaCollection();
        $article->delete();
        return $this->apiResponse(__('Article deleted successfully'));
    }
}
