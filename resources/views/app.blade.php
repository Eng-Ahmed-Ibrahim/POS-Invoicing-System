<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{asset('assets/static/logo.png')}}" type="image/x-icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Bootstrap Select CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.14/css/bootstrap-select.min.css">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="{{asset('assets/css/styles.css')}}?v={{ time() }}">

    @yield('css')
    <style>
        .bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn) {
            width: 100%;
        }
    </style>
</head>

<body>
    <header class="header-desktop">
        <section>
            <div class="logo"><a href="/"><img src="{{asset('assets/static/logo.png')}}" alt=""></a></div>
            <div class="links">
                <a href="{{route('home')}}" class="{{Request::is('/') ? 'active' : ''}}">Overview</a>
                <a href="{{route('invoices')}}" class="{{Request::is('invoices') ? 'active' : ''}}">Invoices</a>
                <a href="{{route('clients')}}" class="{{Request::is('clients') ? 'active' : ''}}">Clients</a>
                <a href="{{route('categories')}}" class="{{Request::is('categories') ? 'active' : ''}}">Categories</a>
                <a href="{{route('products')}}" class="{{Request::is('products') ? 'active' : ''}}">Products</a>
            </div>
        </section>
        <section>
            <div class="profile">
                <div class="dropdown">
                    <img src="{{asset('assets/static/user.png')}}" class=" profile-img-50 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" alt="">
                    <ul class="dropdown-menu">
                    <li>
                        <form action="{{route('logout')}}" method="post">
                            @csrf
                            <button class="dropdown-item" type="submit"><i class="fa-solid fa-arrow-right-from-bracket"></i> <span class="mx-2">Sign Out</span> </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        </section>
    </header>

    <header class="header-mobile tabs-container my-2">
        <div class="links">
            <a href="{{route('home')}}" class="{{Request::is('/') ? 'active' : ''}}">Overview</a>
            <a href="{{route('invoices')}}" class="{{Request::is('invoices') ? 'active' : ''}}">Invoices</a>
            <a href="{{route('clients')}}" class="{{Request::is('clients') ? 'active' : ''}}">Clients</a>
            <a href="{{route('categories')}}" class="{{Request::is('categories') ? 'active' : ''}}">Categories</a>
            <a href="{{route('products')}}" class="{{Request::is('products') ? 'active' : ''}}">Products</a>
        </div>
    </header>

    <main>
        <div style="display: flex; justify-content:space-between">
            <h4 class="mb-3">@yield('title')</h4>
            <div style="display: flex; justify-content:space-between">
                @yield("create-button")
            </div>
        </div>
        <div class="content my-2">
            @yield("content")
        </div>
    </main>

    <!-- Toastr Container -->
    <div aria-live="polite" aria-atomic="true" style="position: relative; z-index: 1031;">
        <div class="toast-container toast-top-right"></div>
    </div>

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Bootstrap Select and Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.14/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="{{asset('assets/js/scripts.js')}}?v={{ time() }}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}?v={{ time() }}"></script>

    @yield('js')

    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "hideDuration": "1000",
            "showDuration": "300"
        };
        @if(session('success'))
        toastr.success("{{ session('success') }}");
        @endif
        @if(session('error'))
        toastr.error("{{ session('error') }}");
        @endif
        @if($errors-> any())
        @foreach($errors-> all() as $error)
        toastr.error("{{ $error }}");
        @endforeach
        @endif

        $(document).ready(function() {
            $('.selectpicker').selectpicker();
        });
    </script>
</body>

</html>