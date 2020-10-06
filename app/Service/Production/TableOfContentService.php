<?php

namespace App\Service\Production;

use App\Service\TableOfContentInterface;
use App\Models\TableOfContent;

class TableOfContentService implements TableOfContentInterface
{

    public function __construct(TableOfContent $tableOfContent)
    {
        $this->tableofcontent = $tableOfContent;
    }

    //その人の記事をランダムに30件取得
    public function getRandomContents($auth_id, $paginate)
    {
        return $this->tableofcontent->where('user_id', $auth_id)->inRandomOrder()->with('articles')->paginate($paginate);
    }

    //目次での検索を行う
    public function findContents($auth_id, $content, $paginate)
    {
        return $this->tableofcontent->where('user_id', $auth_id)->with('articles')->where('name', 'like', '%' . $content . '%')->orderBy('name', 'asc')->paginate($paginate);
    }
}
