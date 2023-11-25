
@extends('layouts.outer')

@section('content')
    <div class="container">
    <form action="{{ route('products.search') }}" method="GET" class="search-container">
        <input type="text" class="search-input" name="search" placeholder="Search products..." value="{{ request('search') }}">
        <button type="submit" class="search-button">Search</button>
    </form>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
        @forelse($products as $product)
            <div class="product">
                <!-- <img src="product1.jpg" alt="Product 1"> -->
                <h2>{{$product->name}}</h2>
                <p>{{$product->description}}</p>
                <p>${{$product->price}}</p>
                @auth
                <a style="text-decoration: none;" href="{{ route('products.addToCart', $product->id) }}">Add to Cart</a>
                @endauth
            </div>
        @empty
            <p>No products found.</p>
        @endforelse
    </div>
@endsection
