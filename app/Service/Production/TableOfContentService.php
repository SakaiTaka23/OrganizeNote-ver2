<?php

namespace App\Service\Production;

use App\Service\TableOfContentInterface;
use Illuminate\Support\Facades\Auth;
use App\Models\TableOfContent;

class TableOfContentService implements TableOfContentInterface
{

    public function __construct(TableOfContent $tableOfContent)
    {
        $this->tableofcontent = $tableOfContent;
        $this->auth = Auth::user();
    }

    //その人の記事をランダムに30件取得
    public function getRandomContents()
    {
        return $this->tableofcontent->where('user_id', $this->auth->id)->inRandomOrder()->with('articles')->paginate(30);
    }

    //目次での検索を行う
    public function findContents($content)
    {
        return $this->tableofcontent->where('user_id', $this->auth->id)->with('articles')->where('name', 'like', '%' . $content . '%')->orderBy('name', 'asc')->paginate(30);
    }
}
