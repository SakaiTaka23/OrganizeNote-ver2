<?php

namespace App\Service\Production;

use App\Service\TagServiceInterface;
use Illuminate\Support\Facades\Auth;
use App\Models\Tag;

class TagService implements TagServiceInterface
{

    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
        $this->auth = Auth::user();
    }

    //その人が使用したことのあるタグを使用した回数と共に探し出す
    public function getTags()
    {
        return $this->tag->select('id', 'name')->where('user_id', $this->auth->id)->withCount('articles')->orderBy('articles_count', 'desc')->orderBy('name', 'asc')->paginate(30);
    }

    //タグのidを受け取りその名前を返す
    public function getTagName($id)
    {
        $tag_name = $this->tag->select('name')->where('id', $id)->get();
        return $tag_name[0]->name;
    }

    //そのタグが使われている記事を返す
    public function getArticles($id)
    {
        $articles = $this->tag->with('articles')->where('user_id', $this->auth->id)->where('id', $id)->orderBy('name', 'asc')->get();
        return $articles[0]['articles'];
    }
}
