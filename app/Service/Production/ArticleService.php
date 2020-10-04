<?php

namespace App\Service\Production;

use App\Service\ArticleServiceInterface;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;

class ArticleService implements ArticleServiceInterface
{
    protected $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
        $this->auth = Auth::user();
    }

    //インデックスページに表示する記事を投稿日が新しい順に取得
    public function getIndex()
    {
        //dd($this->article);
        return $this->article->where('user_id', $this->auth->id)->orderBy('created_at', 'desc')->paginate(30);
    }

    //記事の検索を行う
    public function findArticle($datefrom, $dateto, $title)
    {
        $from = $datefrom;
        if (!isset($from)) {
            $from = '2014-04-07';
        }
        $to = $dateto;
        if (!isset($to)) {
            $to = now();
        }

        $articles = $this->article->where('user_id', $this->auth->id)->where('title', 'like', '%' . $title . '%');
        $articles = $articles->whereBetween('created_at', [$from, $to])->orderBy('created_at', 'desc')->paginate(30);
        return $articles;
    }
}
