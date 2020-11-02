<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $categories = Category::paginate(8);
        return view('management.category')->with('categories', $categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('management.createCategory');
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
        'name.required' => 'Preencha o campo nome',
        'name.unique' => 'A categoria digitada já existe',
        'name.max' => 'A categoria deve ter no máximo 30 caracteres',
        'name.min' => 'A categoria deve ter no mínimo 3 letras'
    ];
        $request->validate([
            'name' => 'required|unique:categories|max:30|min:3'
        ], $msg);
        $category = new Category;
        $name = $request->name;
        $category->name = $name;
        $category->save();
        $request->session()->flash('status', $request->name . ' salvo com sucesso!');
        return redirect('/management/category');
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
        $category = Category::find($id);
        return view('/management.editCategory')->with('category', $category);
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
            'name.required' => 'Preencha o campo nome',
            'name.unique' => 'A categoria digitada já existe',
            'name.max' => 'A categoria deve ter no máximo 30 caracteres',
            'name.min' => 'A categoria deve ter no mínimo 3 letras'
        ];
        $request->validate([
            'name' => 'required|unique:categories|max:30|min:3'
        ]);
        $category = Category::find($id);
        $category->name = $request->name;
        $category->save();
        $request->session()->flash('status', $request->name . ' atualizado com sucesso!');
        return redirect('/management/category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::destroy($id);
        Session()->flash('status', 'A categoria foi apagada!');
        return redirect('/management/category');
    }
}
