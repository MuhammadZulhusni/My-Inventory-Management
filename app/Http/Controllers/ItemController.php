<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Item;

class ItemController extends Controller
{
    public function dashboardSummary()
    {
        $totalItems = count(Item::all());
        $lastWeekItems = count(Item::whereBetween('created_at', [now()->subWeek(), now()])->get());
        
        $growth = $lastWeekItems > 0 ? round((($totalItems - $lastWeekItems) / $lastWeekItems) * 100) : 0;

        // Fetch low stock items
        $lowStockCount = Item::where('quantity', '<', 10)->count();
        $urgentRestockCount = Item::where('quantity', '<', 5)->count(); // Adjust for urgent restock
    
        return view('admin.dashboard', compact('totalItems', 'growth', 'lowStockCount', 'urgentRestockCount'));
    }

    public function index(Request $request)
    {
        $query = Item::query();
        
        // Search filter
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('sku', 'like', "%$search%");
            });
        }
        
        // Category filter
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }
        
        // Stock status filter
        if ($request->has('stock_status')) {
            switch ($request->stock_status) {
                case 'low':
                    $query->where('quantity', '<', 10);
                    break;
                case 'critical':
                    $query->where('quantity', '<', 5);
                    break;
                case 'out_of_stock':
                    $query->where('quantity', '<=', 0);
                    break;
            }
        }
        
        $items = $query->paginate(10);
        
        return view('admin.items.index', compact('items'));
    }

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
    
    public function destroy($id)
    {
        try {
            $item = Item::findOrFail($id);
            $item->delete();
            
            return redirect()->back()->with('success', 'Item deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting item: ' . $e->getMessage());
        }
    }
}