<?php

namespace App\Http\Controllers;

use App\Service\UserServiceInterface;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->auth = Auth::user();
            return $next($request);
        });
    }

    public function index(UserServiceInterface $user)
    {
        $user_info = $user->getProfile($this->auth->noteid);
        return view('user.profile', compact('user_info'));
    }
}
