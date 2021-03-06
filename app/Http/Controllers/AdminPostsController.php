<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Post;
use App\Http\Requests\PostsCreateRequest;
use Auth;
use App\Photo;
use App\Category;
use Illuminate\Support\Facades\Session;


class AdminPostsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
        $posts = Post::paginate(3);
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
        $categories = Category::pluck('name', 'id')->all();
        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostsCreateRequest $request) {
        //
        $input = $request->all();
        $user = Auth::user();
        if ($file = $request->file('photo_id')) {
            $name = time() . $file->getClientOriginalName();
            $file->move('images', $name);
            $photo = Photo::create(['file' => $name]);
            $input['photo_id'] = $photo->id;
        }
        $user->posts()->create($input);
        return redirect('admin/posts');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
        $post = Post::findOrFail($id);
        $categories = Category::pluck('name', 'id')->all();

        return view('admin.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //


        $post = Post::findOrFail($id);
        //para criar uma slug nova.
        $post->slug = null;
        $input = $request->all();

        if ($file = $request->file('photo_id')) {


            if (property_exists($post->photo(), 'file')) {
                unlink(public_path() . $post->photo->file);
                $post->photo()->delete();
            }

            $name = time() . $file->getClientOriginalName();
            $file->move('images', $name);
            $photo = Photo::create(['file' => $name]);
            $input['photo_id'] = $photo->id;
        }
        Auth::user()->posts()->whereId($id)->first()->update($input);
        return redirect('/admin/posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
        $post = Auth::user()->posts()->whereId($id)->first();
        if (property_exists($post->photo(), 'file')) {
            unlink(public_path() . $post->photo->file);
            $post->photo()->delete();
        }
        $post->delete();
        Session::flash('deleted_post', 'The post has been deleted');
        return redirect('/admin/posts');
    }
    
    public function post($slug){
        $post = Post::whereSlug($slug)->get()->first();
        return view('post', compact('post'));
    }
    
    public function postx($slug){
        $post = Post::whereSlug($slug)->get()->first();
        return view('postx', compact('post'));
    }
    
}
