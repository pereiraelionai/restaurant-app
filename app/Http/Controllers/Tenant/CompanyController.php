<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Events\Tenant\UserCreated;

class CompanyController extends Controller
{   
    private $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function store(Request $request) {

        $request->validate([
            'name' => 'required|unique:users|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:6',
            'role' => 'required',
            'db_chave' => 'required|unique:users'
        ]);
        $user = $this->user->create([
            'name' => $request->name, 
            'email' => $request->email,
            'role'  => $request->role,
            'password' => Hash::make($request->password), 
            'pagamento' => 'sim',
            'db_chave' => $request->db_chave,
        ]);

        event(new UserCreated($user));

        return redirect('/management/user');
    }

    public function create() {
        return view('tenant.cadastro');
    }

    public function index() {
        return view('tenant.index');
    }
}
