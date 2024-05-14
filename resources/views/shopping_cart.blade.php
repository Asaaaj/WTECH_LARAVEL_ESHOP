<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
   @include('head')
    <style>
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>
<body>
@include('navbar')
<main class="container" style="text-align: center">
    <br>
    <h2>Nákupný košík</h2>
    <br>
    @if($cartItems->isNotEmpty())
        @foreach($cartItems as $cartItem)
        <div class="card mb-3">
            <div class="row g-0">
                <div class="col-md-6">
                    @foreach($cartItem->product->images as $image)
                        @if ($loop->first)
                            <img src="{{ $image->url }}" class="card-img-top" alt="{{ $cartItem->product->name }}" style="width: 200px; height: 200px; padding: 10px">
                        @endif
                    @endforeach
                </div>
                <div class="col-md-6">
                    <div class="card-body">
                        <h3 class="card-title">{{ $cartItem->product->name }}</h3>
                        <p>Počet kusov: <span id="quantity_{{ $cartItem->id }}" data-max="{{ $cartItem->product->stock }}">{{ $cartItem->quantity }}</span> / {{ $cartItem->product->stock }}</p>
                        <div class="btn-group" role="group" aria-label="quantity_buttons">
                            <button type="button" class="btn btn-secondary" onclick="incrementQuantity('{{ $cartItem->id }}')">+</button>
                            <button type="button" class="btn btn-secondary" onclick="decrementQuantity('{{ $cartItem->id }}')">-</button>
                        </div>
                        <form method="POST" action="{{ route('cart-items.update', $cartItem->id) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="product_id" value="{{ $cartItem->product->id }}">
                            <input type="hidden" name="user_id" value="{{ Auth::check() ? Auth::user()->id : -1 }}">
                            <input type="hidden" id="price_per_item_{{ $cartItem->id }}" value="{{ $cartItem->product->price }}">
                            <input type="hidden" name="quantity" id="quantity_input_{{ $cartItem->id }}" value="{{ $cartItem->quantity }}" data-max="{{ $cartItem->product->stock }}">
                            <button type="submit" class="btn btn-primary" style="margin-top: 5px;">Aktualizovať</button>
                        </form>
                        <form method="POST" action="{{ route('cart-items.remove', $cartItem->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="margin-top: 5px;">Zmazať</button>
                        </form>
                        <p class="card-text">Cena: <span id="price_{{ $cartItem->id }}" data-price="{{ $cartItem->product->price * $cartItem->quantity }}">{{ $cartItem->product->price * $cartItem->quantity }}</span>€</p>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    @else
        <p>Nákupný košík je prázdny.</p>
    @endif
    <br>
    <h2 id="totalPrice">Celková suma: {{ $totalPrice }}€</h2>
    <br>
    @if($cartItems->isNotEmpty())
        @if(Auth::check())
            <a href="{{ route('payment') }}">
                <button class="btn btn-primary">Pokračovať k platbe</button>
            </a>
        @else
            <p>Pre pokračovanie k platbe je potrebné prihlásiť sa.</p>
            <a href="{{ route('login') }}">
                <button class="btn btn-primary">Prihlásiť sa</button>
            </a>
        @endif
    @endif
    <br><br>
</main>

<script>
    function incrementQuantity(cartItemId) {
        var quantitySpan = document.getElementById('quantity_' + cartItemId);
        var quantityInput = document.getElementById('quantity_input_' + cartItemId);
        var currentQuantity = parseInt(quantitySpan.innerText);
        var maxQuantity = parseInt(quantitySpan.dataset.max);

        if (currentQuantity < maxQuantity) {
            quantitySpan.innerText = currentQuantity + 1;
            quantityInput.value = currentQuantity + 1;
            updatePrice(cartItemId, currentQuantity + 1, currentQuantity);
        }
    }

    function decrementQuantity(cartItemId) {
        var quantitySpan = document.getElementById('quantity_' + cartItemId);
        var quantityInput = document.getElementById('quantity_input_' + cartItemId);
        var currentQuantity = parseInt(quantitySpan.innerText);
        

        if (currentQuantity > 0) {
            quantitySpan.innerText = currentQuantity - 1;
            quantityInput.value = currentQuantity - 1;
            updatePrice(cartItemId, currentQuantity - 1, currentQuantity);
        }
    }

    function updatePrice(cartItemId, quantity, previousQuantity) {
        var pricePerItem = parseFloat(document.getElementById('price_per_item_' + cartItemId).value);
        var totalPrice = pricePerItem * quantity;

        var priceElement = document.getElementById('price_' + cartItemId);
        priceElement.innerText = totalPrice.toFixed(2);

        var total = 0;
        document.querySelectorAll('[id^="price_"]').forEach(function(element) {
            var priceValue = parseFloat(element.innerText.replace('€', ''));
            if (!isNaN(priceValue)) {
                total += priceValue;
            }
        });
        document.getElementById('totalPrice').innerText = 'Celková suma: ' + total.toFixed(2) + '€';
    }
</script>

@include('footer')
</body>
</html>


