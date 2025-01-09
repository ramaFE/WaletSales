@extends('layouts.app')
@section('title', 'Barang Masuk')

@section('content')
<div class="container">
    <h1>Barang Masuk</h1>
    <div class="form-section">
        <h2>Form Input</h2>
        <form action="/barang-masuk/store" method="POST">
            @csrf
            <div class="form-group">
                <label for="product_code">Kode Produk:</label>
                <input type="text" id="product_code" name="product_code" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="product_name">Nama Barang:</label>
                <input type="text" id="product_name" name="product_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="product_dimension">Berat:</label>
                <input type="text" id="product_dimension" name="product_dimension" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="product_unit">Harga:</label>
                <input type="number" id="product_unit" name="product_unit" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="product_total">Total:</label>
                <input type="number" id="product_total" name="product_total" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <div class="product-list-section">
        <h2>List Barang</h2>
        <input type="text" placeholder="Search barang" id="search" class="form-control mb-3">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kode Produk</th>
                    <th>Nama Barang</th>
                    <th>Berat</th>
                    <th>Harga</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>budi</td>
                    <td>Patahan</td>
                    <td>200</td>
                    <td>Rp. 5000</td>
                    <td>Rp. 1000.000</td>
                    <td>
                        <a href="#" class="btn btn-sm btn-warning">Edit</a>
                        <a href="#" class="btn btn-sm btn-danger">Delete</a>
                    </td>
                </tr>
                    <td>2</td>
                    <td>budi</td>
                    <td>Patah KW</td>
                    <td>500</td>
                    <td>Rp. 4000</td>
                    <td>Rp. 2000.000</td>
                    <td>
                        <a href="#" class="btn btn-sm btn-warning">Edit</a>
                        <a href="#" class="btn btn-sm btn-danger">Delete</a>
                    </td>
                </tr>
                    <td>3</td>
                    <td>budi</td>
                    <td>Kakian</td>
                    <td>1000</td>
                    <td>Rp. 3000</td>
                    <td>Rp. 3000.000</td>
                    <td>
                        <a href="#" class="btn btn-sm btn-warning">Edit</a>
                        <a href="#" class="btn btn-sm btn-danger">Delete</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
