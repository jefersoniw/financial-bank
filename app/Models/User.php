<?php

namespace App\Models;

use Exception;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'cpfcnpj',
        'tipo_cliente_id',
        'email',
        'password',
        'dt_encerramento'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function conta()
    {
        return $this->belongsTo(Conta::class, 'id', 'user_id');
    }

    public function historico()
    {
        return $this->belongsTo(Historico::class, 'id', 'user_id');
    }

    public function createuser($request)
    {
        $user = new self;
        $user->name = $request['name'];
        $user->cpfcnpj = $request['cpfcnpj'];
        $user->tipo_cliente_id = $request['tipo_cliente'];
        $user->email = $request['email'];
        $user->password = Hash::make($request['password']);
        if (!$user->save()) {
            throw new Exception("erro ao salvar usuario!");
        }

        return $user;
    }

    public function editUser(User $user, $request)
    {
        if (!empty($request['name'])) {
            $user->name = $request['name'];
        }
        if (!empty($request['email'])) {
            $user->email = $request['email'];
        }
        if (!$user->save()) {
            throw new Exception("erro ao atualizar usuario!");
        }

        return $user;
    }

    public function desativar(User $user)
    {
        $user->dt_encerramento = date('Y-m-d H:i:s');
        if (!$user->save()) {
            throw new Exception("erro ao desativar usuario!");
        }

        return $user;
    }
}
