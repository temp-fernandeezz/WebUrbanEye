<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use HTMLPurifier;
use HTMLPurifier_Config;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::get();
        return view('pages.blog', compact('posts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'tags' => 'nullable|array',
            'tags.*' => 'string',
            'banner' => 'nullable|string',
            'summary' => 'nullable|string',
        ]);
    
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);
        $validated['content'] = $purifier->purify($validated['content']);
    
        Post::create($validated);

        return response()->json($validated);
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('pages.posts.index', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->update($request->all());

        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return response()->json(null, 204);
    }

}
