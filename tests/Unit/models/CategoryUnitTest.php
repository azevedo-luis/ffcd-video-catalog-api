<?php

namespace Tests\Unit\modelsß;

use PHPUnit\Framework\TestCase;
use App\Models\Category;
use App\Models\Genre;

class CategoryUnitTest extends TestCase
{
    // use DatabaseMigrations;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testFillableAttributes()
    {
        // Genre::create(['name' => 'teste']);
        $fillable = ['name', 'description', 'is_active'];
        $category = new Category();
        $this -> assertEquals($fillable, $category -> getFillable());
    }

    public function testIncrementingAttribute(){
        $category = new Category();
        $this -> assertFalse($category->incrementing);
    }

    public function testDatesAttribute(){
        $dates = ['deleted_at', 'created_at', 'updated_at'];
        $category = new Category();
        foreach ($dates as $date) {
            $this->assertContains($date, $category -> getDates());
        }
        $this->assertCount(count($dates), $category->getDates());
    }    
}
