<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Service\ArticleServiceInterface;
use App\Service\UserServiceInterface;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->auth = Auth::user();
            return $next($request);
        });
    }

    public function Index(ArticleServiceInterface $article, UserServiceInterface $user)
    {
        $articles = $article->getIndex();
        $noteid = $user->getNoteid($this->auth->id);
        $today = date('Y-m-d');
        return view('user.index', compact('articles', 'noteid', 'today'));
    }

    public function search(Request $request, ArticleServiceInterface $article, UserServiceInterface $user)
    {
        $title = $request->title;
        $articles = $article->findArticle($request);
        $noteid = $user->getNoteid($this->auth->id);
        $dates['from'] = $request->datefrom;
        $dates['to'] = $request->dateto;
        $today = date('Y-m-d');
        return view('user.index', compact('articles', 'noteid', 'title', 'dates', 'today'));
    }
}
