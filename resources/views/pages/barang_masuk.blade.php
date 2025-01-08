@extends('layouts.app')

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
        <h2>Product List</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Product Code</th>
                    <th>Product Name</th>
                    <th>Dimension</th>
                    <th>Unit</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>1234</td>
                    <td>Air Putih</td>
                    <td>12mm</td>
                    <td>5</td>
                    <td>
                        <a href="#" class="btn btn-sm btn-warning">Edit</a>
                        <a href="#" class="btn btn-sm btn-danger">Delete</a>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>1221</td>
                    <td>Jus Jeruk</td>
                    <td>18</td>
                    <td>10</td>
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
