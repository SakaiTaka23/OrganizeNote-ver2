<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Service\ArticleServiceInterface;
use App\Service\UserServiceInterface;

class ArticleController extends Controller
{
    protected $article, $user;

    public function __construct(
        ArticleServiceInterface $article,
        UserServiceInterface $user
    ) {
        $this->article = $article;
        $this->user = $user;
        $this->middleware(function ($request, $next) {
            $this->auth = Auth::user();
            return $next($request);
        });
    }

    public function Index(ArticleServiceInterface $article)
    {
        //dd($article,$this->article);
        $articles = $article->getIndex(30);
        // $articles = $this->article->getIndex(30);
        $noteid = $this->user->getNoteid();
        $today = date('Y-m-d');
        return view('user.index', compact('articles', 'noteid', 'today'));
    }

    public function search(Request $request, ArticleServiceInterface $article)
    {
        $title = $request->title;
        $articles = $article->findArticle($request->datefrom, '2014-04-07', $request->dateto, now(), $request->title, 30);
        $noteid = $this->user->getNoteid();
        $dates['from'] = $request->datefrom;
        $dates['to'] = $request->dateto;
        $today = date('Y-m-d');
        return view('user.index', compact('articles', 'noteid', 'title', 'dates', 'today'));
    }
}
