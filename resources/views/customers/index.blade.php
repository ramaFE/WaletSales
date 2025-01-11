@extends('layouts.app')

@section('title', 'Daftar Customer')

@section('content')
<div class="container-fluid">
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="customer-list-section">
        <h1>Customer List</h1>
        <input type="text" placeholder="Search customer" id="search" class="form-control mb-3">
        
        <!-- Tabel Responsif -->
        <div class="table-responsive">
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
                            <!-- Tombol Edit -->
                            <a href="{{ route('customer.edit', $customer->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            
                            <!-- Tombol Delete -->
                            <button 
                                class="btn btn-sm btn-danger open-delete-popup" 
                                data-url="{{ route('customer.destroy', $customer->id) }}" 
                                data-name="{{ $customer->name }}">
                                Delete
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No customers available.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="d-flex justify-content-center">
            {{ $customers->links('pagination::bootstrap-4') }}
        </div>

        <a href="{{ route('customer.create') }}" class="btn btn-primary">Register Customer</a>
    </div>

    <!-- Modal Delete -->
    <div id="delete-modal" class="hidden">
        <div class="overlay"></div>
        <div class="modal-content">
            <h2 class="text-gray-900 font-bold">Warning!</h2>
            <p>Apakah Anda yakin akan menghapus <span id="customer-info" class="font-bold"></span> dari database?</p>
            <form id="delete-form" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-end gap-4">
                    <button type="button" id="delete-cancel" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
