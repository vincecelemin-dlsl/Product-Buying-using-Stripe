@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Test</h2>
        @if(session('success'))
            {{session('success')}}
        @endif
        <div class="form-group">
            <form action="{{ url('/checkout') }}" method="post" id="payment-form">
                @csrf
                <div class="form-row">
                    <label for="card-element">
                    Credit or debit card
                    </label>
                <div id="card-element" class="container-fluid">
                <!-- A Stripe Element will be inserted here. -->
                </div>

                <!-- Used to display form errors. -->
                <div id="card-errors" role="alert"></div>
                </div>

                <div class="text-right">
                    <button class="btn btn-success mt-2">Submit Payment</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script
    src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
    crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            var stripe = Stripe('{{ config('services.stripe.key') }}');

            // Create an instance of Elements.
            var elements = stripe.elements();

            // Custom styling can be passed to options when creating an Element.
            // (Note that this demo uses a wider set of styles than the guide below.)
            var style = {
            base: {
                color: '#32325d',
                lineHeight: '18px',
                fontFamily: '"Raleway", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
            };

            // Create an instance of the card Element.
            var card = elements.create('card', {
                style: style,
                hidePostalCode: true,
            });

            // Add an instance of the card Element into the `card-element` <div>.
            card.mount('#card-element');

            // Handle real-time validation errors from the card Element.
            card.addEventListener('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
            });

            // Handle form submission.
            var form = document.getElementById('payment-form');
            form.addEventListener('submit', function(event) {
            event.preventDefault();

            var options = {
                name: 'Diego Louis Sanchez'
            }
            
            stripe.createToken(card, options).then(function(result) {
                if (result.error) {
                // Inform the user if there was an error.
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
                } else {
                // Send the token to your server.
                    stripeTokenHandler(result.token);
                }
            });
            });

            function stripeTokenHandler(token) {
                // Insert the token ID into the form so it gets submitted to the server
                var form = document.getElementById('payment-form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', token.id);
                form.appendChild(hiddenInput);
                // alert(token.id);
                // Submit the form
                form.submit();
            }
        });
        // Create a Stripe client.
    </script>
@endsection