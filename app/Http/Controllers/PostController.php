<?php

namespace App\Http\Controllers;

use App\Models\CommunityPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Log;

class PostController extends Controller
{

    public function index()
    {
        return inertia('Posts/Index', [
            'posts' => CommunityPost::with('user')->get(),
        ]);
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
