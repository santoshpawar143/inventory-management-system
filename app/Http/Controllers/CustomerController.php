<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use Str;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::where('user_id', auth()->id())->count();

        return view('customers.index', [
            'customers' => $customers
        ]);
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(StoreCustomerRequest $request)
    {
        /**
         * Handle upload an image
         */

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

       
        Customer::create([
            'user_id' => auth()->id(),
            'uuid' => Str::uuid(),
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
            ->route('customers.index')
            ->with('success', 'New customer has been created!');
    }

    public function show($uuid)
    {
        $customer = Customer::where('uuid', $uuid)->firstOrFail();
        $customer->loadMissing(['quotations', 'orders'])->get();

        return view('customers.show', [
            'customer' => $customer
        ]);
    }

    public function edit($uuid)
    {
        $customer = Customer::where('uuid', $uuid)->firstOrFail();
        return view('customers.edit', [
            'customer' => $customer
        ]);
    }

    public function update(UpdateCustomerRequest $request, $uuid)
    {
        $customer = Customer::where('uuid', $uuid)->firstOrFail();

        /**
         * Handle upload image with Storage.
         */

        $existingPhoto = $customer->photo;

        // Define the destination path for uploads
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
    $customer->photo = 'uploads/' . $filename;
}


        $customer->update([
            'photo' => $customer->photo,
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
            ->route('customers.index')
            ->with('success', 'Customer has been updated!');
    }

    public function destroy($uuid)
    {
        $customer = Customer::where('uuid', $uuid)->firstOrFail();
    

        $existingPhoto = $customer->photo;
         $destinationPath = public_path('uploads');
     
         if ($existingPhoto) {
             $existingImagePath = $destinationPath . '/' . basename($existingPhoto);
             
             if (file_exists($existingImagePath)) {
                 unlink($existingImagePath);
             }
         }
     
         $customer->delete();

        return redirect()
            ->back()
            ->with('success', 'Customer has been deleted!');
    }
}