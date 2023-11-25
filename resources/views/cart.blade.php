@extends('layouts.outer')

@section('content')
<div class="container">

        <h2>Cart</h2>
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
        @if(session('cart'))
            @foreach(session('cart') as $key=>$item)
                <div class="cart-card"  id="cart-item-{{$item['id']}}">
                    <div class="cart-details">
                        <h3>{{ $item['name'] }}</h3>
                        <p>{{ $item['description'] }}</p>
                        <p>Price: ${{ $item['price'] }}</p>
                        <p>
                        <form action="{{ route('cart.update', $item['id']) }}" method="post">
                            @csrf
                            @method('put')
                            <input class="qty-input" type="number" name="quantity" value="{{ $item['quantity'] }}" min="1">
                            <button class="cart-button" type="submit">Update</button>
                        </form>
                    </p>
                    </div>
                    <button class="remove-item remove-button" data-product-id="{{ $item['id'] }}">Remove</button>
                </div>
            @endforeach

        <div class="cart-total">
                <strong>Total Price: <div id="totalAmountDisplay">${{ array_sum(array_map(function($item) { return $item['price'] * $item['quantity']; }, session('cart'))) }}</div></strong>
            
        </div>
        <button class="cart-button"  onclick="proceedToCheckout()" id="proceedToCheckoutBtn">Proceed to Checkout</button>
        @else
            <p>Your cart is empty.</p>
        @endif

    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).on('click', '.remove-item', function() {
            var productId = $(this).data('product-id');

            $.ajax({
                url: '/cart/' + productId + '/remove',
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#cart-item-' + productId).remove();
                    alert(response.message); 
                    updateTotalAmount();
                },
                error: function(xhr, status, error) {
                    alert('Error removing item from the cart');
                }
            });
        });
        function updateTotalAmount() {
            $.ajax({
                url: '/cart/updateTotalAmount',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#totalAmountDisplay').text('$' + response.totalAmount.toFixed(2));
                    console.log('Total Amount Updated:', response.totalAmount);
                },
                error: function(xhr, status, error) {
                    console.error('Error updating total amount:', error);
                }
            });
        }
        function proceedToCheckout() {
            window.location.href = '/checkout'; 
        }
    </script>
@endsection