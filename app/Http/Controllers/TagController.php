<?php

namespace App\Http\Controllers;

use App\Service\TagServiceInterface;
use App\Service\UserServiceInterface;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    private $tag;
    private $user;

    public function __construct(
        TagServiceInterface $tag,
        UserServiceInterface $user
    ) {
        $this->tag = $tag;
        $this->user = $user;
        $this->middleware(function ($request, $next) {
            $this->auth = Auth::user();
            return $next($request);
        });
    }

    public function index()
    {
        $tags = $this->tag->getTags($this->auth->id, 30);
        return view('user.tag', compact('tags'));
    }

    public function show($id)
    {
        $noteid = $this->auth->noteid;
        $tag_name = $this->tag->getTagName($id);
        $articles_from_tag = $this->tag->getArticles($this->auth->id, $id);
        return view('user.tagshow', compact('noteid', 'tag_name', 'articles_from_tag'));
    }
}
