<?php

namespace Tests\Unit\models;

use PHPUnit\Framework\TestCase;
use App\Models\Genre;

class GenreUnitTest extends TestCase
{
    // use DatabaseMigrations;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testFillableAttributes()
    {
        $fillable = ['name', 'is_active'];
        $genre = new Genre();
        $this -> assertEquals($fillable, $genre -> getFillable());
    }

    public function testIncrementingAttribute(){
        $genre = new Genre();
        $this -> assertFalse($genre->incrementing);
    }

    public function testDatesAttribute(){
        $dates = ['deleted_at', 'created_at', 'updated_at'];
        $genre = new Genre();
        foreach ($dates as $date) {
            $this->assertContains($date, $genre -> getDates());
        }
        $this->assertCount(count($dates), $genre->getDates());
    }    
}
