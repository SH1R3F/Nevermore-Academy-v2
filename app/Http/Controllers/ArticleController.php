<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Services\ArticleService;

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
        $articles = Article::with('author', 'tags')
            // If not superadmin only show his articles.
            ->when(!$user->hasRole('superadmin'), fn ($query) => $query->where('author_id', $user->id))
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return inertia('Articles/Index', [
            'articles' => ArticleResource::collection($articles)->additional([
                'creatable' => $user->can('create', Article::class)
            ])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia('Articles/Create');
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
        $service->store($request->validated());

        return redirect()->route('articles.index')->with('status', __('Article created successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return inertia('Articles/Show', [
            'article' => new ArticleResource($article->load('tags'))
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        return inertia('Articles/Edit', [
            'article' => new ArticleResource($article->load('tags'))
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ArticleRequest  $request
     * @param  \App\Models\Article  $article
     * @param  \App\Services\ArticleService  $service
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, Article $article, ArticleService $service)
    {
        $service->update($request->validated(), $article);

        return redirect()->back()->with('status', __('Article updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        // Delete his media!
        $article->clearMediaCollection();
        $article->delete();
        return redirect()->back()->with('status', __('Article deleted successfully'));
    }
}
