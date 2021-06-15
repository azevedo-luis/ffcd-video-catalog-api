<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    private $rules = [
        'name' => 'required|max:255',
        'is_active' => 'boolean'        
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Genre::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this -> validate($request, $this->rules);//Se usasse CategoryRequest, não usaria esse método
        $genre = Genre::create($request -> all());
        $genre->refresh();
        return $genre;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Genre  $Genre
     * @return \Illuminate\Http\Response
     */
    public function show(Genre $Genre)
    {
        return $Genre;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Genre  $Genre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Genre $Genre)
    {
        $this -> validate($request, $this->rules);
        $Genre->update($request->all());
        return $Genre;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Genre  $Genre
     * @return \Illuminate\Http\Response
     */
    public function destroy(Genre $Genre)
    {
        $Genre->delete();
        return response()->noContent(); //204 - No content
    }
}
