<?php
namespace App\Http\Controllers;

use App\Events\DepositCreated;
use Illuminate\Http\Request;

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
        // $data = [
        //     'title' => $request->title,
        //     'author' => $request->author,
        // ];
        $data = [
                    'type' => 'Deposit',
                    'transaction_id' => $request->title,
                    'amount' => '1000000',
                    'Currency' => $request->author,
                    'status' => 'pending',
                    'msg' => 'New Deposit Transaction Created!',
                ];
        //  print_r($data); die;
        event(new DepositCreated($data));

        // return redirect()->back()->with('success', 'Post submitted successfully!');
    }
}
