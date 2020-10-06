<?php

namespace App\Service\Production;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

use App\Service\TagServiceInterface;
use App\Models\Tag;

class TagService implements TagServiceInterface
{

    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    //その人が使用したことのあるタグを使用した回数と共に探し出す
    public function getTags(int $auth_id, int $paginate): LengthAwarePaginator
    {
        return $this->tag->select('id', 'name')->where('user_id', $auth_id)->withCount('articles')->orderBy('articles_count', 'desc')->orderBy('name', 'asc')->paginate($paginate);
    }

    //タグのidを受け取りその名前を返す
    public function getTagName(int $id): string
    {
        $tag_name = $this->tag->select('name')->where('id', $id)->get();
        return $tag_name[0]->name;
    }

    //そのタグが使われている記事を返す
    public function getArticles(int $auth_id, int $id): Collection
    {
        $articles = $this->tag->with('articles')->where('user_id', $auth_id)->where('id', $id)->orderBy('name', 'asc')->get();
        return $articles[0]['articles'];
    }
}
