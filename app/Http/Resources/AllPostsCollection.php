<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/*
|--------------------------------------------------------------------------
| Get All the data for all the Posts that are created
|--------------------------------------------------------------------------
|
| Create Response using Eloquent Relationships
|
| TIP: since it's a collection, all posts will have below same structure. 
|
*/

class AllPostsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        // NOTE: $item : references the post being passed in
        return (array) $this->collection->map(function ($item) {
            return [
                // All the posts data
                'id' => $item->id,
                'text' => $item->text,
                'image' => $item->image,
                'created_at' => $item->created_at->format('M D Y'),

                // Comments associated with the post. Since 'hasMany' is being used we have to loop.
                'comments' => $item->comments->map(function ($comment) {
                    return [
                        'id' => $comment->id,
                        'text' => $comment->text,

                        // User who made the comment. Since we are using 'belongsTo' so won't need to loop.
                        'user' => [
                            'id' => $comment->user->id,
                            'name' => $comment->user->name,
                            'image' => $comment->user->image,
                        ]
                    ];
                }),

                // Another 'belongsTo' relationship thus no looping
                'user' => [
                    'id' => $item->user->id,
                    'name' => $item->user->name,
                    'image' => $item->user->image,
                ]
            ];
        });
    }
}
