@extends('layouts.app')

@section('title', 'Penjualan')

@section('content')
<div class="container">
    <h2>Create Sales Order</h2>
    <form action="{{ route('sales.store') }}" method="POST">
        @csrf

        {{-- Nomor Surat Jalan --}}
        <div class="mb-3">
            <label for="delivery_order" class="form-label">Delivery Order (Nomor Surat Jalan)</label>
            <input type="text" name="delivery_order" class="form-control @error('delivery_order') is-invalid @enderror" id="delivery_order" value="{{ old('delivery_order') }}" required>
            @error('delivery_order')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Pilih Customer --}}
        <div class="mb-3">
            <label for="customer_id" class="form-label">Customer</label>
            <select name="customer_id" id="customer_id" class="form-control @error('customer_id') is-invalid @enderror" required>
                <option value="" disabled selected>Pilih Customer</option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                        {{ $customer->name }}
                    </option>
                @endforeach
            </select>
            @error('customer_id')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Daftar Produk --}}
        <div id="item-list">
            <div class="item">
                <div class="row mb-3">
                    <div class="col-md-2">
                        <label for="kode_produk" class="form-label">Kode Produk</label>
                        <input type="text" name="products[0][kode_produk]" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input type="text" name="products[0][nama_barang]" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label for="berat" class="form-label">Berat (gram)</label>
                        <input type="number" name="products[0][berat]" class="form-control" step="0.01" required>
                    </div>
                    <div class="col-md-2">
                        <label for="harga" class="form-label">Harga (Rp)</label>
                        <input type="number" name="products[0][harga]" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label for="total" class="form-label">Total (Rp)</label>
                        <input type="number" name="products[0][total]" class="form-control total" readonly>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger remove-item">-</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tombol Tambah Produk --}}
        <button type="button" id="add-item" class="btn btn-sm btn-primary">Tambah Produk</button>

        {{-- Subtotal --}}
        <div class="mb-3 mt-3">
            <label for="subtotal" class="form-label">Subtotal</label>
            <input type="number" name="subtotal" id="subtotal" class="form-control" readonly>
        </div>

        {{-- Tombol Submit --}}
        <div class="text-center">
            <button type="submit" class="btn btn-primary w-50">Submit</button>
        </div>
    </form>

    {{-- Tombol Kembali --}}
    <a href="{{ route('sales.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>

{{-- JavaScript untuk Menangani Tambah/Hapus Produk --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const itemContainer = document.querySelector('#item-list');
        const addItemButton = document.querySelector('#add-item');
        let itemCount = 1;
    
        // Tambah Produk Baru
        addItemButton.addEventListener('click', function () {
            const itemRow = document.querySelector('.item').cloneNode(true);
            itemRow.querySelectorAll('input').forEach(input => {
                input.name = input.name.replace(/\d+/, itemCount);
                input.value = '';
            });
            itemRow.querySelector('.remove-item').addEventListener('click', function () {
                itemRow.remove();
                calculateSubtotal();
            });
            itemContainer.appendChild(itemRow);
            itemCount++;
        });
    
        // Hitung Total per Baris
        document.addEventListener('input', function (e) {
            if (e.target.matches('.item input')) {
                calculateRowTotal(e.target.closest('.item'));
                calculateSubtotal();
            }
        });
    
        // Fungsi Hitung Total per Baris
        function calculateRowTotal(item) {
            const berat = parseFloat(item.querySelector('[name$="[berat]"]').value) || 0;
            const harga = parseFloat(item.querySelector('[name$="[harga]"]').value) || 0;
            item.querySelector('[name$="[total]"]').value = berat * harga;
        }
    
        // Fungsi Hitung Subtotal
        function calculateSubtotal() {
            const totals = document.querySelectorAll('[name$="[total]"]');
            const subtotal = Array.from(totals).reduce((sum, input) => sum + parseFloat(input.value || 0), 0);
            document.querySelector('#subtotal').value = subtotal;
        }
    });
</script>
    
@endsection
