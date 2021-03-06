<?php

namespace App\Service\Production;

use App\Service\ArticleServiceInterface;
use App\Models\Article;
use Illuminate\Pagination\LengthAwarePaginator;

class ArticleService implements ArticleServiceInterface
{
    private $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    //インデックスページに表示する記事を投稿日が新しい順に取得
    public function getIndex(int $auth_id, int $paginate): LengthAwarePaginator
    {
        return $this->article->where('user_id', $auth_id)->orderBy('created_at', 'desc')->paginate($paginate);
    }

    //記事の検索を行う
    public function findArticle(int $auth_id,string $datefrom=null, string $min_date,string $dateto=null, string $max_date, string $title=null, int $paginate): LengthAwarePaginator
    {
        $from = $datefrom;
        if (!isset($from)) {
            $from = $min_date;
        }
        $to = $dateto;
        if (!isset($to)) {
            $to = $max_date;
        }

        $articles = $this->article->where('user_id', $auth_id)->where('title', 'like', '%' . $title . '%');
        $articles = $articles->whereBetween('created_at', [$from, $to])->orderBy('created_at', 'desc')->paginate($paginate);
        return $articles;
    }
}
