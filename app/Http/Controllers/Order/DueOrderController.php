<?php

namespace App\Http\Controllers\Order;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Mail\StockAlert;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class DueOrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('due', '>', '0')
            ->latest()
            ->with('customer')
            ->get();

        return view('due.index', [
            'orders' => $orders
        ]);
    }

    public function show(Order $order)
    {
        $order->loadMissing(['customer', 'details'])->get();

        return view('due.show', [
           'order' => $order
        ]);
    }

    public function edit(Order $order)
    {
        $order->loadMissing(['customer', 'details'])->get();

        $customers = Customer::select(['id', 'name'])->get();

        return view('due.edit', [
            'order' => $order,
            'customers' => $customers
        ]);
    }

    public function update(Order $order, Request $request)
    {
        $rules = [
            'pay' => 'required|numeric'
        ];

        $validatedData = $request->validate($rules);

        $mainPay = $order->pay;
        $mainDue = $order->due;

        $paidDue = $mainDue - $validatedData['pay'];
        $paidPay = $mainPay + $validatedData['pay'];

        $order->update([
            'due' => $paidDue,
            'pay' => $paidPay
        ]);
        // no more due
        if ($paidDue == 0) {

            $order->update([
                'order_status' => 1
            ]);

            $products = OrderDetails::where('order_id', $order->id)->get();

            $stockAlertProducts = [];

            foreach ($products as $product) {
                $productEntity = Product::where('id', $product->product_id)->first();
                $newQty = $productEntity->quantity - $product->quantity;
                if ($newQty < $productEntity->quantity_alert) {
                    $stockAlertProducts[] = $productEntity;
                }
                $productEntity->update(['quantity' => $newQty]);
            }

            if (count($stockAlertProducts) > 0) {

                $adminEmail = User::pluck('email')->first(); 

                if ($adminEmail) {
                    try {
                        // Prepare the email content
                        $emailContent = "The following products are going out of stock:\n\n";
    
                        foreach ($stockAlertProducts as $product) {
                            $emailContent .= "Product Name: {$product->name}\n";
                            $emailContent .= "Current Stock: {$product->quantity}\n";
                            $emailContent .= "Alert If Below: {$product->quantity_alert}\n\n";
                        }
    
                        // Send the email
                        Mail::raw($emailContent, function ($message) use ($adminEmail) {
                            $message->to($adminEmail)
                                    ->subject('Stock Alert');
                        });
                    } catch (\Exception $e) {
                        \Log::error('Email not sent: ' . $e->getMessage());
                        return redirect()->route('due.index')->with('error', 'Failed to send email notification.');
                    }
                }

            }

            
        }

        return redirect()
            ->route('due.index')
            ->with('success', 'Due amount has been updated!');
    }
}