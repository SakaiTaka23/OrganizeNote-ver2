<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Service\ArticleServiceInterface;

class ArticleController extends Controller
{
    public function Index(ArticleServiceInterface $article)
    {
        $articles = $article->getIndex();
        $noteid = Auth::user()->noteid;
        $today = date('Y-m-d');
        return view('user.index', compact('articles', 'noteid', 'today'));
    }
}
