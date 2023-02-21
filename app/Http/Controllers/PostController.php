<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Repository\PostRepository;
use Illuminate\Http\Request;

use function Termwind\render;

class PostController extends Controller
{

    protected $postRepo;

    public function __construct(PostRepository $postRepo){
        $this->postRepo = $postRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->postRepo->all();
        return view('posts.index', compact('posts'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([

            // 'user_id' => auth()->user()->id,

            'title' => 'required',
            'description' => 'required',


        ]);
        $postRepo = new Post();
        $data=($request->all());
        $data['user_id'] = auth()->user()->id;
        
        $this->postRepo->store($data);

        return redirect()->route('posts.index')->with('success','Post has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('posts.show',compact('post'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $post = $this->postRepo->get($id);
        return view('posts.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {

        $request->validate([

            'title' => 'required',
            'description' => 'required',
        ]);



       $this->postRepo->update($id, $request->all());

        return redirect()->route('posts.index')->with('success','Post Has Been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->postRepo->delete($id);
        return redirect()->route('posts.index')->with('success','Post has been deleted successfully');
    }

}
