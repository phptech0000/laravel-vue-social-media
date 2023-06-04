<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Services\ImageService;
use App\Http\Resources\AllPostsCollection;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all posts in descending order
        $posts = Post::orderBy("created_at", 'desc')->get();
        return Inertia::render('Posts', [
            'posts' => new AllPostsCollection($posts)
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation first
        $request->validate(['text' => 'required']);

        $post = new Post();

        // Since image is optional
        if ($request->hasFile('image')) {
            // Check it's type
            $request->validate(['image' => 'required|mimes:png,jpg,jpeg']);
            $post = (new ImageService())->updateImage($post, $request);
        }

        // Update user_id on the Post table
        $post->user_id = auth()->user()->id;

        // Retrieve a text input from $request
        $post->text = $request->input('text');
        $post->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $post = Post::find($id);

        if (!empty($post->image)) {
            $currentImage = public_path() . $post->image;

            if (file_exists($currentImage)) {
                unlink($currentImage);
            }
        }

        $post->delete();
    }
}
