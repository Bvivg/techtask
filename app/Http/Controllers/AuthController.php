<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
  public function login(Request $request)
  {
    try {
      $credentials = $request->only('email', 'password');
      if (auth()->attempt($credentials)) {
        $user = auth()->user();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['message' => 'Вы вошли успешно', ' user' => $user, 'token' => $token], 200);
      }
      return response()->json(['error' => 'unauthorizated', 'message' => "Неправильный логин или пароль"], 401);
    } catch (Exception $th) {
      return response()->json(['error' => 'unexpected error', 'message' => $th->getMessage()], 500);
    }
  }
  public function register(Request $request)
  {
    try {
      $credentials = $request->only('name', 'email', 'password');
      $conflictUser = User::whereEmail($credentials['email'])->first();
      if (!$conflictUser) {
        $credentials['password'] = Hash::make($credentials['password']);
        $user = User::create($credentials);
        return response()->json(['message' => 'Вы зарегались', 'user' => $user], 201);
      }
      return response()->json(['error' => 'conflict', 'message' => 'Юзер с этой почтой уже есть'], 409);
    } catch (Exception $th) {
      return response()->json(['error' => 'unexpected error', 'message' => $th->getMessage()], 500);
    }
  }
  public function logout()
  {
    try {
      auth()->user()->tokens()->delete();
      return response()->json(['message' => 'Вы вышли успешно'], 200);
    } catch (Exception $th) {
      return response()->json(['error' => 'unexpected error', 'message' => $th->getMessage()], 500);
    }
  }
}
