<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
   @include('head')
</head>
<body>
@include('navbar')
<main class="container my-5 w-75">
    <div class="navbar navbar-expand-lg bg-white" style="float: right">
        <div class="mt-lg-0 mt-md-2 mt-sm-2 my-2 mt-lg-0 mx-2">
            <a class="mt-lg-0 mt-md-2 mt-sm-2 my-2 mt-lg-0 mx-2" href="{{ route('shopping_cart') }}">
                <button class="btn btn-secondary">
                    <span>🛒</span>
                </button>
            </a>
        </div>
    </div>
    <div class="row">
    <div class="col-md-6">
        <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach($product->images as $image)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <img src="{{ $image->url }}" class="d-block w-100" alt="{{ $product->name }}" style="max-height: 350px;">
                </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <div class="col-md-6">
        <div class="p-4">
            <h1 class="fw-bold">{{ $product->name }}</h1>
            <p class="fw-bold">{{ $product->price }}€/ks</p>
            @if(Auth::check())
                @php
                    $quantityInCart = 0;
                    foreach ($cartItems as $item) {
                        $quantityInCart += $item->quantity;
                    }
                @endphp
            @endif
            <p>Počet kusov: <span id="quantity">{{ $quantityInCart }}</span> / {{ $product->stock }}</p>
            <div class="btn-group" role="group" aria-label="quantity_buttons">
                <button type="button" class="btn btn-secondary" onclick="incrementQuantity()">+</button>
                <button type="button" class="btn btn-secondary" onclick="decrementQuantity()">-</button>
            </div>
            <form method="POST" action="{{ Auth::check() ? route('cart-items.detail') : route('cart-items.detail-session') }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                @if(Auth::check())
                    <input type="hidden" name="user_id" id="user_id_input" value="{{ Auth::user()->id}}">
                @endif
                <input type="hidden" name="quantity" id="quantity_input" value="0">
                <button type="submit" class="btn btn-primary" style="margin-top: 5px;">Do košíka</button>
            </form>
            <p class="mt-3">
                {{ $product->description }}
            </p>
            @if(Auth::check() && Auth::User()->is_admin)
                <a class="nav-link" href="{{ route('detail.edit', $product->id) }}">
                    <button class="btn btn-outline-secondary">
                        Zmeniť
                    </button>
                </a>
            @endif
            @if(session('success'))
            <script>
                alert("{{ session('success') }}");
            </script>
            @endif
        </div>
    </div>
<br>

<script>
    function incrementQuantity() {
        var quantityElement = document.getElementById('quantity');
        var quantityInput = document.getElementById('quantity_input');
        var currentQuantity = parseInt(quantityElement.innerText);
        var stock = {{ $product->stock }};
        
        if (currentQuantity < stock) {
            quantityElement.innerText = currentQuantity + 1;
            quantityInput.value = currentQuantity + 1;
        }
    }

    function decrementQuantity() {
        var quantityElement = document.getElementById('quantity');
        var quantityInput = document.getElementById('quantity_input');
        var currentQuantity = parseInt(quantityElement.innerText);

        if (currentQuantity > 0) {
            quantityElement.innerText = currentQuantity - 1;
            quantityInput.value = currentQuantity - 1;
        }
    }

</script>

</main>
@include('footer')
</body>
</html>