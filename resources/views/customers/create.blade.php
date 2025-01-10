@extends('layouts.app')

@section('title', 'Register Customer')

@section('content')
<div class="container">
    <h1 class="mb-4">Register Customer</h1>

    <form action="{{ route('customer.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="code" class="form-label">Customer Code</label>
            <input 
                type="text" 
                id="code" 
                name="code" 
                class="form-control @error('code') is-invalid @enderror" 
                value="{{ old('code') }}" 
                placeholder="Enter customer code" 
                required>
            @error('code')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="name" class="form-label">Customer Name</label>
            <input 
                type="text" 
                id="name" 
                name="name" 
                class="form-control @error('name') is-invalid @enderror" 
                value="{{ old('name') }}" 
                placeholder="Enter customer name" 
                required>
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="contact" class="form-label">Contact</label>
            <input 
                type="text" 
                id="contact" 
                name="contact" 
                class="form-control @error('contact') is-invalid @enderror" 
                value="{{ old('contact') }}" 
                placeholder="Enter contact number">
            @error('contact')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea 
                id="address" 
                name="address" 
                class="form-control @error('address') is-invalid @enderror" 
                placeholder="Enter address" 
                required>{{ old('address') }}</textarea>
            @error('address')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary w-50 mb-2">Register</button>
        </div>
    </form>
    
    <a href="{{ route('customer.index') }}" class="btn btn-secondary">
        Daftar Customer
    </a>
</div>
@endsection
