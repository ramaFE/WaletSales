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
                @forelse ($customers as $customer)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $customer->code }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->contact }}</td>
                    <td>{{ $customer->address }}</td>
                    <td>
                        <a href="{{ route('customer.edit', $customer->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        
                        <form action="{{ route('customer.destroy', $customer->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this customer?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No customers available.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <a href="{{ route('customer.create') }}" class="btn btn-primary">Register Customer</a>
    </div>
</div>
@endsection
