<?php

namespace App\Http\Controllers;

use App\Models\CommunityPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Log;
use App\Events\LikeSent;

class PostController extends Controller
{

    public function index()
    {
        return inertia('Posts/Index', [
            'posts' => CommunityPost::with('user')->get(),
        ]);
    }

    function like(Request $request)
    {
        $post = CommunityPost::find($request->id);

        if ($post) {
            $post->like_count = $post->like_count + 1;
            $post->save();
            $signal = new CommunityPost();
            $signal->id = $post->id;
            broadcast(new LikeSent($signal))->toOthers();
            return $post->like_count;
        } else {
            return response()->json(['error' => 'Post not found'], 404);
        }
    }
    public function create()
    {
        return inertia('Posts/Create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);
        
        CommunityPost::create([
            'title' => $validated['title'],
            'content'  => $validated['content'],
            'user_id' => auth()->id(),
            'like_count' => 0,
        ]);
    
        return redirect()->route('posts.index');
    }
    public function show(CommunityPost $post)
    {
        return inertia('Posts/Show', [
            'post' => $post->load('user'),
        ]);
    }
}
