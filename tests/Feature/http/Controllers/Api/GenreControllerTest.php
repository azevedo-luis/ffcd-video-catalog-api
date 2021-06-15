<?php

namespace Tests\Feature\http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Genre;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\TestResponse;

class GenreControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testIndex()
    {
        $genre = factory(Genre::class)->create();
        $response = $this->get(route('genres.index'));

        $response
            ->assertStatus(200)
            ->assertJson([$genre->toArray()]);
    }

    public function testShow()
    {
        $genre = factory(Genre::class)->create();
        $response = $this->get(route('genres.show', ['genre' => $genre->id]));

        $response
            ->assertStatus(200)
            ->assertJson($genre->toArray());
    }    

    public function testInvalidationData(){
        $response = $this->json('POST', route('genres.store'), []);
        $this->assertInvalidationRequired($response);

        $response = $this->json('POST', route('genres.store'), [
            'name' => str_repeat('a', 256),
            'is_active' => 'a'
        ]);
        $this->assertInvalidationMax($response);
        $this->assertInvalidationBoolean($response);  
    
        
        $genre = factory(genre::class)->create();
        $response = $this->json('PUT', route('genres.update', ['genre' => $genre->id]), []);
        $this->assertInvalidationRequired($response);                   
        
        $genre = factory(genre::class)->create();
        $response = $this->json('PUT', route('genres.update', ['genre' => $genre->id]), 
            [
                'name' => str_repeat('a', 256),
                'is_active' => 'a'                
            ]);
        $this->assertInvalidationMax($response); 
        $this->assertInvalidationBoolean($response);                 
    }

    public function testStore(){
        $response = $this->json('POST', route('genres.store'), [
            'name' => 'test',
        ]);
        $id = $response->json('id');
        $genre = genre::find($id);
        $response
            ->assertStatus(201)
            ->assertJson($genre->toArray());
        $this->assertTrue($response->json('is_active'));

        $response = $this->json('POST', route('genres.store'), [
            'name' => 'test',
            'is_active' => false,
        ]);
        $response
            ->assertStatus(201)
            ->assertJsonFragment([
                'is_active' => false,
            ]);     
    }

    public function testUpdate(){
        $genre = factory(genre::class)->create([
            'name' => 'name',
            'is_active' => false,
        ]);
        $response = $this->json('PUT', route('genres.update', ['genre' => $genre->id]), [
            'name' => 'test',
            'is_active' => true,
        ]);
        $id = $response->json('id');
        $genre = genre::find($id);
        $response
            ->assertStatus(200)
            ->assertJson($genre->toArray())
            ->assertJsonFragment([
                'name' => 'test',
                'is_active' => true,

            ]);   

        $response = $this->json('PUT', route('genres.update', ['genre' => $genre->id]), [
            'name' => '',
            'is_active' => true,
        ]);
        $this->assertInvalidationRequired($response);           
    }

    public function testDestroy(){
        $genre = factory(Genre::class)->create();
        $response = $this->json('DELETE', route('genres.destroy', ['genre' => $genre->id]), []);
        $response->assertStatus(204);
        $this->assertNull(Genre::find($genre->id));
        $this->assertNotNull(Genre::withTrashed()->find($genre->id));         
    }

    protected function assertInvalidationRequired(TestResponse $response){
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name'])
            ->assertJsonMissingValidationErrors(['is_active'])
            ->assertJsonFragment([
                \Lang::get('validation.required', ['attribute' => 'name']),
            ]);
    }

    protected function assertInvalidationMax(TestResponse $response){
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name'])
            ->assertJsonFragment([
                \Lang::get('validation.max.string', ['attribute' => 'name', 'max' => 255]),
            ]);
    }    

    protected function assertInvalidationBoolean(TestResponse $response){
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['is_active'])
            ->assertJsonFragment([
                \Lang::get('validation.boolean', ['attribute' => 'is active']),
            ]);         
    }
}
