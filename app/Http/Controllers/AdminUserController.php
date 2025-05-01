<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('can:create');
    }
    public function index(){
        $users=User::simplePaginate(10);
        return view('admin.users', compact('users'));
    }
    public function create(){
        return view('admin.create');
    }
    public function store(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'rol' => 'required|string|in:user,doctor,recepcionist,radiology,admin',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['rol'],
        ]);
        return redirect()->route('admin.users')->with('success', 'Usuario creado exitosamente');
    }
    public function destroy(User $user){
        $user->delete();
        return redirect()->route('admin.users', ['user' => $user->id])->with('danger','Usuario eliminado');
    }
}
