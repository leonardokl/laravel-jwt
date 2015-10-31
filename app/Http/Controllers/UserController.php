<?php

namespace App\Http\Controllers;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Middleware\Authenticate;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    protected $user = null;

    public function __construct()
    {
       // Apply the jwt.auth middleware to all methods in this controller
        $this->middleware('jwt.auth', ['except' => ['saveUser']]);
    }

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function allUsers()
    {
        return $this->user->allUsers();
    }

    public function saveUser(Request $request)
    {               
        $request = $request->only('name', 'email', 'password'); 
        return $this->user->saveUser($request);
    }

    public function getUser($id)
    {
        $user =  $this->user->getUser($id);

        if(!$user) {
            return response()->json(['response' => 'Not found'], 400);
        }

        return $user;
    }

    public function updateUser(Request $request, $id)
    {   
        $request = $request->only('name', 'email', 'password'); 
        $user = $this->user->updateUser($request, $id);

        if(is_null($user)) {
            return response()->json(['response' => 'Not found'], 400);
        }

        return response()->json($user, 200);
    }

    public function deleteUser($id)
    {
        $user = $this->user->deleteUser($id);        
        
        if(is_null($user)) {
            return response()->json(['response' => 'Not found'], 400);;
        }

        return $user;
    }
}
