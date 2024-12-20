<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\FinancialReport;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function dashboard()
{
    // Ambil data transaksi terbaru
    $transactions = Transaction::latest()->get();
    
    // Menghitung total pengguna, produk, penjualan, dan pendapatan
    $userCount = User::count(); // Jumlah total pengguna
    $productCount = Product::count(); // Jumlah total produk
    $salesCount = Sale::count(); // Jumlah total transaksi penjualan
    $totalRevenue = Sale::sum('price'); // Total pendapatan dari penjualan
    $totalSales = $transactions->sum('quantity'); // Total penjualan (quantity)
    $totalRevenue = $transactions->sum('total');// Total pendapatan dari penjualan
    // Data untuk grafik penjualan bulanan
    $monthlySales = Transaction::selectRaw('MONTH(created_at) as month, SUM(total) as total')
        ->groupBy('month')
        ->pluck('total', 'month');

    // Data untuk produk terlaris
    $topProducts = Transaction::join('products', 'transactions.product_id', '=', 'products.id')
        ->selectRaw('products.name, SUM(transactions.quantity) as total_quantity')
        ->groupBy('products.name')
        ->orderByDesc('total_quantity')
        ->take(3)
        ->pluck('total_quantity', 'products.name');

    // Kirim data ke view
    return view('admin.dashboard', compact('userCount', 'productCount', 'salesCount', 'totalRevenue', 'totalSales', 'monthlySales', 'topProducts'));
}



    public function manageUsers()
    {
            $users = User::all(); // Ambil semua data pengguna

            $users = User::paginate(4); 
            return view('admin.users', compact('users'));


    }

    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => ['required', Rule::in(['admin', 'pengguna', 'petugas_kasir', 'petugas_barang'])],
        ]);

        $user = User::findOrFail($id);
        $user->role = $request->input('role');
        $user->save();

        return redirect()->route('admin.users')->with('success', 'Role updated successfully');
    }

    public function storeUser(Request $request)
    {
        // Validasi data input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
           
        ]);

        // Membuat pengguna baru
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            
        ]);

        return redirect()->route('admin.users')->with('success', 'User created successfully');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit-user', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        // Validasi data input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($id)],
            'role' => ['required', Rule::in(['admin', 'pengguna', 'petugas_kasir', 'petugas_barang'])],
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'nullable|string|min:8|confirmed',
            ]);
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users')->with('success', 'User updated successfully');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User deleted successfully');
    }   


    public function salesReport(){
        $sales = Sale::with('product')->get(); // Mengambil semua data penjualan beserta produk terkait

        return view('admin.reports.sales', compact('sales'));
    }

    public function stockReport()
{
    // Ambil data stok produk dari database
     $stocks = Product::all();
    $stocks = Product::paginate(3);
    return view('admin.reports.stock', compact('stocks'));
}

public function financialReport()
{
    // Ambil data laporan keuangan dari database
     $finances = FinancialReport::all();
    
    return view('admin.reports.financial', compact('finances'));
}

public function searchusers(Request $request)
{
    $query = $request->input('query');

    // Perform search query
    $users = User::where('name', 'LIKE', "%{$query}%")
        ->orWhere('email', 'LIKE', "%{$query}%")->paginate(4);
      

    return view('admin.users', compact('users'));
}

}

