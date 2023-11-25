@extends('layouts.outer')

@section('content')
<div class="container">

        <h2>Order Summary</h2>
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
        <div class="order-details">

       
        <p><strong>Order ID : </strong>{{$lastOrder->order_number}}</p>
        <p><strong>Date : </strong>{{ now()->toDateString() }}</p>
        
        <h2>Products</h2>

       
        <ul>
            @foreach($orderItems as $key=>$item)
            <li>{{ $item->product->name }} - Quantity: {{ $item['quantity'] }} - Price: $ {{number_format($item['price'],2)}} </li>
            @endforeach
        </ul>

        <div class="total">
            <p><strong>Total :  </strong>${{number_format( $lastOrder->grand_total ,2)}}</p>
        </div>

        <h3>Thank You For Your Order!</h3>
    </div>
@endsection
