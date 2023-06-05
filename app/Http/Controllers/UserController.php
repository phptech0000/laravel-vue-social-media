<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Services\ImageService;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Resources\AllPostsCollection;

class UserController extends Controller
{
    public function index()
    {
        // Get all the posts where the user_id is equal to logged in user id
        // Order it by created_at in descending order
        $posts = Post::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();

        // TODO: Try alternative syntax to retrieve from relationship of authenticated user.
        // NOTE: if the relationship method in the User model is named posts, then below works.
        // $posts = auth()->user()->posts()
        //     ->orderBy('created_at', 'desc')
        //     ->get();

        return Inertia::render("User", [
            // Reuse AllPostsCollection Resource.
            "posts" => new AllPostsCollection($posts)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $posts = Post::where('user_id', $id)->orderBy('created_at', 'desc')->get();
        return Inertia::render("User", [
            "user" => User::find($id),
            "posts" => new AllPostsCollection($posts)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateImage(Request $request, string $id)
    {
        // Validate to make sure image is present
        $request->validate(["image" => "required|mimes:png,jpg,jpeg"]);
        $user = (new ImageService())->updateImage(auth()->user(), $request);
        $user->save();
    }
}
