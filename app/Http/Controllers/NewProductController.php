<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;

class NewProductController extends Controller
{
    public function newProductAdminPost(Request $request)
    {
        $images = $request->file('images');

        foreach($images as $image) {
            $validator = Validator::make(['image' => $image], [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
        }

        if (!$validator->fails()) {
            $newProduct = new Product();
            $newProduct->name = $request->input("name");
            $newProduct->price = $request->input("price");
            $newProduct->description = $request->input("info");
            $newProduct->stock = $request->input("count");
            $newProduct->type = $request->input("type");
            $newProduct->created_at = Carbon::now();
            $newProduct->updated_at = Carbon::now();
            $newProduct->save();

            foreach($images as $image) {
                $imageName = $image->getClientOriginalName();
                $extension = $image->getClientOriginalExtension();
                $publicImagesFolder = public_path('images');

                $counter = 1;
                $imageNameNew = $imageName;
                while (file_exists($publicImagesFolder . '/' . $imageNameNew)) {
                    $imageNameNew = pathinfo($imageName, PATHINFO_FILENAME) . "($counter).$extension";
                    $counter++;
                }
            
                $image->move($publicImagesFolder, $imageNameNew);

                $newImage = new Image();
                $newImage->name = $imageNameNew;
                $newImage->product_id = $newProduct->id;
                $newImage->url = 'http://localhost:8000/images/' . $imageName;
                $newImage->created_at = Carbon::now();
                $newImage->updated_at = Carbon::now();
                $newImage->save();
            }
            return Redirect::route('detail', ['id' => $newProduct->id]);
        }
        return Redirect::route('products');
    }
}
