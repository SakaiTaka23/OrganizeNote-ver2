<?php

namespace App\Http\Controllers;

use App\Service\TagServiceInterface;
use App\Service\UserServiceInterface;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->auth = Auth::user();
            return $next($request);
        });
    }

    public function index(TagServiceInterface $tag)
    {
        $tags = $tag->getTags();
        return view('user.tag', compact('tags'));
    }

    public function show($id, TagServiceInterface $tag, UserServiceInterface $user)
    {
        $noteid = $user->getNoteid($this->auth->id);
        $tag_name = $tag->getTagName($id);
        $articles_from_tag = $tag->getArticles($id);
        return view('user.tagshow', compact('noteid', 'tag_name', 'articles_from_tag'));
    }
}
