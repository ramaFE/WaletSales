@extends('layouts.app')

@section('title', 'Penjualan')

@section('content')
<div class="container">
    <h2>Create Sales Order</h2>
    <form action="{{ route('sales.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="delivery_order" class="form-label">Delivery Order (Nomor Surat Jalan)</label>
            <input type="text" name="delivery_order" class="form-control" id="delivery_order" required>
        </div>
        <div class="mb-3">
            <label for="customer" class="form-label">Customer</label>
            <input type="text" name="customer" class="form-control" id="customer" required>
        </div>

        <div id="item-list">
            <div class="item">
                <div class="row mb-3">
                    <div class="col-md-2">
                        <label for="kode_barang" class="form-label">Kode Barang</label>
                        <input type="text" name="kode_barang[]" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input type="text" name="nama_barang[]" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label for="berat" class="form-label">Berat</label>
                        <input type="number" name="berat[]" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="number" name="harga[]" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label for="total" class="form-label">Total</label>
                        <input type="number" name="total[]" class="form-control" readonly>
                    </div>
                    
                </div>
            </div>
        </div>
        
        <div class="col-md-2 d-flex align-items-end">
            <button type="button" id="remove-item" class="btn btn-danger btn-sm">-</button>
            <button type="button" id="add-item" class="btn btn-primary btn-sm " style="margin-left: 20px;">+</button>
        </div>                

        <div class="mb-3">
            <label for="subtotal" class="form-label">Subtotal</label>
            <input type="number" name="subtotal" id="subtotal" class="form-control" readonly>
        </div>

        <div class="text-center">
        <button type="submit" class="btn btn-primary w-50 mb-2">Submit</button>
        </div>
    </form>
    
    <a href="{{ route('sales.index') }}" class="btn btn-secondary">Sales Order</a>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addItemButton = document.getElementById('add-item');
        const itemList = document.getElementById('item-list');
        const subtotalField = document.getElementById('subtotal');
    
        // Tambahkan baris baru
        addItemButton?.addEventListener('click', function () {
            const firstItem = document.querySelector('.item');
            if (!firstItem) return; // Jika elemen item tidak ada, keluar
            const newItem = firstItem.cloneNode(true);
            newItem.querySelectorAll('input').forEach(input => input.value = ''); // Kosongkan input
            itemList.appendChild(newItem); // Tambahkan baris baru
            addRemoveEvent(newItem); // Tambahkan event listener untuk tombol remove
        });
    
        // Fungsi untuk menambahkan event listener pada tombol remove
        function addRemoveEvent(item) {
            const removeButton = item.querySelector('.remove-item');
            if (!removeButton) return; // Jika tombol tidak ditemukan, keluar
            removeButton.addEventListener('click', function () {
                if (itemList.children.length > 1) {
                    item.remove(); // Hapus baris
                    calculateSubtotal(); // Hitung ulang subtotal
                } else {
                    alert('Minimal harus ada satu baris item.');
                }
            });
        }
    
        // Tambahkan event listener pada semua tombol remove awal
        document.querySelectorAll('.item').forEach(addRemoveEvent);
    
        // Hitung total dan subtotal
        itemList.addEventListener('input', function (e) {
            if (e.target.name.includes('harga') || e.target.name.includes('berat')) {
                const item = e.target.closest('.item');
                const harga = parseFloat(item.querySelector('input[name="harga[]"]').value) || 0;
                const berat = parseFloat(item.querySelector('input[name="berat[]"]').value) || 0;
                item.querySelector('input[name="total[]"]').value = harga * berat;
                calculateSubtotal();
            }
        });
    
        // Fungsi untuk menghitung subtotal
        function calculateSubtotal() {
            let subtotal = 0;
            document.querySelectorAll('input[name="total[]"]').forEach(input => {
                subtotal += parseFloat(input.value) || 0;
            });
            subtotalField.value = subtotal;
        }
    });
    
</script>


@endsection
