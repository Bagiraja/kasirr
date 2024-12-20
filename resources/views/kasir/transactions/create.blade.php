@extends('layouts.kasir')

@section('content')
<style>
    body{
        overflow-y: auto;
    }
    :root {
        --primary-color: #007bff;
        --secondary-color: #B0E0E6;
        --border-color: #dee2e6;
        --card-shadow: 0 2px 4px rgba(0,0,0,0.1);
        --header-height: 60px;
        --spacing-unit: 1rem;
    }

    .container-fluid {
        padding: var(--spacing-unit);
        margin-top: var(--header-height);
    }

    .search-container {
        position: sticky;
        top: var(--header-height);
        z-index: 100;
        background: white;
        padding: var(--spacing-unit) 0;
        margin-bottom: var(--spacing-unit);
    }

    .search-container .form-control {
        min-height: 45px;
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.75rem;
        margin-bottom: var(--spacing-unit);
    }

    .product-card {
        background: white;
        border-radius: 8px;
        box-shadow: var(--card-shadow);
        transition: transform 0.2s, box-shadow 0.2s;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .product-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }

    .product-card img {
        width: 100%;
        height: 100px;
        object-fit: cover;
        border-radius: 8px 8px 0 0;
    }

    .product-info {
        padding: 0.75rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .product-info h6 {
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
        font-weight: 600;
        line-height: 1.2;
    }

    .product-price {
        font-size: 0.95rem;
        color: var(--primary-color);
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .quantity-controls {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .quantity-controls input {
        text-align: center;
        width: 50px;
        padding: 0.25rem;
    }

    .payment-sidebar {
        position: sticky;
        top: calc(var(--header-height) + var(--spacing-unit));
        background-color: white;
        border-radius: 12px;
        padding: 1.5rem;
        height: calc(100vh - var(--header-height) - 2 * var(--spacing-unit));
        overflow-y: auto;
        box-shadow: var(--card-shadow);
    }

    .selected-products-container {
        background: white;
        border-radius: 12px;
        margin-top: var(--spacing-unit);
        box-shadow: var(--card-shadow);
        overflow: hidden;
    }

    .table-responsive {
        max-height: 300px;
        overflow-y: auto;
    }

    .btn-add-product {
        background-color: var(--primary-color);
        color: white;
        border: none;
        padding: 0.5rem;
        border-radius: 8px;
        transition: all 0.2s;
        font-weight: 500;
        font-size: 0.9rem;
        width: 100%;
    }

    .btn-add-product:hover {
        background-color: #0056b3;
        transform: translateY(-1px);
    }

    .payment-form {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .payment-total {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--primary-color);
        margin: 1rem 0;
        padding: 1rem;
        background-color: rgba(0,123,255,0.1);
        border-radius: 8px;
        text-align: center;
    }

    /* Pagination Styles */
    .pagination-container {
        margin: 1rem 0;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
    }

    .pagination {
        display: flex;
        padding-left: 0;
        list-style: none;
        border-radius: 0.25rem;
    }

    .page-link {
        position: relative;
        display: block;
        padding: 0.5rem 0.75rem;
        margin-left: -1px;
        line-height: 1.25;
        color: var(--primary-color);
        background-color: #fff;
        border: 1px solid #dee2e6;
    }

    .page-item.active .page-link {
        z-index: 3;
        color: #fff;
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        cursor: auto;
        background-color: #fff;
        border-color: #dee2e6;
    }

    /* Responsive adjustments */
    @media (max-width: 1200px) {
        .product-grid {
            grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
        }
    }

    @media (max-width: 992px) {
        .main-content {
            flex-direction: column;
        }
        
        .payment-sidebar {
            position: relative;
            top: 0;
            width: 100%;
            height: auto;
            margin-top: var(--spacing-unit);
        }
    }

    @media (max-width: 768px) {
        .product-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 576px) {
        .product-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.5rem;
        }
        
        .product-card img {
            height: 80px;
        }

        .product-info {
            padding: 0.5rem;
        }

        .product-info h6 {
            font-size: 0.8rem;
        }

        .quantity-controls input {
            width: 40px;
        }
    }
</style>

<div class="container-fluid">
    <h4>Transaksi</h4>
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="search-container">
        <form class="d-flex" action="{{ route('kasir.transactions.search') }}" method="GET">
            <input class="form-control me-2" type="search" placeholder="Cari produk..." name="search" value="{{ old('search', $search ?? '') }}">
            <button class="btn btn-primary px-4" type="submit">Cari</button>
        </form>
    </div>

    <div class="row main-content">
        <!-- Products Section -->
        <div class="col-lg-8">
            <div class="product-grid">
                @foreach ($products as $product)
                <div class="product-card">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                    <div class="product-info">
                        <h6 class="text-center">{{ $product->name }}</h6>
                        <p class="product-price text-center">Rp{{ number_format($product->price, 2) }}</p>
                        
                        <div class="quantity-controls">
                            <label class="form-label small">Jumlah:</label>
                            <input type="number" class="form-control form-control-sm" id="quantity_{{ $product->id }}" 
                                   min="1" value="1" oninput="calculateTotal({{ $product->id }}, {{ $product->price }})">
                        </div>

                        <div class="mb-2">
                            <label class="form-label small">Total:</label>
                            <input type="text" class="form-control form-control-sm" id="total_{{ $product->id }}" 
                                   value="Rp{{ number_format($product->price, 2) }}" readonly>
                        </div>

                        <button class="btn-add-product mt-auto" onclick="addProductToTable({{ $product->id }}, '{{ $product->name }}', {{ $product->price }})">
                            Tambah
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <nav aria-label="...">
                <ul class="pagination justify-content-center">
                    <li class="page-item {{ $products->onFirstPage() ? 'disabled' : '' }}">
                        <span class="page-link" href="{{ $products->previousPageUrl() }}">Previous</span>
                    </li>
                    @for ($i = 1; $i <= $products->lastPage(); $i++)
                        <li class="page-item {{ $products->currentPage() == $i ? 'active' : '' }}">
                            <a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    <li class="page-item {{ !$products->hasMorePages() ? 'disabled' : '' }}">
                        <span class="page-link" href="{{ $products->nextPageUrl() }}">Next</span>
                    </li>
                </ul>
            </nav>

            <div class="selected-products-container">
                <div class="p-3 border-bottom">
                    <h5 class="mb-0">Produk Dipilih</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="selected-products-table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-center">Total Harga</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Payment Sidebar -->
        <div class="col-lg-4">
            <div class="payment-sidebar">
                <h5 class="mb-4">Pembayaran</h5>
                <form class="payment-form" action="{{ route('kasir.transactions.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Uang Tunai Diterima</label>
                        <input type="number" name="cash_received" id="cash_received" 
                               class="form-control" min="0" step="0.01" 
                               oninput="calculateChange()" required>
                    </div>

                    <div class="form-group">
                        <label>Kembalian</label>
                        <input type="text" id="change" class="form-control" readonly>
                    </div>

                    <div class="payment-total">
                        <label>Total Pembayaran</label>
                        <input type="text" id="total_payment" name="total_payment" 
                               class="form-control text-center" readonly>
                    </div>

                    <input type="hidden" id="products_data" name="products_data">
                    <button type="submit" class="btn btn-primary btn-lg w-100">Proses Pembayaran</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
let selectedProducts = [];

function calculateTotal(productId, price) {
    const quantity = parseInt(document.getElementById('quantity_' + productId).value) || 0;
    const total = price * quantity;
    document.getElementById('total_' + productId).value = 'Rp' + total.toFixed(2);
}

function addProductToTable(productId, productName, price) {
    const quantity = parseInt(document.getElementById('quantity_' + productId).value);
    const totalPrice = price * quantity;

    if (quantity > 0) {
        const existingProductIndex = selectedProducts.findIndex(p => p.id === productId);
        if (existingProductIndex > -1) {
            selectedProducts[existingProductIndex].quantity = quantity;
            selectedProducts[existingProductIndex].total_price = totalPrice;
        } else {
            selectedProducts.push({
                id: productId,
                name: productName,
                quantity: quantity,
                total_price: totalPrice,
                price: price
            });
        }

        updateTable();
        updateTotalPayment();
    }
}

function updateTable() {
    const tableBody = document.querySelector('#selected-products-table tbody');
    tableBody.innerHTML = '';

    selectedProducts.forEach((product, idx) => {
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>${product.name}</td>
            <td class="text-center">
                <input type="number" class="form-control form-control-sm mx-auto" 
                       style="max-width: 80px"
                       value="${product.quantity}" min="1"
                       // Continuing the script section...
    
    onchange="updateQuantity(${idx}, this.value)">
</td>
<td class="text-center">Rp${product.total_price.toFixed(2)}</td>
<td class="text-center">
<button type="button" class="btn btn-danger btn-sm"
     onclick="removeProduct(${idx})">
 <i class="fas fa-trash"></i> Hapus
</button>
</td>
`;
tableBody.appendChild(newRow);
});
}

function updateQuantity(index, newQuantity) {
const product = selectedProducts[index];
product.quantity = parseInt(newQuantity);
product.total_price = product.quantity * product.price;
updateTable();
updateTotalPayment();
}

function removeProduct(index) {
selectedProducts.splice(index, 1);
updateTable();
updateTotalPayment();
}

function updateTotalPayment() {
const totalPayment = selectedProducts.reduce((sum, product) => sum + product.total_price, 0);
document.getElementById('total_payment').value = totalPayment.toFixed(2);
calculateChange();
}

function calculateChange() {
const totalPayment = parseFloat(document.getElementById('total_payment').value) || 0;
const cashReceived = parseFloat(document.getElementById('cash_received').value) || 0;
const change = cashReceived - totalPayment;
document.getElementById('change').value = change.toFixed(2);
}

// Handle form submission
document.querySelector('form[action="{{ route('kasir.transactions.store') }}"]').addEventListener('submit', function(e) {
if (selectedProducts.length === 0) {
e.preventDefault();
alert('Silakan pilih produk terlebih dahulu!');
return false;
}

const cashReceived = parseFloat(document.getElementById('cash_received').value) || 0;
const totalPayment = parseFloat(document.getElementById('total_payment').value) || 0;

if (cashReceived < totalPayment) {
e.preventDefault();
alert('Jumlah uang yang diterima kurang dari total pembayaran!');
return false;
}

document.getElementById('products_data').value = JSON.stringify(selectedProducts);
});

// Optional: Add a clear all function
function clearCart() {
selectedProducts = [];
updateTable();
updateTotalPayment();
document.getElementById('cash_received').value = '';
document.getElementById('change').value = '';
}

// Optional: Format currency
function formatCurrency(amount) {
return new Intl.NumberFormat('id-ID', {
style: 'currency',
currency: 'IDR',
minimumFractionDigits: 0,
maximumFractionDigits: 0
}).format(amount);
}

// Optionally add keyboard shortcuts
document.addEventListener('keydown', function(e) {
// Press F2 to focus on search
if (e.key === 'F2') {
e.preventDefault();
document.querySelector('input[type="search"]').focus();
}

// Press F8 to focus on cash received
if (e.key === 'F8') {
e.preventDefault();
document.getElementById('cash_received').focus();
}

// Press F12 to process payment
if (e.key === 'F12') {
e.preventDefault();
document.querySelector('button[type="submit"]').click();
}
});
</script>
@endsection