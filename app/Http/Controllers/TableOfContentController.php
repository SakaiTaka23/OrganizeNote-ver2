<?php

namespace App\Http\Controllers;

use App\Service\TableOfContentInterface;
use App\Service\UserServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TableOfContentController extends Controller
{
    protected $tableofcontent, $user;

    public function __construct(
        TableOfContentInterface $tableofcontent,
        UserServiceInterface $user
    ) {
        $this->tableofcontent = $tableofcontent;
        $this->user = $user;
        $this->middleware(function ($request, $next) {
            $this->auth = Auth::user();
            return $next($request);
        });
    }

    public function index()
    {
        $noteid = $this->user->getNoteid();
        $random_tableofcontents = $this->tableofcontent->getRandomContents($this->auth->id, 30);
        return view('user.content', compact('random_tableofcontents', 'noteid'));
    }

    public function search(Request $request)
    {
        $noteid = $this->user->getNoteid();
        $tableofcontent_name = $request->content;
        $tableofcontents = $this->tableofcontent->findContents($this->auth->id, $tableofcontent_name, 30);
        return view('user.contentsearch', compact('noteid', 'tableofcontent_name', 'tableofcontents'));
    }
}
