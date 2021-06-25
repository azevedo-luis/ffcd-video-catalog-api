<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

abstract class BasicCrudController extends Controller
{
    protected abstract function model();

    protected abstract function rulesStore();

    protected abstract function rulesUpdate();



    public function index()
    {
        return $this->model()::all();
    }

    public function store(Request $request){
        $validatedData = $this -> validate($request, $this->rulesStore()); 
        $obj = $this->model()::create($validatedData);
        $obj->refresh();
        return $obj;
    }

    protected function findOrFail($id){
        $model = $this->model();
        $keyName = (new $model)->getRouteKeyName();
        return $this->model()::where($keyName, $id)->firstOrFail();
    }

    public function show($id){
        $obj = $this->findOrFail($id);
        return $obj;
    }

    public function update(Request $request, $id){
        $obj = $this->findOrFail($id);
        $validatedData = $this->validate($request, $this->rulesUpdate());
        $obj->update($validatedData);
        return $obj;
    }
    
    public function destroy($id){
        $obj = $this->findOrFail($id);
        $obj->delete();
        return response()->noContent();
    }



    // // Aqui eu poderia chamar CategoryRequest para fazer consistências personalizadas
    // public function store(Request $request)
    // {
    //     $this -> validate($request, $this->rules);//Se usasse CategoryRequest, não usaria esse método
    //     $category = Category::create($request -> all());
    //     $category->refresh();
    //     return $category;
    // }

    // public function show(Category $category)
    // {
    //     return $category;
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \App\Models\Category  $category
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, Category $category)
    // {
    //     $this -> validate($request, $this->rules);
    //     $category->update($request->all());
    //     return $category;
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\Models\Category  $category
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy(Category $category)
    // {
    //     $category->delete();
    //     return response()->noContent(); //204 - No content
    // }
}
