<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Exception;
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
            'users' => $this->user->whereNull('dt_encerramento')->get()
        ], 200);
    }

    public function store(UserStoreRequest $request)
    {
        try {
            $user = $this->user->createuser($request->validated());

            return \response()->json([
                'msg' => 'User criado com sucesso!',
                'dados' => $user
            ], 200);
        } catch (Exception $e) {
            return \response()->json([
                'error' => true,
                'msg' => $e->getMessage(),
                'line' => $e->getLine()
            ], 500);
        }
    }

    public function show(User $user)
    {
        return response()->json([
            $user
        ], 200);
    }

    public function update(User $user, Request $request)
    {
        try {
            $userEdit = $this->user->editUser($user, $request->all());

            return \response()->json([
                'msg' => 'User criado com sucesso!',
                'dados' => $userEdit
            ], 200);
        } catch (Exception $e) {
            return \response()->json([
                'error' => true,
                'msg' => $e->getMessage(),
                'line' => $e->getLine()
            ], 500);
        }
    }

    public function desativarUser(User $user)
    {
        try {
            $userDesativado = $this->user->desativar($user);

            return \response()->json([
                'msg' => 'User criado com sucesso!',
                'dados' => $userDesativado
            ], 200);
        } catch (Exception $e) {
            return \response()->json([
                'error' => true,
                'msg' => $e->getMessage(),
                'line' => $e->getLine()
            ], 500);
        }
    }
}
