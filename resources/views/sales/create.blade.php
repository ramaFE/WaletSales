@extends('layouts.app')

@section('title', 'Penjualan')

@section('content')
<div class="container">
    <h2>Create Sales Order</h2>
    <form action="{{ route('sales.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="delivery_order" class="form-label">Delivery Order (Nomor Surat Jalan)</label>
            <input type="text" name="delivery_order" class="form-control @error('delivery_order') is-invalid @enderror" id="delivery_order" required>
            @error('delivery_order')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="customer_id" class="form-label">Customer</label>
            <select name="customer_id" id="customer_id" class="form-control @error('customer_id') is-invalid @enderror" required>
                <option value="" disabled selected>Pilih Customer</option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
            </select>
            @error('customer_id')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div id="item-list">
            <div class="item">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="product_id" class="form-label">Produk</label>
                        <select name="products[0][id]" class="form-control product-select" required>
                            <option value="" disabled selected>Pilih Produk</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->nama_barang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" name="products[0][quantity]" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label for="subtotal" class="form-label">Subtotal</label>
                        <input type="number" name="products[0][subtotal]" class="form-control subtotal" readonly>
                    </div>
                </div>
            </div>
        </div>
        
        <button type="button" id="add-item" class="btn btn-sm btn-primary">Tambah Produk</button>
        
        <div class="mb-3 mt-3">
            <label for="total" class="form-label">Total</label>
            <input type="number" name="total" id="total" class="form-control" readonly>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary w-50">Submit</button>
        </div>
    </form>

    <a href="{{ route('sales.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const itemContainer = document.querySelector('#item-list');
        const addItemButton = document.querySelector('#add-item');
        let itemCount = 1;

        addItemButton.addEventListener('click', function () {
            const itemRow = document.querySelector('.item').cloneNode(true);
            itemRow.querySelectorAll('input, select').forEach((input) => {
                input.name = input.name.replace(/\d+/, itemCount);
                input.value = '';
            });
            itemContainer.appendChild(itemRow);
            itemCount++;
        });
    });
</script>
@endsection
