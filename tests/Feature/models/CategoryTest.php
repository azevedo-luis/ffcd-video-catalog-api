<?php

namespace Tests\Feature\models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\Category;
use Tests\TestCase;
// php artisan make:test models/CategoryTest
class CategoryTest extends TestCase
{
    use DatabaseMigrations;
    // /**
    //  * A basic feature test example.
    //  *
    //  * @return void
    //  */
    // public function testExample()
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }
    
    public function testList(){
        // $category = Category::create([ 
        //     'name' => 'test1'
        // ]);
        factory(Category::class, 1)->create();
        $categories = Category::all();
        $this->assertCount(1, $categories);
        $categoryKeys = array_keys($categories->first()->getAttributes()); 
        $this->assertEqualsCanonicalizing(
            ['id', 
            'name', 
            'description', 
            'created_at', 
            'deleted_at', 
            'updated_at',
            'is_active'], 
            $categoryKeys);

    }

    public function testCreate(){
        $category = Category::create([ 
            'name' => 'test1'
        ]);
        $category -> refresh();
        $this->assertEquals(36, strlen($category->id));
        $this->assertEquals('test1', $category->name);
        $this->assertNull($category->description);
        $this->assertTrue($category->is_active);

        $category = Category::create([ 
            'name' => 'test1',
            'description' => null,
        ]);      
        $category -> refresh();  

        $this->assertNull($category->description);

        $category = Category::create([ 
            'name' => 'test1',
            'description' => 'teste_description',
        ]);      
        $category -> refresh();  
        $this->assertEquals('teste_description', $category->description);    
        
        $category = Category::create([ 
            'name' => 'test1',
            'is_active' => false
        ]);      
        $category -> refresh();  
        $this->assertFalse($category->is_active);    
        
        $category = Category::create([ 
            'name' => 'test1',
            'is_active' => true
        ]);      
        $category -> refresh();  
        $this->assertTrue($category->is_active);          
    }

    public function testUpdate(){
        $category = factory(Category::class)->create([
            'description' => 'test_description',
            'is_active' => false
        ])->first();
        
        $data = [
            'name' => 'test_name_updated',
            'description' => 'test_description_updated',
            'is_active' => true
        ];
        $category -> update($data);

        foreach ($data as $key => $value) {
            $this->assertEquals($value, $category->{$key});
        }        
    }   
    
    public function testDelete(){
        $category = factory(Category::class)->create();   
        $category->delete();
        $this->assertNull(Category::find($category->id));

        $category->restore();
        $this->assertNotNull(Category::find($category->id));

    }
}
