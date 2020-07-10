<?php

namespace App\Http\Controllers\Api;

use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

use App\Http\Requests\Product\FileRequest;
use App\Http\Requests\Product\StoreRequest;

class ProductController extends Controller
{
    private function formatResponse($message = "", $data = []) {
        return array(
            "data" => $data,
            "message" => $message
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::latest()->with('category', 'supplier')->get();
        return response()->json(
            $this->formatResponse("All products", $products), 200
        );
    }

    public function store(StoreRequest $request)
    {
        try {
            $image = $request->file('image');
            $slug =  Str::slug($request->input('name'));
            if (isset($image))
            {
                $currentDate = Carbon::now()->toDateString();
                $imageName = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
                if (!Storage::disk('public')->exists('product'))
                {
                    Storage::disk('public')->makeDirectory('product');
                }
                $postImage = Image::make($image)->resize(480, 320)->stream();
                Storage::disk('public')->put('product/'.$imageName, $postImage);
            } else
            {
                $imageName = 'default.png';
            }
    
            $product = new Product();
            $product->name = $request->input('name');
            $product->category_id = $request->input('category_id');
            $product->supplier_id = $request->input('supplier_id');
            $product->code = $request->input('code');
            $product->buying_date = $request->input('buying_date');
            $product->expire_date = $request->input('expire_date');
            $product->buying_price = $request->input('buying_price');
            $product->selling_price = $request->input('selling_price');
            $product->image = $imageName;
            if ($product->save())
            {
                return response()->json(
                    $this->formatResponse("Product created", $product), 200
                );
            } else {
                return response()->json(
                    $this->formatResponse("Failed to create product"), 500
                );
            }
        } catch (\Throwable $throw) {
            return response()->json(
                $this->formatResponse("There is an error with the server"), 500
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        try {
            $product = Product::find($request->id);
            if (!$product) return response()->json($this->formatResponse("Data not available"), 400);

            return response()->json(
                $this->formatResponse("1 Product", $product), 200
            );
        } catch (\Throwable $th) {
            return response()->json(
                $this->formatResponse("There is an error with the server"), 500
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $product = Product::find($id);
            if (!$product) return response()->json($this->formatResponse("Data not available"), 400);
    
            $image = $request->file('image');
            $slug =  Str::slug($request->input('name'));
            if (isset($image))
            {
                $currentDate = Carbon::now()->toDateString();
                $imageName = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
                if (!Storage::disk('public')->exists('product'))
                {
                    Storage::disk('public')->makeDirectory('product');
                }
    
                // delete old photo
                if (Storage::disk('public')->exists('product/'. $product->image))
                {
                    Storage::disk('public')->delete('product/'. $product->image);
                }
    
                $postImage = Image::make($image)->resize(480, 320)->stream();
                Storage::disk('public')->put('product/'.$imageName, $postImage);
            } else
            {
                $imageName = $product->image;
            }
    
            $buying_date = $request->input('buying_date');
            if (!isset($buying_date))
            {
                $buying_date = $product->buying_date;
            }
    
            $expire_date = $request->input('expire_date');
            if (!isset($expire_date))
            {
                $expire_date = $product->expire_date;
            }
    
            $product->name = $request->input('name');
            $product->category_id = $request->input('category_id');
            $product->supplier_id = $request->input('supplier_id');
            $product->code = $request->input('code');
            $product->buying_date = $buying_date;
            $product->expire_date = $expire_date;
            $product->buying_price = $request->input('buying_price');
            $product->selling_price = $request->input('selling_price');
            $product->image = $imageName;
            if ($product->save())
            {
                return response()->json(
                    $this->formatResponse("Product updated", $product), 200
                );
            } else {
                return response()->json(
                    $this->formatResponse("Failed to update product"), 500
                );
            }
        } catch (\Throwable $th) {
            return response()->json(
                $this->formatResponse("There is an error with the server"), 500
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function updatePhoto(FileRequest $request, $id)
    {
        try {
            $product = Product::find($id);
            if (!$product) return response()->json($this->formatResponse("Data not available"), 400);
            
            $image = $request->file('photo');
            $slug = Str::slug($product->name);
            if (isset($image))
            {
                $currentDate = Carbon::now()->toDateString();
                $imageName = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
                if (!Storage::disk('public')->exists('product'))
                {
                    Storage::disk('public')->makeDirectory('product');
                }
    
                // delete old photo
                if (Storage::disk('public')->exists('product/'. $product->image))
                {
                    Storage::disk('public')->delete('product/'. $product->image);
                }
    
                $postImage = Image::make($image)->resize(480, 320)->stream();
                Storage::disk('public')->put('product/'.$imageName, $postImage);
            } else
            {
                $imageName = $product->image;
            }

            $product->photo = $imageName;
            if ($product->save())
            {
                return response()->json(
                    $this->formatResponse("Product's photo updated", $product), 200
                );
            } else {
                return response()->json(
                    $this->formatResponse("Failed to update product's photo"), 500
                );
            }
        } catch (\Throwable $th) {
            return response()->json(
                $this->formatResponse("There is an error with the server"), 500
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $product = Product::find($id);
            if (!$product) return response()->json($this->formatResponse("Data not available"), 400);

            // delete old photo
            if (Storage::disk('public')->exists('product/'. $product->image))
            {
                Storage::disk('public')->delete('product/'. $product->image);
            }

            $product->delete();
            
            return response()->json(
                $this->formatResponse("Product deleted", $product), 200
            );
        } catch (\Throwable $th) {
            return response()->json(
                $this->formatResponse("There is an error with the server"), 500
            );
        }
    }
}
