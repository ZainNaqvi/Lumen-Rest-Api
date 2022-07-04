<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserPost;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class UserPostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['']]);
    }

    public function read()
    {
        // Get All products
        // get All Products From Database
        $post = UserPost::all();
        return response()->json($post);

    }


    public function createPost(Request $request,)
    {
        //POST(request)
        // Store all information of Products to Database
        //in_array()

        $post = new UserPost();
        // if($request->hasFile('photo')) {

        // $allowedfileExtension=['pdf','jpg','png'];
        // $file = $request->file('photo');
        // $extenstion = $file->getClientOriginalExtension();
        // $check = in_array($extenstion, $allowedfileExtension);

        // if($check){
        //     $name = time() . $file->getClientOriginalName();
        //     $file->move('images', $name);
        //     $product->photo = $name;
        // }
        // }
      


        // text data
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->tag = $request->input('tag');
        $post->uid=$request->input('uid');
        $post->save();
        return response()->json($post);


    }


    public function show(Request $request)
    {
        // GET(id)
        // show each product by its ID from database
        
        $post = UserPost::find($id);
        return response()->json($post);
    }


    public function update(Request $request, $id)
    {
        // PUT(id)
        // Update Info by Id

        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'tag' => 'required',
            'uid' => 'required'
         ]);

        $post = UserPost::find($id);


     
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->tag = $request->input('tag');

        $post->save();

        return response()->json($post);

    }


    public function destroy($id)
    {
        // DELETE(id)
        // Delete by Id
        $post = UserPost::find($id);
        $post->delete();
        return response()->json('Post Deleted Successfully');

    }
}