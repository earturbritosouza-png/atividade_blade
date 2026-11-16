<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    
    public function index()
    {
        $users = User::orderBy('name')->get();
        return view('users.index', compact('users'));
    }

    
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    
    public function create()
    {
        return view('users.create');
    }

   
    public function store(Request $request)
    {
        $dados = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        $dados['password'] = Hash::make($dados['password']);

        User::create($dados);

        return redirect()->route('users.index')
            ->with('sucesso', 'Usuário cadastrado com sucesso!');
    }
}
