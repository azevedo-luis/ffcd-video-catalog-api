<?php

namespace Tests\Feature\models;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\CastMember;
use Tests\TestCase;

class CastMemberTest extends TestCase
{
    use DatabaseMigrations;

    
    public function testList(){
        factory(CastMember::class, 1)->create();
        $castMembers = CastMember::all();
        $this->assertCount(1, $castMembers);
        $castMemberKeys = array_keys($castMembers->first()->getAttributes()); 
        $this->assertEqualsCanonicalizing(
            ['id', 
            'name', 
            'type', 
            'created_at', 
            'deleted_at', 
            'updated_at'], 
            $castMemberKeys);

    }

    public function testCreate(){
        $castMember = CastMember::create([ 
            'name' => 'test1',
            'type' => CastMember::TYPE_ACTOR
        ]);
        $castMember -> refresh();
        $this->assertEquals(36, strlen($castMember->id));
        $this->assertEquals('test1', $castMember->name);
        $this->assertEquals(CastMember::TYPE_ACTOR,$castMember->type);


        $castMember = CastMember::create([ 
            'name' => 'test1',
            'type' => CastMember::TYPE_ACTOR,
        ]);      
        $castMember -> refresh();  
        $this->assertEquals(CastMember::TYPE_ACTOR, $castMember->type);    
        
        $castMember = CastMember::create([ 
            'name' => 'test1',
            'type' => CastMember::TYPE_DIRECTOR,
        ]);      
        $castMember -> refresh();  
        $this->assertEquals(CastMember::TYPE_DIRECTOR, $castMember->type);         
    }

    public function testUpdate(){
        $castMember = factory(CastMember::class)->create([
            'name' => 'test_name',
            'type' => CastMember::TYPE_ACTOR
        ])->first();
        
        $data = [
            'name' => 'test_name_updated',
            'type' => CastMember::TYPE_DIRECTOR
        ];
        $castMember -> update($data);

        foreach ($data as $key => $value) {
            $this->assertEquals($value, $castMember->{$key});
        }        
    }   
    
    public function testDelete(){
        $castMember = factory(CastMember::class)->create();   
        $castMember->delete();
        $this->assertNull(CastMember::find($castMember->id));

        $castMember->restore();
        $this->assertNotNull(CastMember::find($castMember->id));

    }
}
