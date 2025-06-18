<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Sale;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $adminData = User::findOrFail(Auth::user()->id);

        $totalItems = Item::count();

        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        $todayCount = Item::whereDate('created_at', $today)->count();
        $yesterdayCount = Item::whereDate('created_at', $yesterday)->count();

        $growth = $yesterdayCount > 0 ? round((($todayCount - $yesterdayCount) / $yesterdayCount) * 100) : ($todayCount > 0 ? 100 : 0);

        $lowStockCount = Item::where('quantity', '<', 10)->count();
        $urgentRestockCount = Item::where('quantity', '<', 5)->count();

        $sevenDaysLater = Carbon::today()->addDays(7);
        $expiringSoonCount = Item::whereBetween('expiry_date', [$today, $sevenDaysLater])->count();

        $totalItemsSold = Sale::sum('quantity_sold');

        $lowStockItems = Item::where('quantity', '<', 10)
            ->orderBy('quantity')
            ->limit(5)
            ->get();

        $topCategoryId = Item::select('category')
            ->groupBy('category')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(1)
            ->pluck('category')
            ->first();

        $topCategory = match ($topCategoryId) {
            1 => 'Beverages',
            2 => 'Food',
            3 => 'Frozen',
            default => 'Unknown'
        };

        $itemsSoldToday = Sale::whereDate('sold_at', Carbon::today())->sum('quantity_sold');

        $dates = collect();
        $itemsAdded = collect();
        $itemsSold = collect();
        $lowStock = collect();

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $dates->push($date->format('M d'));

            $itemsAdded->push(Item::whereDate('created_at', $date)->count());
            $itemsSold->push(Sale::whereDate('sold_at', $date)->sum('quantity_sold'));
            $lowStock->push(Item::where('quantity', '<', 10)->whereDate('updated_at', '<=', $date)->count());
        }

        return view('admin.index', compact(
            'adminData',
            'totalItems',
            'todayCount',
            'yesterdayCount',
            'growth',
            'lowStockCount',
            'urgentRestockCount',
            'expiringSoonCount',
            'totalItemsSold',
            'lowStockItems',
            'topCategory',
            'itemsSoldToday',
            'dates',
            'itemsAdded',
            'itemsSold',
            'lowStock'
        ));
    }
}