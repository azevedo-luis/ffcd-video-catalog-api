<?php

namespace Tests\Unit\models;

use PHPUnit\Framework\TestCase;
use App\Models\CastMember;

class CastMemberUnitTest extends TestCase
{
    // use DatabaseMigrations;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testFillableAttributes()
    {
        $fillable = ['name', 'type'];
        $castMember = new CastMember();
        $this -> assertEquals($fillable, $castMember -> getFillable());
    }

    public function testIncrementingAttribute(){
        $castMember = new CastMember();
        $this -> assertFalse($castMember->incrementing);
    }

    public function testDatesAttribute(){
        $dates = ['deleted_at', 'created_at', 'updated_at'];
        $castMember = new CastMember();
        foreach ($dates as $date) {
            $this->assertContains($date, $castMember -> getDates());
        }
        $this->assertCount(count($dates), $castMember->getDates());
    }    
}
