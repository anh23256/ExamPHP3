<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ProductCtroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = Product::query()->latest('id')->paginate(8);
            return response()->json([
                'status' => true,
                'data'   => $data,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'  => false,
                'message' => 'Lỗi hệ thống',
            ],500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'        => ['required', 'max:255', Rule::unique('products')],
            'description' => ['nullable'],
            'price'       => ['required', 'numeric', 'min:1000','max:99999999.99'],
            'quantity'    => ['required', 'numeric', 'min:0'],
            'is_active'   => ['required', Rule::in(0, 1)],
            'image'       => ['required', 'image', 'max:2000'],
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        try {
            $data = $request->except('image');

            if ($request->hasFile('image')) {
                $data['image'] = Storage::put('images', $request->file('image'));
            }

            Product::query()->create($data);

            return response()->json([
                'status'  => true,
                'message' => 'Thành công',
            ],201);
        } catch (\Throwable $th) {

            if (!empty($data['image']) && Storage::exists($data['image'])) {
                Storage::delete($data['image']);
            }

            return response()->json([
                'status'  => false,
                'message' => 'Lỗi hệ thống',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $data = Product::query()->findOrFail($id);

            return response()->json([
                'status' => true,
                'data'   => $data,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'  => false,
                'message' => 'Lỗi hệ thống',
            ],404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(),[
            'name'        => ['required', 'max:255', Rule::unique('products')->ignore($id)],
            'description' => ['nullable'],
            'price'       => ['required', 'numeric', 'min:1000','max:99999999.99'],
            'quantity'    => ['required', 'numeric', 'min:0'],
            'is_active'   => ['required', Rule::in(0, 1)],
            'image'       => ['nullable','image', 'max:2000'],
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        try {
            $product = Product::query()->findOrFail($id);

            $data = $request->except('image');

            if ($request->hasFile('image')) {
                $data['image'] = Storage::put('images', $request->file('image'));
            }

            $product->update($data);

            if (!empty($data['image']) && Storage::exists($data['image'])) {
                Storage::delete($data['image']);
            }

            return response()->json([
                'status'  => true,
                'message' => 'Thành công',
            ]);
        } catch (\Throwable $th) {

            if (!empty($data['image']) && Storage::exists($data['image'])) {
                Storage::delete($data['image']);
            }

            return response()->json([
                'status'  => false,
                'message' => 'Lỗi hệ thống',
            ],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $product = Product::query()->findOrFail($id);

            $currenImage = $product->image;
            
            $product->delete();

            if(Storage::exists($currenImage)){
                Storage::delete($currenImage);
            }

            return response()->json([
                'status' => true,
                'message'=> 'Xóa thành công' 
            ],204);
        } catch (\Throwable $th) {
            return response()->json([
                'status'  => false,
                'message' => 'Lỗi hệ thống',
            ],500);
        }
    }
}
