@extends('layouts.app')

@section('title', 'Edit Customer')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Customer</h1>

    <form action="{{ route('customer.update', $customer->id ?? 1) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="customer_code" class="form-label">Customer Code</label>
            <input 
                type="text" 
                id="customer_code" 
                name="customer_code" 
                class="form-control" 
                value="{{ old('customer_code', $customer->customer_code ?? '1234') }}" 
                placeholder="Enter customer code" 
                required>
        </div>
        
        <div class="mb-3">
            <label for="customer_name" class="form-label">Customer Name</label>
            <input 
                type="text" 
                id="customer_name" 
                name="customer_name" 
                class="form-control" 
                value="{{ old('customer_name', $customer->customer_name ?? 'Hong A') }}" 
                placeholder="Enter customer name" 
                required>
        </div>
        
        <div class="mb-3">
            <label for="contact" class="form-label">Contact</label>
            <input 
                type="text" 
                id="contact" 
                name="contact" 
                class="form-control" 
                value="{{ old('contact', $customer->contact ?? '081321654') }}" 
                placeholder="Enter contact number">
        </div>
        
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea 
                id="address" 
                name="address" 
                class="form-control" 
                placeholder="Enter address" 
                required>{{ old('address', $customer->address ?? 'Jalan Teluk Gong') }}</textarea>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary w-50 mb-2">Save</button>
        </div>
    </form>
    
    <a href="{{ route('customer.index') }}" class="btn btn-secondary">
        Daftar Customer
    </a>
</div>
@endsection
