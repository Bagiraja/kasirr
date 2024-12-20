<?php

// KasirController.php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Barang;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class KasirController extends Controller
{
    public function dashboard()
    {
        // Ambil data transaksi terbaru
        $transactions = Transaction::latest()->get();
        
        // Menghitung total pengguna, produk, penjualan, dan pendapatan
         // Jumlah total pengguna
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
        return view('kasir.dashboard', compact( 'productCount', 'salesCount', 'totalRevenue', 'totalSales', 'monthlySales', 'topProducts'));
    }
 

   // KasirController.php

public function create()
{
    $products = Product::all();
    $products = Product::paginate(8); // Ambil semua produk
    return view('kasir.transactions.create', compact('products'));
}

public function store(Request $request)
{
    $productsData = json_decode($request->products_data, true);
    $totalPayment = 0;

    foreach ($productsData as $productData) {
        $product = Product::findOrFail($productData['id']);

        // Pastikan stok cukup
        if ($product->stock < $productData['quantity']) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi untuk produk ' . $product->name);
        }

        // Kurangi stok produk
        $product->stock -= $productData['quantity'];
        $product->save();

        // Simpan transaksi
        $transaction = new Transaction();
        $transaction->product_id = $product->id;
        $transaction->quantity = $productData['quantity'];
        $transaction->price = $product->price;
        $transaction->total = $product->price * $productData['quantity'];
        $transaction->cash_received = $request->cash_received;
        $transaction->change = $this->calculateChange($totalPayment, $request->cash_received);
        $transaction->save();

        $totalPayment += $transaction->total;
    }

    return redirect()->route('kasir.transactions.index')->with('success', 'Transaksi berhasil.');
}


private function calculateChange($totalPrice, $cashReceived)
{
    return $cashReceived - $totalPrice;
}


   

    public function index()
    {
        $transactions = Transaction::with('product')->get();

        $transactions = Transaction::paginate(3);
        return view('kasir.transactions.show', compact('transactions'));
    }

    public function stockReport()
    {
        // Ambil data stok produk dari database
        $stocks = Product::all();
        $stocks = Product::paginate(3);
        return view('kasir.reports.stock', compact('stocks'));
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return redirect()->route('kasir.transactions.index')->with('success', 'Product deleted successfully');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
    
        // Gunakan paginate untuk mendukung pagination dan links()
        $products = Product::query()
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhere('kode_barang', 'LIKE', "%{$search}%")
            ->paginate(3);
    
        return view('kasir.transactions.create', compact('products', 'search'));
    }
    
    
    public function stocksearch(Request $request){
       $search = $request->input('search');
       $stocks = Product::Where('name', 'LIKE' ,"%{$search}%")->paginate(3);

       return view('kasir.reports.stock', compact('stocks'));
    }

 // Import the PDF facade

public function downloadPDF()
{
    $transactions = Transaction::with('product')->get(); // Fetch all transactions

    // Pass the data to the PDF view
    $pdf = Pdf::loadView('kasir.transactions.pdf', compact('transactions'));
    
    // Download the generated PDF
    return $pdf->download('transactions_report.pdf');
}

public function indexkasir()
{
    $products = Product::all();

    $products  = Product::paginate(3);
    return view('kasir.products.index', compact('products'));
}


public function createkasir()
{
    
    return view('kasir.products.create');
}

public function storekasir(Request $request)
{
    $request->validate([
        'kode_barang' => 'required|unique:products,kode_barang',
        'name' => 'required|string|max:255',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validasi file gambar
    ]);

    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('images/products', 'public');
    }

    Product::create([
        'kode_barang' => $request->kode_barang,
        'name' => $request->name,
        'price' => $request->price,
        'stock' => $request->stock,
        'image' => $imagePath,
    ]);

    return redirect()->route('kasir.products')->with('success', 'Produk berhasil dibuat');
}

public function editkasir($id)
{
    $product = Product::findOrFail($id);
    return view('kasir.products.edit', compact('product'));
}

public function updatekasir(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'kode_barang' => 'required|unique:products,kode_barang,' . $product->id,
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('images/products', 'public');
        }

        $product->update([
            'kode_barang' => $request->kode_barang,
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
        ]);

        return redirect()->route('kasir.products')->with('success', 'Produk berhasil diperbarui');
    }


public function destroykasir($id)
{
    $product = Product::findOrFail($id);
    $product->delete();

    return redirect()->route('kasir.products')->with('success', 'Product deleted successfully');
}

public function searchpdct(Request $request){
    $search = $request->input('search');

    $products = Product::query()
    ->where('name','LIKE', "%{$search}%")
    ->orWhere('kode_barang','LIKE', "%{$search}%")
    ->paginate(3);

return view('kasir.products.index', compact('products','search'));

}



public function showProfilee()
{
    return view('admin.profile.index', ['user' => Auth::user()]);
}

public function updateProfilee(Request $request)
{
    $userId = Auth::id();
    $user = User::find($userId);

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $userId,
        'current_password' => 'nullable|required_with:new_password',
        'new_password' => 'nullable|min:8|confirmed',
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    // Update basic info
    $updateData = [
        'name' => $request->name,
        'email' => $request->email,
      
    ];

    // Handle password update
    if ($request->filled('current_password')) {
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak cocok']);
        }
        $updateData['password'] = Hash::make($request->new_password);
    }

    // Handle profile picture upload
    if ($request->hasFile('profile_picture')) {
        // Delete old profile picture if exists
        if ($user->profile_picture && Storage::exists('public/profile_pictures/' . $user->profile_picture)) {
            Storage::delete('public/profile_pictures/' . $user->profile_picture);
        }

        // Store new profile picture
        $fileName = time() . '_' . $request->file('profile_picture')->getClientOriginalName();
        $request->file('profile_picture')->storeAs('public/profile_pictures', $fileName);
        $updateData['profile_picture'] = $fileName;
    }

    // Update the user
    User::where('id', $userId)->update($updateData);

    return back()->with('success', 'Profil berhasil diperbarui');
}

    
}
