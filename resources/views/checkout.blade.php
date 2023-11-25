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
        <form action="{{ route('checkout.process') }}" method="post" id="checkoutForm">
        <!-- User Information -->
        <label for="fullName">Full Name:</label>
        <input type="text" id="fullName" name="fullName" required>
        <span id="fullNameError" class="error error-text"></span>

        <label for="phone">Phone Number:</label>
        <input type="text" id="phoneNumber" name="phoneNumber" required>
        <span id="phoneNumberError" class="error error-text"></span>

        <label for="address">Address:</label>
        <textarea id="address" name="address" rows="4" required></textarea>
        <span id="addressError" class="error error-text"></span>

        <!-- Payment Information -->
        <h3>Payment Details</h3>

        <label for="cardNumber">Card Number:</label>
        <input type="text" id="cardNumber" name="cardNumber" required>
        <span id="cardNumberError" class="error error-text"></span>

        <label for="expiryDate">Expiry Date:</label>
        <input type="text" id="expiryDate" name="expiryDate" placeholder="MM/YY" required>
        <span id="expiryDateError" class="error error-text"></span>

        <label for="cvv">CVV:</label>
        <input type="text" id="cvv" name="cvv" required>
        <span id="cvvError" class="error error-text"></span>
<br><br>
        <button type="submit">Place Order</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/validatorjs@3.15.1/dist/validator.js"></script>

<script>
    $(document).ready(function () {
        $('#checkoutForm').submit(function (event) {
            event.preventDefault();
            $('.error').text('');
            const formData = {
                name: document.getElementById('fullName').value,
                address: document.getElementById('address').value,
                phone: document.getElementById('phoneNumber').value,
                cardNo: document.getElementById('cardNumber').value,
                expiry: document.getElementById('expiryDate').value,
                cvv: document.getElementById('cvv').value,
            };

          
            const rules = {
                name: 'required|string|max:255',
                address: 'required|max:255',
                phone: 'required|string|max:255',
                cardNo: 'required|string|max:16',
                expiry: 'required|string|max:5',
                cvv: 'required|string|max:3',
            };

            // Perform client-side validation
            const validation = new Validator(formData, rules);

            if (validation.passes()) {
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        console.log(response);
                        window.location.href = '/order-summary';
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            } else {
                const errors = validation.errors.all();
                Object.keys(errors).forEach(field => {
                    $(`#${field}Error`).text(errors[field][0]);
                });
            }
        });
    });
</script>
@endsection