<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Table;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $tables = Table::all();
        return view('management.table')->with('tables', $tables);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('management.createTable');
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
            'name.required' => 'Preencha o nome da mesa',
            'name.unique' => 'A mesa digitada já existe',
            'name.max' => 'A mesa deve ter no máximo 30 caracteres'
        ];
        $request->validate([
            'name' => 'required|unique:tables|max:30'
        ], $msg);
        $table = new Table();
        $table->name = $request->name;
        $table->save();
        $request->session()->flash('status', 'Mesa' . $request->name . ' criada com sucesso.');
        return redirect('/management/table');
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
        $table = Table::find($id);
        return view('management.editTable')->with('table', $table);
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
            'name.required' => 'Preencha o nome da mesa',
            'name.unique' => 'A mesa digitada já existe',
            'name.max' => 'A mesa deve ter no máximo 30 caracteres'
        ];
        $request->validate([
            'name' => 'required|unique:tables|max:30'
        ], $msg);
        $table = Table::find($id);
        $table->name = $request->name;
        $table->save();
        $request->session()->flash('status', 'A mesa foi atualizada para ' . $request->name . ' com sucesso.');
        return redirect('/management/table');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Table::destroy($id);
        Session()->flash('status', 'A mesa foi apagada com sucesso.');
        return redirect('/management/table');
    }
}
