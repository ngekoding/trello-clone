<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class APITest extends TestCase
{
    public function testUserCreation()
    {
    	$response = $this->json('POST', '/api/register', [
    		'name'     => 'Demo User',
    		'email'    => str_random(10) . '@demo.com',
    		'password' => '1sampai8'
    	]);

    	$response->assertStatus(200)
    			 ->assertJsonStructure([ 'success' => ['token', 'name'] ]);
    }

    public function testUserLogin()
    {
    	$response = $this->json('POST', '/api/login', [
    		'email'    => 'info@ngekoding.com',
    		'password' => '1sampai8'
    	]);

    	$response->assertStatus(200)
    			 ->assertJsonStructure([ 'success' => ['token'] ]);
    }

    public function testCategoryFetch()
    {
    	$user = \App\User::find(1);

    	$response = $this->actingAs($user, 'api')
    		->json('GET', '/api/category')
    		->assertStatus(200)
    		->assertJsonStructure([
    			'*' => [
    				'id',
    				'name',
    				'created_at',
    				'updated_at',
    				'deleted_at'
    			]
    		]);
    }

    public function testCategoryCreation()
    {
    	$this->withoutMiddleware();

    	$response = $this->json('POST', '/api/category', [
    		'name' => str_random(10)
    	]);

    	$response->assertStatus(200)
    			   ->assertJson([ 'status' => true, 'message' => 'Category created!' ]);
    }

    public function testCategoryDeletion()
    {
    	$user = \App\User::find(1);

    	$category = \App\Category::create(['name' => 'To be deleted']);

    	$response = $this->actingAs($user, 'api')
    		->json('DELETE', "/api/category/{$category->id}")
    		->assertStatus(200)
    	    ->assertJson([ 'status' => true, 'message' => 'Category deleted!' ]);
    }
}
