<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            \Log::info('Login successful for user: ' . $user->email);

            $token = $user->createToken('urbaneye')->plainTextToken;
            return response()->json(['token' => $token, 'user' => $user]);
        }

        \Log::warning('Login failed for email: ' . $request->input('email'));
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'newPassword' => 'required|min:6',
        ]);

        $user->password = Hash::make($request->newPassword);
        $user->save();

        return response()->json(['message' => 'Password changed successfully']);
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $path = $file->store('profile_images', 'public');
            // Salve o caminho do arquivo no banco de dados se necessário
            return response()->json(['message' => 'Imagem enviada com sucesso', 'path' => $path], 200);
        }

        return response()->json(['message' => 'Nenhuma imagem enviada'], 400);
    }

    public function register(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:users,cpf',
            'email' => 'required|string|email|max:255|unique:users,email',
            'senha' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->input('nome'),
            'cpf' => $request->input('cpf'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('senha')),
        ]);

        return response()->json(['message' => 'Usuário cadastrado com sucesso!', 'user' => $user], 201);
    }

    public function getUserInfo()
    {
        return response()->json(Auth::user());
    }
}
