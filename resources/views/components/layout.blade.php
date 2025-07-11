<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>TECHSTORE</title>

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



     <div class="flex flex-col min-h-screen">
        <x-header />

        <main class="flex-grow">
            {{ $slot }}
        </main>

        <footer class="bg-gray-800 text-white text-center py-4">
            <p>&copy; {{ date('Y') }} PC SHOP.</p>
        </footer>
    </div>

    </body>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // add product ajax
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
    // cancel item in cart
    document.addEventListener('DOMContentLoaded', function () {
        const cancelButtons = document.querySelectorAll('.cancel-item-btn');

        cancelButtons.forEach(button => {
            button.addEventListener('click', function () {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to remove this item from your cart?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, remove it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.closest('form').submit();
                    }
                });
            });
        });
    });

    // remove category
    document.addEventListener('DOMContentLoaded', function () {
        const deleteForms = document.querySelectorAll('.delete-form');

        deleteForms.forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault(); 

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will delete the category permanently.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); 
                    }
                });
            });
        });
    });

    </script>

</html>
