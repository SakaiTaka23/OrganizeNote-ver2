<?php

namespace App\Http\Controllers;

use App\Models\TableOfContent;
use App\Service\TableOfContentInterface;
use App\Service\UserServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TableOfContentController extends Controller
{
    protected $tableofcontent, $user;

    public function __construct(TableOfContentInterface $tableofcontent, UserServiceInterface $user)
    {
        $this->tableofcontent = $tableofcontent;
        $this->user = $user;
        $this->middleware(function ($request, $next) {
            $this->auth = Auth::user();
            return $next($request);
        });
    }

    public function index(TableOfContentInterface $tableofcontent)
    {
        $noteid = $this->user->getNoteid();
        $random_tableofcontents = $tableofcontent->getRandomContents();
        return view('user.content', compact('random_tableofcontents', 'noteid'));
    }

    public function search(Request $request, TableOfContentInterface $tableofcontent, UserServiceInterface $user)
    {
        $noteid = $user->getNoteid();
        $tableofcontent_name = $request->content;
        $tableofcontents = $tableofcontent->findContents($tableofcontent_name);
        return view('user.contentsearch', compact('noteid', 'tableofcontent_name', 'tableofcontents'));
    }
}
