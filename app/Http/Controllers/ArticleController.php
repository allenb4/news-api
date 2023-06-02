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

        $category = 1;
        if ($request->has('newsCategory')) {
            $category = (int) $request->input('newsCategory');
        }
          
        $articles = Article::filter($request->all())
            ->preferences([$category])
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
