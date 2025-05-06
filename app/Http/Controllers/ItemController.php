<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function create()
    {
        return view('admin.items.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'sku' => 'required|unique:items',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'expiry_date' => 'nullable|date',
            'category' => 'required|integer',
            'description' => 'nullable|string',
            'cost_price' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
    
        $item = new Item();
        $item->name = $request->name;
        $item->description = $request->description;
        $item->sku = $request->sku;
        $item->quantity = $request->quantity;
        $item->price = $request->price;
        $item->cost_price = $request->cost_price;
        $item->expiry_date = $request->expiry_date;
        $item->category = $request->category;

        // Handle image upload
        if($request->hasFile('image')){
            $file = $request->file('image');
            $imageName = date('YmdHi').'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/product_images'), $imageName);
            $item->image = $imageName;
        }

        $item->save();

        return redirect()->route('items.create')->with([
            'swal' => [
                'title' => 'Success!',
                'text' => 'Product added successfully!',
                'icon' => 'success',
                'showConfirmButton' => false,
                'timer' => 2000,
                'position' => 'center',
                'background' => '#f8f9fa',
                'iconColor' => '#28a745'
            ]
        ]);
    }
}