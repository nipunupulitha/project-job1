<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\User;
use App\Models\Post;
use Tests\TestCase;
// use App\Models\{
//     User,
//     Post
// };

class PostTest extends TestCase
{


    public function  test_a_logged_in_user_can_create_a_new_post(){

        //create user
        $user = User::factory()->create();

        //login user

        $response = $this->post('/login', [
            'email' =>$user->email,
            'password' => 'password'
        ]);
        $this->assertAuthenticated();

        //create a post

       $response = $this->from(route('posts.create'))->post(route('posts.store'),[
            'title' => 'test title112',
            'description' => 'test description112'
        ]);

        // $this->assertEquals(1,Post::count());
        $response->assertStatus(302); //redirect
        $response->assertRedirect(route('posts.index'));


        // $post = Post::first();
        // $this->assertEquals($post->user_id, $user->id);

        // $this->assertEquals($post->title, 'test title112');
        // $this->assertEquals($post->description, 'test description');


}

    public function test_a_logged_in_user_view_posts(){

           //create user
           $user = User::factory()->create();

           //login user
           $response = $this->post('/login', [
               'email' =>$user->email,
               'password' => 'password'
           ]);
           $this->assertAuthenticated();

           //create a post
          $response = $this->from(route('posts.create'))->post(route('posts.store'),[
               'title' => 'test title112',
               'description' => 'test description112'
           ]);
    }

    public function test_a_logged_in_user_can_update_post(){

        //create user
        $user = User::factory()->create();

        //login user
        $response = $this->post('/login', [
            'email' =>$user->email,
            'password' => 'password'
        ]);
        $this->assertAuthenticated();

        //create a post
       $response = $this->from(route('posts.create'))->post(route('posts.store'),[
            'title' => 'test title112',
            'description' => 'test description1123'
        ]);


        $post = Post::first();
        //Update the post
        $response = $this->put(route('posts.update', $post->id),[
            'title' => 'updated title',
            'description' => 'updated description'
        ]);

        $updated_post = Post::first();

        //check updated value
        $this->assertEquals('updated title', $updated_post->title);
        $this->assertEquals('updated description', $updated_post->description);

    }

    public function  test_usercan_delete_the_post(){

        //create user
        $user = User::factory()->create();

        //login user

        $response = $this->post('/login', [
            'email' =>$user->email,
            'password' => 'password'
        ]);
        $this->assertAuthenticated();

        //create a post

       $response = $this->from(route('posts.create'))->post(route('posts.store'),[
            'title' => 'test title112',
            'description' => 'test description112'
        ]);



        $post = Post::first();// post list eke udama eka delete wenne

        //delete post
        $response = $this->delete(route('posts.destroy', $post->id));

     

    }

}
