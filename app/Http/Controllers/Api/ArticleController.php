<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Exports\ArticlesExport;
use App\Services\ArticleService;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\ArticleRequest;
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
     * Export a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function export()
    {
        $this->authorize('viewAny', Article::class);
        return Excel::download(new ArticlesExport, 'articles.xlsx');
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
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function pdf(Article $article)
    {
        $this->authorize('view', $article);

        $pdf = \PDF::loadView('pdf.article', compact('article'));
        return $pdf->stream("{$article->title}.pdf");
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
