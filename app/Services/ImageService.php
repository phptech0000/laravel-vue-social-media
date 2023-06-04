<?php
declare(strict_types=1);

namespace App\Services;

use Image;
use App\Models\{Post, User};
use Illuminate\Http\Request;


class ImageService
{
    public function updateImage(Post|User $model, Request $request): Post|User
    {
        $image = Image::make($request->file('image'));

        if (!empty($model->image)) {
            $currentImage = public_path() . $model->image;

            // If file exists and not the default avatar
            if (file_exists($currentImage) && $currentImage != public_path() . "/images/user-placeholder.png") {
                // Delete it
                unlink($currentImage);
            }
        }

        // Otherwise
        $file = $request->file['image'];
        $extension = $file->getClientOriginalExtension();

        if ($request->width) {
            // crop it accordingly
            $image->crop(
                $request->width,
                $request->height,
                $request->left,
                $request->top,
            );
        }

        $name = time() . '.' . $extension;

        // Save the new file by it's name into public/images directory
        $image->save(public_path() . '/images/' . $name);

        // Save a copy to Database too
        $model->image = '/images/' . $name;

        return $model;
    }
}
