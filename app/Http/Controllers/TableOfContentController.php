<?php

namespace App\Http\Controllers;

use App\Models\TableOfContent;
use App\Service\TableOfContentInterface;
use App\Service\UserServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TableOfContentController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->auth = Auth::user();
            return $next($request);
        });
    }

    public function index(TableOfContentInterface $tableofcontent, UserServiceInterface $user)
    {
        $noteid = $user->getNoteid($this->auth->id);
        $random_tableofcontents = $tableofcontent->getRandomContents();
        return view('user.content', compact('random_tableofcontents', 'noteid'));
    }

    public function search(Request $request, TableOfContentInterface $tableofcontent, UserServiceInterface $user)
    {
        $noteid = $user->getNoteid($this->auth->id);
        $tableofcontent_name = $request->content;
        $tableofcontents = $tableofcontent->findContents($request);
        return view('user.contentsearch', compact('noteid', 'tableofcontent_name', 'tableofcontents'));
    }
}
