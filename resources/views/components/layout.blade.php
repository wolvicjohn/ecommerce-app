<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PC SHOP</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <body>
        
     @session('message')
        <div class="success-message">
            {{ session('message')}}
        </div>
     @endsession

     <x-header />
    {{ $slot }}

    @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
    </body>
    <script>
        $(document).ready(function () {
            $('.add-to-cart-form').on('submit', function (e) {
                e.preventDefault();

                const form = $(this);
                const productId = form.data('id');
                const token = form.find('input[name="_token"]').val();

                $.ajax({
                    url: "{{ route('carts.store') }}", 
                    method: "POST",
                    data: {
                        _token: token,
                        product_id: productId
                    },
                    success: function (response) {
                        alert("Product added to cart!");
                        $('#cart-counter').text(response.cartCount);
                    },
                    error: function (xhr) {
                        alert("Error adding to cart.");
                        console.error(xhr.responseText);
                    }
                });
            });
        });

    //   checkout btn
        document.getElementById('checkout-btn').addEventListener('click', function () {
            @if(auth()->check())
                alert("Proceeding to checkout...");
            @else
                window.location.href = "{{ route('login') }}";
            @endif
        });
    </script>

</html>
