<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Service\ArticleServiceInterface;
use App\Service\UserServiceInterface;

class ArticleController extends Controller
{
    protected $article;
    protected $user;

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

    public function Index()
    {
        $articles = $this->article->getIndex($this->auth->id, 30);
        $noteid = $this->user->getNoteid();
        $today = date('Y-m-d');
        return view('user.index', compact('articles', 'noteid', 'today'));
    }

    public function search(Request $request)
    {
        $title = $request->title;
        $articles = $this->article->findArticle($this->auth->id, $request->datefrom, '2014-04-07', $request->dateto, now(), $request->title, 30);
        $noteid = $this->user->getNoteid();
        $dates['from'] = $request->datefrom;
        $dates['to'] = $request->dateto;
        $today = date('Y-m-d');
        return view('user.index', compact('articles', 'noteid', 'title', 'dates', 'today'));
    }
}
