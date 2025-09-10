<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Events\DepositCreated;

class PostController extends Controller
{
    public function showForm()
     {
        return view('post');
     }
     
    public function save(Request $request)
    {
        $post_data = $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
        ]);

        // Create the post
        // $post = Post::create($post_data);

        // Broadcast the event
        $data = [
            'title' => $request->title,
            'author' => $request->author,
        ];
        //  print_r($data); die;
        event(new DepositCreated($data));

        // return redirect()->back()->with('success', 'Post submitted successfully!');
    }
}
