<?php

namespace Tests\Feature\models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\Genre;
use Tests\TestCase;

class GenreTest extends TestCase
{
    use DatabaseMigrations;

    public function testList(){
        // $genre = genre::create([ 
        //     'name' => 'test1'
        // ]);
        factory(Genre::class, 1)->create();
        $genres = Genre::all();
        $this->assertCount(1, $genres);
        $genreKeys = array_keys($genres->first()->getAttributes()); 
        $this->assertEqualsCanonicalizing(
            ['id', 
            'name', 
            'created_at', 
            'deleted_at', 
            'updated_at',
            'is_active'], 
            $genreKeys);

    }

    public function testCreate(){
        $genre = Genre::create([ 
            'name' => 'test1'
        ]);
        $genre -> refresh();
        $this->assertEquals(36, strlen($genre->id));
        $this->assertEquals('test1', $genre->name);
        $this->assertTrue($genre->is_active);  
        
        $genre = Genre::create([ 
            'name' => 'test1',
            'is_active' => false
        ]);      
        $genre -> refresh();  
        $this->assertFalse($genre->is_active);    
        
        $genre = Genre::create([ 
            'name' => 'test1',
            'is_active' => true
        ]);      
        $genre -> refresh();  
        $this->assertTrue($genre->is_active);          
    }

    public function testUpdate(){
        $genre = factory(Genre::class)->create([
            'is_active' => false
        ])->first();
        
        $data = [
            'name' => 'test_name_updated',
            'is_active' => true
        ];
        $genre -> update($data);

        foreach ($data as $key => $value) {
            $this->assertEquals($value, $genre->{$key});
        }        
    }   
    
    public function testDelete(){
        $genre = factory(Genre::class)->create();   
        $genre->delete();
        $this->assertNull(Genre::find($genre->id));

        $genre->restore();
        $this->assertNotNull(Genre::find($genre->id));

    }    
}
