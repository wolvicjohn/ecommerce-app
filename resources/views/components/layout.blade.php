<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PC SHOP</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    </head>
    <body>
        
     @if (session('message'))
        <script>
            swal({
                title: "Success!",
                text: "{{ session('message') }}",
                icon: "success",
                button: "OK",
                timer: 3000
            });
        </script>
    @endif



     <x-header />
     {{-- content page --}}
    {{ $slot }}
    </body>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                        Swal.fire({
                            title: "Success!",
                            text: "Item added to Cart!",
                            icon: "success",
                            confirmButtonText: "OK",
                            timer: 3000
                        });
                        $('#cart-counter').text(response.cartCount);
                    },
                    error: function (xhr) {
                        Swal.fire({
                            title: "Oops!",
                            text: "Something went wrong",
                            icon: "error",
                            confirmButtonText: "OK",
                            timer: 3000
                        });
                        console.error(xhr.responseText);
                    }
                });
            });
        });

    //   checkout 
    const checkoutBtn = document.getElementById('checkout-btn');

    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', function () {
            @if(auth()->check())
                Swal.fire({
                    title: "Success!",
                    text: "Proceeding to checkout...",
                    icon: "success",
                    confirmButtonText: "OK"
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('checkout-form').submit();
                        window.location.href = "{{ route('homepage') }}";
                    }
                });
            @else
                Swal.fire({
                    title: "Oops!",
                    text: "Login to proceed!",
                    icon: "error",
                    confirmButtonText: "OK"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('login') }}";
                    }
                });
            @endif
        });
    }

    </script>

</html>
