<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ItemController extends Controller
{
    /**
     * Display a listing of items with optional filters.
     */
    public function index(Request $request)
    {
        $query = Item::query();

        // Search by name or SKU
        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('sku', 'like', "%{$request->search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by stock status (low, critical, out_of_stock)
        if ($request->has('stock_status')) {
            $condition = $this->getStockStatusCondition($request->stock_status);
            $query->where('quantity', $condition[0], $condition[1]);
        }

        // Filter items expiring in the next 7 days
        if ($request->has('expiring') && $request->expiring === 'soon') {
            $query->whereBetween('expiry_date', [Carbon::today(), Carbon::today()->addDays(7)]);
        }

        // Modal flags
        $showExpiringSoonModal = $request->expire === 'true';
        $showUrgentStockModal = $request->urgent === 'true';

        // Paginate results
        $items = $query->latest()->paginate(10)->withQueryString();

        return view('admin.items.index', compact('items', 'showExpiringSoonModal', 'showUrgentStockModal'));
    }

    /**
     * Return stock condition array based on status string.
     */
    protected function getStockStatusCondition($status)
    {
        return match ($status) {
            'low' => ['<', 10],
            'critical' => ['<', 5],
            'out_of_stock' => ['<=', 0],
            default => ['>', 0],
        };
    }

    /**
     * Show create form.
     */
    public function create()
    {
        return view('admin.items.create');
    }

    /**
     * Store new item in DB.
     */
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

            // Store image if uploaded
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

    /**
     * Store uploaded image in public/products.
     */
    protected function storeImage($file)
    {
        return $file->store('products', 'public');
    }

    /**
     * Show the edit form.
     */
    public function edit($id)
    {
        $item = Item::findOrFail($id);
        return view('admin.items.edit', compact('item'));
    }

    /**
     * Update item details.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'sku' => 'required|string|max:100|unique:items,sku,' . $id,
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

            return redirect()->route('items.index')->with([
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

    /**
     * Handle image updates (remove or replace).
     */
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

    /**
     * Delete an item and its image.
     */
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

    /**
     * Restock an item.
     */
    public function restock(Request $request, Item $item)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $item->quantity += $request->quantity;
        $item->save();

        return redirect()->route('items.index')->with('success', 'Product restocked successfully.');
    }

    /**
     * Sell an item and record the sale.
     */
    public function sellItem(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $item = Item::findOrFail($request->item_id);

        if ($item->quantity < $request->quantity) {
            return back()->with('error', 'Not enough stock.');
        }

        // Record sale
        Sale::create([
            'item_id' => $item->id,
            'quantity_sold' => $request->quantity,
            'sold_at' => Carbon::now(),
        ]);

        // Reduce stock
        $item->decrement('quantity', $request->quantity);

        return back()->with('success', 'Item sold successfully.');
    }

    /**
     * Show list of most sold items.
     */
    public function sold()
    {
        $soldItems = Item::withSum('sales as total_sold', 'quantity_sold')
                         ->orderByDesc('total_sold')
                         ->paginate(10);

        return view('admin.items.sold', compact('soldItems'));
    }
}
