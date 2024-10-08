<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Http\Requests\Supplier\StoreSupplierRequest;
use App\Http\Requests\Supplier\UpdateSupplierRequest;
use Str;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::where("user_id", auth()->id())->count();

        return view('suppliers.index', [
            'suppliers' => $suppliers
        ]);
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(StoreSupplierRequest $request)
    {

        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = $file->getClientOriginalName();
            $destinationPath = public_path('uploads');
            $file->move($destinationPath, $filename);
            $filePath = 'uploads/' . $filename;
        }

        Supplier::create([
            "user_id" => auth()->id(),
            "uuid" => Str::uuid(),
            'photo' => $filePath,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'shopname' => $request->shopname,
            'type' => $request->type,
            'account_holder' => $request->account_holder,
            'account_number' => $request->account_number,
            'bank_name' => $request->bank_name,
            'address' => $request->address,
        ]);

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'New supplier has been created!');
    }

    public function show($uuid)
    {
        $supplier = Supplier::where("uuid", $uuid)->firstOrFail();
        $supplier->loadMissing('purchases')->get();

        return view('suppliers.show', [
            'supplier' => $supplier
        ]);
    }

    public function edit($uuid)
    {
        $supplier = Supplier::where("uuid", $uuid)->firstOrFail();
        return view('suppliers.edit', [
            'supplier' => $supplier
        ]);
    }

    public function update(UpdateSupplierRequest $request, $uuid)
    {
        $supplier = Supplier::where("uuid", $uuid)->firstOrFail();

        /**
         * Handle upload image with Storage.
         */

        $existingPhoto = $supplier->photo;

        $destinationPath = public_path('uploads');

// If there is an existing photo, delete it only if a new photo is uploaded
if ($request->hasFile('photo')) {
    // If there is an existing photo, delete it
    if ($existingPhoto) {
        $existingImagePath = $destinationPath . '/' . basename($existingPhoto);
        
        // Check if the file exists before trying to delete it
        if (file_exists($existingImagePath)) {
            unlink($existingImagePath);
        }
    }

    // Store the new photo
    $file = $request->file('photo');
    $filename = $file->getClientOriginalName(); 
    $file->move($destinationPath, $filename);

    // Update the customer's photo path in the database
    $supplier->photo = 'uploads/' . $filename;
}



        $supplier->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'photo' => $supplier->photo,
            'shopname' => $request->shopname,
            'type' => $request->type,
            'account_holder' => $request->account_holder,
            'account_number' => $request->account_number,
            'bank_name' => $request->bank_name,
            'address' => $request->address,
        ]);

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Supplier has been updated!');
    }

    public function destroy($uuid)
    {
        $supplier = Supplier::where("uuid", $uuid)->firstOrFail();
        /**
         * Delete photo if exists.
         */

         $existingPhoto = $supplier->photo;
         $destinationPath = public_path('uploads');
     
         if ($existingPhoto) {
             $existingImagePath = $destinationPath . '/' . basename($existingPhoto);
             
             if (file_exists($existingImagePath)) {
                 unlink($existingImagePath);
             }
         }
     
         $supplier->delete();

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Supplier has been deleted!');
    }
}
