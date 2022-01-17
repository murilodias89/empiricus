<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class AuthenticatorController extends Controller
{
    //
    public function register(Request $request) {
        //nome email senha
        $request->validate([
            'name' => 'required',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);

        // dd($request);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $user->save();

        return response()->json([
            'res'=>'Usuario criado com sucesso'
        ], 201);
        
    }

    public function login(Request $request) {

        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $credenciais = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (!Auth::attempt($credenciais)) {
             return response()->json([
                'res' => 'Acesso negado'
             ], 401);
        }
        // dd($request);

        $user = $request->user();
        // acessando o atributo do accessToken
        // createToken esta depreciada!
        // precisa rodar composer require lcobucci/jwt=3.3.3
        $token = $user->createToken('Token de acesso')->accessToken;

        return response()->json([
            'token' =>  $token
        ], 200);
        
    }

    public function logout(Request $request) {
        $request->user()->token()->revoke();
        return response()->json([
            'res' => 'Deslogado com sucesso'
        ]);
    }
}
