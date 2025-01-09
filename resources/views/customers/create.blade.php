@extends('layouts.app')

@section('title', 'Register Customer')

@section('content')
<div class="container">
    <h1 class="mb-4">Register Customer</h1>

    <form action="{{ route('customer.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="customer_code" class="form-label">Customer Code</label>
            <input type="text" id="customer_code" name="customer_code" class="form-control" >
        </div>
        <div class="mb-3">
            <label for="customer_name" class="form-label">Customer Name</label>
            <input type="text" id="customer_name" name="customer_name" class="form-control" placeholder="Enter customer name" required>
        </div>
        <div class="mb-3">
            <label for="contact" class="form-label">Contact</label>
            <input type="text" id="contact" name="contact" class="form-control" placeholder="Enter contact number">
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea id="address" name="address" class="form-control" placeholder="Enter address" required></textarea>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary w-50 mb-2">Register</button>
        </div>
    </form>
    
    <a href="{{ route('customer.index') }}" class="btn btn-secondary" >
        Daftar Customer
    </a>
</div>
@endsection
