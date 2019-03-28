<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class UserController extends Controller
{

    public function index()
    {
      $users = User::all();
      return ['users' => $users];
    }

    public function store(Request $request)
    {
      $request->validate([
        'names' => ['required','string'],
        'first_surname' => ['required','string'],
        'second_surname' => ['required','string'],
        'email' => ['required','email','string'],
        'role' => ['required'],
        'password' => ['required']
      ]);

      $user = new User();
      $user->names = $request->names;
      $user->first_surname = $request->first_surname;
      $user->second_surname = $request->second_surname;
      $user->email = $request->email;
      $user->role = $request->role;
      $user->password = bcrypt($request->password);
      $user->save();

      return ['user' => $user,'message' => 'Usuario Agregado'];
    }

    public function show($id)
    {

    }

    public function update(Request $request, $id)
    {
      $request->validate([
        'names' => ['required','string'],
        'first_surname' => ['required','string'],
        'second_surname' => ['required','string'],
        'email' => ['required','email','string'],
        'role' => ['required'],
        'password' => ['sometimes','required','min:6']
      ]);

      $user = User::findOrFail($id);
      $user->names = $request->names;
      $user->first_surname = $request->first_surname;
      $user->second_surname = $request->second_surname;
      $user->email = $request->email;
      $user->role = $request->role;
      if ($request->has('password')) {
        $user->password = bcrypt($request->password);
      }
      $user->save();


      return ['user' => $user,'message' => 'Usuario Actualizado'];
    }

    public function destroy($id)
    {
      $user = User::findOrFail($id);
      $user->delete();
      return ['message' => 'Usuario Eliminado'];
    }
}
