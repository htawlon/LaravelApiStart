<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function  postUpdate(Request $request){
        $id=$request['id'];
        $posts=Post::where('id', $id)->with('category')->first();
        $posts->title=$request['title'];
        $posts->body=$request['body'];
        $posts->category_id=$request['category_id'];
        $posts->update();

        return response()->json(['message'=>'The post have been updated.']);
    }
    public function newPost(Request $request){
        $v=Validator::make($request->all(),[
           'title'=>'required',
           'body'=>'required',
            'category_id'=>'required'
        ]);
        if($v->fails()){
            return response()->json($v->errors());
        }
        $p =new Post();
        $p->title=$request['title'];
        $p->body=$request['body'];
        $p->category_id=$request['category_id'];
        $p->save();
        return response()->json(['message'=>"The Post have been created."]);
    }
     public function getPosts(){
         $posts=Post::with("category")->get();
         return response()->json($posts);
     }
     public function getCategory(){
         $cats=Category::with("posts")->get();
         return response()->json($cats);
     }
     public function getPostOne($id){
         $post=Post::whereId($id)->with("category")->get();
         if($post){
             return response()->json($post);
         }else{
             return response()->json(['error'=>"The selected Post not found."]);
         }
     }

}
