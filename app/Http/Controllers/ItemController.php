<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Item;
use Carbon\Carbon;

class ItemController extends Controller
{
    public function dashboardSummary()
    {
        $totalItems = Item::count();
        $lastWeekItems = Item::whereBetween('created_at', [now()->subWeek(), now()])->count();
        
        $growth = $lastWeekItems > 0 ? round((($totalItems - $lastWeekItems) / $lastWeekItems) * 100) : 0;

        $lowStockCount = Item::where('quantity', '<', 10)->count();
        $urgentRestockCount = Item::where('quantity', '<', 5)->count();

        $expiringSoonCount = Item::whereBetween('expiry_date', [now(), now()->addDays(7)])->count();
    
        return view('admin.dashboard', compact('totalItems', 'growth', 'lowStockCount', 'urgentRestockCount', 'expiringSoonCount'));
    }

    public function index(Request $request)
    {
        $query = Item::query();
    
        // Search filter
        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('sku', 'like', "%{$request->search}%");
            });
        }
    
        // Category filter
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
    
        // Stock status filter
        if ($request->has('stock_status')) {
            $condition = $this->getStockStatusCondition($request->stock_status);
            $query->where('quantity', $condition[0], $condition[1]);
        }
    
        // Expiring soon filter (within next 7 days)
        if ($request->has('expiring') && $request->expiring === 'soon') {
            $today = \Carbon\Carbon::today();
            $next7Days = \Carbon\Carbon::today()->addDays(7);
            $query->whereBetween('expiry_date', [$today, $next7Days]);
        }

        // Flags to control modals
        $showExpiringSoonModal = $request->has('expire') && $request->expire === 'true';
        $showUrgentStockModal = $request->has('urgent') && $request->urgent === 'true';

        // Get paginated results
        $items = $query->latest()->paginate(10)->withQueryString();
    
        return view('admin.items.index', compact('items', 'showExpiringSoonModal', 'showUrgentStockModal'));
    }
    
    
    protected function getStockStatusCondition($status)
    {
        return match ($status) {
            'low' => ['<', 10],
            'critical' => ['<', 5],
            'out_of_stock' => ['<=', 0],
            default => ['>', 0],
        };
    }
    

    public function create()
    {
        return view('admin.items.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|unique:items|max:100',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'expiry_date' => 'nullable|date|after_or_equal:today',
            'category' => 'required|integer',
            'description' => 'nullable|string|max:500',
            'cost_price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        try {
            $item = new Item($validated);

            if ($request->hasFile('image')) {
                $item->image = $this->storeImage($request->file('image'));
            }

            $item->save();

            return redirect()->route('items.index')->with([
                'swal' => [
                    'title' => 'Success!',
                    'text' => 'Product added successfully!',
                    'icon' => 'success'
                ]
            ]);

        } catch (\Exception $e) {
            return back()->withInput()->with([
                'swal' => [
                    'title' => 'Error!',
                    'text' => 'Failed to add product: ' . $e->getMessage(),
                    'icon' => 'error'
                ]
            ]);
        }
    }

    protected function storeImage($file)
    {
        return $file->store('products', 'public');
    }

    public function edit($id)
    {
        $item = Item::findOrFail($id);
        return view('admin.items.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'sku' => 'required|string|max:100|unique:items,sku,'.$id,
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'expiry_date' => 'nullable|date|after_or_equal:today',
            'category' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'remove_image' => 'nullable|boolean'
        ]);

        try {
            $item = Item::findOrFail($id);
            $item->fill($validated);

            $this->handleImageUpdate($request, $item);

            $item->save();

            return redirect()->route('items.index', ['id' => $id])->with([
                'swal' => [
                    'title' => 'Success!',
                    'text' => 'Product updated successfully!',
                    'icon' => 'success'
                ]
            ]);

        } catch (\Exception $e) {
            return back()->withInput()->with([
                'swal' => [
                    'title' => 'Error!',
                    'text' => 'Failed to update product: ' . $e->getMessage(),
                    'icon' => 'error'
                ]
            ]);
        }
    }

    protected function handleImageUpdate($request, $item)
    {
        if ($request->remove_image && $item->image) {
            Storage::disk('public')->delete($item->image);
            $item->image = null;
        }

        if ($request->hasFile('image')) {
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }
            $item->image = $this->storeImage($request->file('image'));
        }
    }

    public function destroy($id)
    {
        try {
            $item = Item::findOrFail($id);
            
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }
            
            $item->delete();
            
            return redirect()->route('items.index')->with([
                'swal' => [
                    'title' => 'Deleted!',
                    'text' => 'Item deleted successfully!',
                    'icon' => 'success'
                ]
            ]);
            
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'swal' => [
                    'title' => 'Error!',
                    'text' => 'Error deleting item: ' . $e->getMessage(),
                    'icon' => 'error'
                ]
            ]);
        }
    }

    public function restock(Request $request, Item $item)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $item->quantity += $request->quantity;
        $item->save();

        return redirect()->route('items.index')->with('success', 'Product restocked successfully.');
    }

}