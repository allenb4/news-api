<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $preferences = $request->user()
            ->preferences()
            ->get()
            ->map(function ($category) {
                return $category->id;
            });

        $articles = Article::filter($request->all())
            ->preferences($preferences->toArray())
            ->orderBy('id', 'DESC')
            ->paginate(
                $this->getPageLimit(),
                '*',
                'page',
                $this->getCurrentPage()
            );

        return response()->json($articles);
    }
}
