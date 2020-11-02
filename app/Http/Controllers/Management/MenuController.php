<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Menu;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $menus = Menu::all();
        return view('management.menu')->with('menus', $menus);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $categories = Category::all();
        return view('management.createMenu')->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $msg_image = [
            'image.nullable' => 'É necessário selecionar uma imagem',
            'image.file' => 'Imagem inválida',
            'image.image' => 'O arquivo deve ser uma imagem',
            'image.mimes' => 'O formato do arquivo deve ser jpeg, png ou jpg',
            'image.max' => 'O arquivo deve ter no máximo 1mb'
        ];
        $msg = [
            'name.required' => 'Preencha o campo nome',
            'name.unique' => 'O prato digitado já existe',
            'name.max' => 'O nome do prato deve ter no máximo 80 letras',
            'name.min' => 'O nome do prato deve ter no mínimo 3 letras',
            'price.required' => 'Preencha o campo preço',
            'price.numeric' => 'O campo preço deve ser numérico',
            'price_cent.required' => 'Preencha o campo preço',
            'price_cent.numeric' => 'O campo preço deve ser numérico',
            'category_id.required' => 'Selecione a categoria',
        ];
        $request->validate([
            'name' => 'required|unique:menus|max:80|min:3',
            'price' => 'required|numeric',
            'price_cent' => 'required|numeric',
            'category_id' => 'required|numeric'
        ], $msg);
        //se não utilizar imagem para o menu será utilizado noimage.png
        $imageName = 'noimage.png';

        //se for utilizado imagem para o menu será executado o código abaixo
        if($request->image) {
            $request->validate([
                'image' => 'nullable|file|image|mimes:jpeg,png,jpg,JPEG|max:1000'
            ], $msg_image);
            $imageName = date('dmYHis').uniqid().'.'. $request->image->extension();
            $request->image->move(public_path('menu_images'), $imageName);
        }

        $preco = $request->price . '.' . $request->price_cent;

        //salvando as informações no banco de dados
        $menu = new Menu();
        $menu->name = $request->name;
        $menu->price = $preco;
        $menu->image = $imageName;
        $menu->description = $request->description;
        $menu->category_id = $request->category_id;
        $menu->save();
        $request->session()->flash('status', $request->name . ' salvo com sucesso.');
        return redirect('/management/menu');

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
        $menu = Menu::find($id);
        $categories = Category::all();
        return view('management.editMenu')->with('menu', $menu)->with('categories', $categories);
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
        $msg_image = [
            'image.nullable' => 'É necessário selecionar uma imagem',
            'image.file' => 'Imagem inválida',
            'image.image' => 'O arquivo deve ser uma imagem',
            'image.mimes' => 'O formato do arquivo deve ser jpeg, png ou jpg',
            'image.max' => 'O arquivo deve ter no máximo 1mb'
        ];
        $msg = [
            'name.required' => 'Preencha o campo nome',
            'name.max' => 'O nome do prato deve ter no máximo 80 letras',
            'name.min' => 'O nome do prato deve ter no mínimo 3 letras',
            'price.required' => 'Preencha o campo preço',
            'price.numeric' => 'O campo preço deve ser numérico',
            'category_id.required' => 'Selecione a categoria',
        ];
        //validação da informação
        $request->validate([
            'name' => 'required|max:80|min:3',
            'price' => 'required|numeric',
            'category_id' => 'required|numeric'
        ]);

        $menu = Menu::find($id);
        //validando se está pssando uma imagem
        if($request->image) {
            $request->validate([
                'image' => 'nullable|file|image|mimes:jpeg,png,jpg,JPEG|max:5000'
            ], $msg_image);
            if($menu->image !='noimage.png') {
                $imageName = $menu->image;
                unlink(public_path('menu_images') . '/' . $imageName);
            }
            $imageName = date('dmYHis').uniqid(). '.' . $request->image->extension();
            $request->image->move(public_path('menu_images'), $imageName);
        } else {
            $imageName = $menu->image;
        }
        $menu->name = $request->name;
        $menu->price = $request->price;
        $menu->image = $imageName;
        $menu->description = $request->description;
        $menu->category_id = $request->category_id;
        $menu->save();
        $request->session()->flash('status', $request->name . ' atualizado com sucesso.');
        return redirect('/management/menu');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menu = Menu::find($id);
        if($menu->image != 'noimage.png') {
            unlink(public_path('menu_images'). '/'.$menu->image);
        }
        $menuName = $menu->name;
        $menu->delete();
        Session()->flash('status', $menuName . ' apagado com sucesso.');
        return redirect('/management/menu');
    }
}
