<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Product::query()->latest('id')->paginate(8);

        return view('products.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'name'        => ['required', 'max:255', Rule::unique('products')],
            'description' => ['nullable'],
            'price'       => ['required', 'numeric', 'min:1000', 'max:99999999.99'],
            'quantity'    => ['required', 'numeric', 'min:0'],
            'is_active'   => ['required', Rule::in(0, 1)],
            'image'       => ['required', 'image', 'max:2000'],
        ]);

        try {
            $data = $request->except('image');

            if($request->hasFile('image')){
                $data['image'] = Storage::put('images', $request->file('image'));
            }

            Product::query()->create($data);

            return redirect()->route('products.index')->with('success', true);

        } catch (\Throwable $th) {
            Log::error(__CLASS__. '@' . __FUNCTION__, ['errors' => $th->getMessage()]);

            if(!empty($data['image']) && Storage::exists($data['image'])){
                Storage::delete($data['image']);
            }

            return back()->with('success', false);
        }
    }
}
