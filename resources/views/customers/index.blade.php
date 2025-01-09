@extends('layouts.app')

@section('title', 'Daftar Customer')

@section('content')
<div class="container">
    
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="customer-list-section">
        <h1>Customer List</h1>
        <input type="text" placeholder="Search customer" id="search" class="form-control mb-3">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Customer Code</th>
                    <th>Customer Name</th>
                    <th>Contact</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>1234</td>
                    <td>Hong A</td>
                    <td>081321654</td>
                    <td>Jalan Teluk Gong</td>
                    <td>
                        <a href="{{ route('customer.edit', ['id' => 1]) }}" class="btn btn-sm btn-warning">Edit</a>
                        
                        <form action="{{ route('customer.destroy', ['id' => 1]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this customer?')">Delete</button>
                        </form>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>1345</td>
                    <td>Tedy</td>
                    <td>081321654</td>
                    <td>Jalan Teluk Gong</td>
                    <td>
                        <a href="{{ route('customer.edit', ['id' => 2]) }}" class="btn btn-sm btn-warning">Edit</a>
                        
                        <form action="{{ route('customer.destroy', ['id' => 2]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this customer?')">Delete</button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
        <a href="{{ route('customer.create') }}" class="btn btn-primary">Register Customer</a>
    </div>
</div>
@endsection
