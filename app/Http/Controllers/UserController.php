<?php

namespace App\Http\Controllers;

use App\Service\UserServiceInterface;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $user;

    public function __construct(UserServiceInterface $user)
    {
        $this->user = $user;
        $this->middleware(function ($request, $next) {
            $this->auth = Auth::user();
            return $next($request);
        });
    }

    public function index()
    {
        $user_info = $this->user->getProfile($this->auth->noteid);
        return view('user.profile', compact('user_info'));
    }
}
