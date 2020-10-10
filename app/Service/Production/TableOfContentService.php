<?php

namespace App\Service\Production;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Service\TableOfContentInterface;
use App\Models\TableOfContent;

class TableOfContentService implements TableOfContentInterface
{
    private $tableOfContent;

    public function __construct(TableOfContent $tableOfContent)
    {
        $this->tableofcontent = $tableOfContent;
    }

    //その人の記事をランダムに取得
    public function getRandomContents(int $auth_id, int $paginate): LengthAwarePaginator
    {
        return $this->tableofcontent->where('user_id', $auth_id)->inRandomOrder()->with('articles')->paginate($paginate);
    }

    //目次での検索を行う
    public function findContents(int $auth_id, string $content = null, int $paginate): LengthAwarePaginator
    {
        return $this->tableofcontent->where('user_id', $auth_id)->with('articles')->where('name', 'like', '%' . $content . '%')->orderBy('name', 'asc')->paginate($paginate);
    }
}
