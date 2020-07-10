<?php

namespace App\Http\Controllers\Api;

use App\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

use App\Http\Requests\Supplier\FileRequest;
use App\Http\Requests\Supplier\StoreRequest;

class SupplierController extends Controller
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
        $suppliers = Supplier::latest()->get();
        return response()->json(
            $this->formatResponse("All suppliers", $suppliers), 200
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        try {
            $slug =  Str::slug($request->input('name'));
            $image = $request->file('photo');
            if (isset($image))
            {
                $currentDate = Carbon::now()->toDateString();
                $imageName = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
                if (!Storage::disk('public')->exists('supplier'))
                {
                    Storage::disk('public')->makeDirectory('supplier');
                }
                $postImage = Image::make($image)->resize(480, 320)->stream();
                Storage::disk('public')->put('supplier/'.$imageName, $postImage);
            } else
            {
                $imageName = 'default.png';
            }
    
            $supplier = new Supplier();
            $supplier->name = $request->get('name');
            $supplier->email = $request->get('email');
            $supplier->phone = $request->get('phone');
            $supplier->address = $request->get('address');
            $supplier->city = $request->get('city');
            $supplier->type = $request->get('type');
            $supplier->shop_name = $request->get('shop_name');
            $supplier->account_holder = $request->get('account_holder');
            $supplier->account_number = $request->get('account_number');
            $supplier->bank_name = $request->get('bank_name');
            $supplier->bank_branch = $request->get('bank_branch');
            $supplier->photo = $imageName;
            if ($supplier->save())
            {
                return response()->json(
                    $this->formatResponse("Supplier created", $supplier), 200
                );
            } else {
                return response()->json(
                    $this->formatResponse("Failed to create supplier"), 500
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
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        try {
            $supplier = Supplier::find($request->id);
            if (!$supplier) return response()->json($this->formatResponse("Data not available"), 400);

            return response()->json(
                $this->formatResponse("1 Supplier", $supplier), 200
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
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRequest $request, $id)
    {
        try {
            $supplier = Supplier::find($id);
            if (!$supplier) return response()->json($this->formatResponse("Data not available"), 400);
    
            $image = $request->file('photo');
            $slug =  Str::slug($request->get('name'));
            if (isset($image))
            {
                $currentDate = Carbon::now()->toDateString();
                $imageName = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
                if (!Storage::disk('public')->exists('supplier'))
                {
                    Storage::disk('public')->makeDirectory('supplier');
                }
    
                // delete old photo
                if (Storage::disk('public')->exists('supplier/'. $supplier->photo))
                {
                    Storage::disk('public')->delete('supplier/'. $supplier->photo);
                }
    
                $postImage = Image::make($image)->resize(480, 320)->stream();
                Storage::disk('public')->put('supplier/'.$imageName, $postImage);
            } else
            {
                $imageName = $supplier->photo;
            }
    
            $supplier->name = $request->get('name');
            $supplier->email = $request->get('email');
            $supplier->phone = $request->get('phone');
            $supplier->address = $request->get('address');
            $supplier->city = $request->get('city');
            $supplier->type = $request->get('type');
            $supplier->shop_name = $request->get('shop_name');
            $supplier->account_holder = $request->get('account_holder');
            $supplier->account_number = $request->get('account_number');
            $supplier->bank_name = $request->get('bank_name');
            $supplier->bank_branch = $request->get('bank_branch');
            $supplier->photo = $imageName;
            if ($supplier->save())
            {
                return response()->json(
                    $this->formatResponse("Supplier updated", $supplier), 200
                );
            } else {
                return response()->json(
                    $this->formatResponse("Failed to update supplier"), 500
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
            $supplier = Supplier::find($id);
            if (!$supplier) return response()->json($this->formatResponse("Data not available"), 400);
            
            $image = $request->file('photo');
            $slug = Str::slug($supplier->name);
            if (isset($image))
            {
                $currentDate = Carbon::now()->toDateString();
                $imageName = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
                if (!Storage::disk('public')->exists('supplier'))
                {
                    Storage::disk('public')->makeDirectory('supplier');
                }
    
                // delete old photo
                if (Storage::disk('public')->exists('supplier/'. $supplier->photo))
                {
                    Storage::disk('public')->delete('supplier/'. $supplier->photo);
                }
    
                $postImage = Image::make($image)->resize(480, 320)->stream();
                Storage::disk('public')->put('supplier/'.$imageName, $postImage);
            } else
            {
                $imageName = $supplier->photo;
            }

            $supplier->photo = $imageName;
            if ($supplier->save())
            {
                return response()->json(
                    $this->formatResponse("Supplier's photo updated", $supplier), 200
                );
            } else {
                return response()->json(
                    $this->formatResponse("Failed to update supplier's photo"), 500
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
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $supplier = Supplier::find($id);
            if (!$supplier) return response()->json($this->formatResponse("Data not available"), 400);

            // delete old photo
            if (Storage::disk('public')->exists('supplier/'. $supplier->photo))
            {
                Storage::disk('public')->delete('supplier/'. $supplier->photo);
            }

            $supplier->delete();
            
            return response()->json(
                $this->formatResponse("Supplier deleted", $supplier), 200
            );
        } catch (\Throwable $th) {
            return response()->json(
                $this->formatResponse("There is an error with the server"), 500
            );
        }
    }
}
