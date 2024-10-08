<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Picqer\Barcode\BarcodeGeneratorHTML;
use Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where("user_id", auth()->id())->count();

        return view('products.index', [
            'products' => $products,
        ]);
    }

    public function create(Request $request)
    {
        $categories = Category::where("user_id", auth()->id())->get(['id', 'name']);
        $units = Unit::where("user_id", auth()->id())->get(['id', 'name']);

        if ($request->has('category')) {
            $categories = Category::where("user_id", auth()->id())->whereSlug($request->get('category'))->get();
        }

        if ($request->has('unit')) {
            $units = Unit::where("user_id", auth()->id())->whereSlug($request->get('unit'))->get();
        }

        return view('products.create', [
            'categories' => $categories,
            'units' => $units,
        ]);
    }

    public function store(StoreProductRequest $request)
    {
        /**
         * Handle upload image
         */

        $request->validate([
            'product_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('product_image')) {
            $file = $request->file('product_image');
            $filename = $file->getClientOriginalName();
            $destinationPath = public_path('uploads');
            $file->move($destinationPath, $filename);
            $filePath = 'uploads/' . $filename;
        }


        Product::create([
            "code" => IdGenerator::generate([
                'table' => 'products',
                'field' => 'code',
                'length' => 4,
                'prefix' => 'PC'
            ]),

            'product_image'     => $filePath,
            'name'              => $request->name,
            'category_id'       => $request->category_id,
            'unit_id'           => $request->unit_id,
            'quantity'          => $request->quantity,
            'buying_price'      => $request->buying_price,
            'selling_price'     => $request->selling_price,
            'quantity_alert'    => $request->quantity_alert,
            'tax'               => $request->tax,
            'tax_type'          => $request->tax_type,
            'notes'             => $request->notes,
            "user_id" => auth()->id(),
            "slug" => Str::slug($request->name, '-'),
            "uuid" => Str::uuid()
        ]);


        return to_route('products.index')->with('success', 'Product has been created!');
    }

    public function show($uuid)
    {
        $product = Product::where("uuid", $uuid)->firstOrFail();
        // Generate a barcode
        $generator = new BarcodeGeneratorHTML();

        $barcode = $generator->getBarcode($product->code, $generator::TYPE_CODE_128);

        return view('products.show', [
            'product' => $product,
            'barcode' => $barcode,
        ]);
    }

    public function edit($uuid)
    {
        $product = Product::where("uuid", $uuid)->firstOrFail();
        return view('products.edit', [
            'categories' => Category::where("user_id", auth()->id())->get(),
            'units' => Unit::where("user_id", auth()->id())->get(),
            'product' => $product
        ]);
    }

    public function update(UpdateProductRequest $request, $uuid)
    {
        $product = Product::where("uuid", $uuid)->firstOrFail();
        // $product->update($request->except('product_image'));


        $existingPhoto = $product->product_image;

        $destinationPath = public_path('uploads');

// If there is an existing photo, delete it only if a new photo is uploaded
if ($request->hasFile('product_image')) {
    // If there is an existing photo, delete it
    if ($existingPhoto) {
        $existingImagePath = $destinationPath . '/' . basename($existingPhoto);
        
        // Check if the file exists before trying to delete it
        if (file_exists($existingImagePath)) {
            unlink($existingImagePath);
        }
    }

    // Store the new photo
    $file = $request->file('product_image');
    $filename = $file->getClientOriginalName(); 
    $file->move($destinationPath, $filename);

    // Update the customer's photo path in the database
    $product->product_image = 'uploads/' . $filename;
}

        $product->name = $request->name;
        $product->slug = Str::slug($request->name, '-');
        $product->category_id = $request->category_id;
        $product->unit_id = $request->unit_id;
        $product->quantity = $request->quantity;
        $product->buying_price = $request->buying_price;
        $product->selling_price = $request->selling_price;
        $product->quantity_alert = $request->quantity_alert;
        $product->tax = $request->tax;
        $product->tax_type = $request->tax_type;
        $product->notes = $request->notes;
        $product->product_image = $product->product_image;
        $product->save();


        return redirect()
            ->route('products.index')
            ->with('success', 'Product has been updated!');
    }

    public function destroy($uuid)
    {
        $product = Product::where("uuid", $uuid)->firstOrFail();
        /**
         * Delete photo if exists.
         */
        // if ($product->product_image) {
        //     // check if image exists in our file system
        //     if (file_exists(public_path('storage/') . $product->product_image)) {
        //         unlink(public_path('storage/') . $product->product_image);
        //     }
        // }

        // $product->delete();

        $existingPhoto = $product->product_image;
         $destinationPath = public_path('uploads');
     
         if ($existingPhoto) {
             $existingImagePath = $destinationPath . '/' . basename($existingPhoto);
             
             if (file_exists($existingImagePath)) {
                 unlink($existingImagePath);
             }
         }
     
         $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Product has been deleted!');
    }
}