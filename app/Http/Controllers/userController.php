<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;

class userController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        return response()->json([
            'users' => $this->user->all()
        ], 200);
    }

    public function store(UserStoreRequest $request)
    {
        $user = $this->user->createuser($request->validated());

        if (!empty($user['error'])) {

            return response()->json([
                $user
            ], 400);
        }

        return \response()->json([
            $user
        ], 200);
    }

    public function show(User $user)
    {
        return response()->json([
            $user
        ], 200);
    }

    public function update(User $user, Request $request)
    {
        $this->user->editUser($user, $request->all());

        if (!empty($user['error'])) {

            return response()->json([
                $user
            ], 400);
        }

        return \response()->json([
            $user
        ], 200);
    }
}
