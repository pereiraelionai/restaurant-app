<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\Tenant\ManagerTenant;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('management.user')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('management.createUser');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $msg = [
            'name.required' => 'O campo nome é obrigatório',
            'name.unique' => 'O nome digitado já existe',
            'name.max' => 'O nome deve ter no máximo 80 letras',
            'name.min' => 'O nome deve ter no máximo 3 letras',
            'email.required' => 'O campo email é obrigatório',
            'email.email' => 'Verifique o email digitado',
            'email.unique' => 'O email digitado já existe',
            'email.max' => 'O email deve ter no máximo 80 caracteres',
            'email.min' => 'O email deve ter no mínimo 5 caracteres',
            'password.required' => 'O campo senha é obrigatório',
            'password.min' => 'A senha deve ter no mínimo 6 caracteres',
            'role' => 'O campo função é obrigatório'
        ];

        $db_chave = Auth::user()->db_chave;

        $request->validate([
            'name' => 'required|unique:users|max:80|min:5',
            'email' => 'required|email|unique:users|max:80',
            'password' => 'required|min:6',
            'role' => 'required',
        ], $msg);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->db_chave = $db_chave;
        $user->save();
        $request->session()->flash('status', $request->name . ' foi criado com sucesso');

        if($db_chave != 'restaurante') {

            app(ManagerTenant::class)->setConnectionRest();

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = $request->role;
            $user->db_chave = $db_chave;
            $user->save();
            $request->session()->flash('status', $request->name . ' foi criado com sucesso');
        } 
        
        return redirect('/management/user');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('/management.editUser')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        $msg = [
            'name.required' => 'O campo nome é obrigatório',
            'name.unique' => 'O nome digitado já existe',
            'name.max' => 'O nome deve ter no máximo 80 letras',
            'name.min' => 'O nome deve ter no máximo 3 letras',
            'email.required' => 'O campo email é obrigatório',
            'email.email' => 'Verifique o email digitado',
            'email.unique' => 'O email digitado já existe',
            'email.max' => 'O email deve ter no máximo 80 caracteres',
            'email.min' => 'O email deve ter no mínimo 5 caracteres',
            'password.required' => 'O campo senha é obrigatório',
            'password.min' => 'A senha deve ter no mínimo 6 caracteres',
            'role' => 'O campo função é obrigatório'
        ];
        $request->validate([
            'name' => 'required|max:80',
            'email' => 'required|email|max:80',
            'password' => 'required|min:6',
            'role' => 'required'
        ], $msg);
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->save();
        $request->session()->flash('status', $request->name . ' foi atualizado com sucesso');
        return redirect('/management/user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        Session()->flash('status', 'O usuário foi deletado com sucesso');
        return redirect('management/user');
    }
}
