<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
   @include('head')
</head>
<body>
@include('navbar')
<main class="container" style="margin-top: 50px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-center">
                <a class="" href="{{ route('shopping_cart') }}"
                ><button class="btn btn-outline-secondary">Späť</button></a
                >
            </div>
            <br><br>
            <form action="{{ route('payment.submit') }}" method="post" onsubmit="return validateForm()">
                @csrf
                <div class="mb-3">
                    <label for="meno" class="form-label">Meno:</label>
                    <input type="text" id="meno" name="meno" class="form-control" placeholder="Meno Priezvisko">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="email@adresa.sk">
                </div>
                <div class="mb-3">
                    <label for="ulica" class="form-label">Ulica:</label>
                    <input type="text" id="ulica" name="ulica" class="form-control" placeholder="Ilkovičova 2">
                </div>
                <div class="mb-3">
                    <label for="mesto" class="form-label">Mesto:</label>
                    <input type="text" id="mesto" name="mesto" class="form-control" placeholder="Bratislava">
                </div>
                <div class="mb-3">
                    <label for="psc" class="form-label">PSČ:</label>
                    <input type="text" id="psc" name="psc" class="form-control" placeholder="123 45">
                </div>
                <div class="mb-3">
                    <label for="krajina" class="form-label">Krajina:</label>
                    <input type="text" id="krajina" name="krajina" class="form-control" placeholder="Slovensko">
                </div>
                <div class="mb-3">
                    <label for="telefon" class="form-label">Telefónne číslo:</label>
                    <input type="tel" id="telefon" name="telefon" class="form-control" placeholder="+421900123456">
                </div>
                <div class="mb-3">
                    <label class="form-label">Spôsob dopravy:</label>
                    <div class="form-check">
                        <input type="radio" id="kurier" name="doprava" value="kurier" class="form-check-input">
                        <label for="kurier" class="form-check-label">Kuriér na adresu</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" id="packeta" name="doprava" value="packeta" class="form-check-input">
                        <label for="packeta" class="form-check-label">Packeta ZBOX</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Spôsob platby:</label>
                    <div class="form-check">
                        <input type="radio" id="kartou" name="platba" value="kartou" class="form-check-input" onchange="toggleCardInputs()">
                        <label for="kartou" class="form-check-label">Kartou online</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" id="dobierka" name="platba" value="dobierka" class="form-check-input" onchange="toggleCardInputs()">
                        <label for="dobierka" class="form-check-label">Dobierka</label>
                    </div>
                </div>
                <div id="card-details" style="display: none;">
                    <div class="mb-3">
                        <label for="card-number" class="form-label">Číslo karty:</label>
                        <input type="text" id="card-number" name="card-number" class="form-control" placeholder="XXXX XXXX XXXX XXXX">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="expiration-date">Dátum:</label>
                            <input type="text" id="expiration-date" name="expiration-date" placeholder="MM/YY">
                        </div>
                        <div class="col-md-6">
                            <label for="cvc">CVC:</label>
                            <input type="text" id="cvc" name="cvc" placeholder="XXX">
                        </div>
                        <br><br>
                    </div>
                </div>
                <br>
                <div class="text-center">
                    <button type="submit" class="btn btn-outline-primary">Dokončiť objednávku</button>
                </div>
                <br>
            </form>
        </div>
    </div>
</main>

@include('footer')
<script>
    function validateForm() {
        var name = document.getElementById('meno').value.trim();
        var email = document.getElementById('email').value.trim();
        var ulica = document.getElementById('ulica').value.trim();
        var mesto = document.getElementById('mesto').value.trim();
        var psc = document.getElementById('psc').value.trim();
        var krajina = document.getElementById('krajina').value.trim();
        var telefon = document.getElementById('telefon').value.trim();
        var doprava = document.querySelector('input[name="doprava"]:checked');
        var platba = document.querySelector('input[name="platba"]:checked');
        var cardNumber = document.getElementById('card-number').value.trim();
        var expirationDate = document.getElementById('expiration-date').value.trim();
        var cvc = document.getElementById('cvc').value.trim()

        if (name === '' || email === '' || ulica === '' || mesto === '' || psc === '' || krajina === '' || telefon === '' || !doprava || !platba) {
            alert('Please fill in all required fields.');
            return false;
        }

        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            alert('Please enter a valid email address.');
            return false;
        }

        var pscRegex = /^\d{3} \d{2}$/;
        if (!pscRegex.test(psc)) {
            alert('Please enter a valid postal code in the format XXX XX.');
            return false;
        }

        if (platba && platba.value === 'kartou') {
            if (cardNumber === '' || expirationDate === '' || cvc === '') {
                alert('Please fill in all card details.');
                return false;
            }

            var cardNumberRegex = /^\d{4} \d{4} \d{4} \d{4}$/;
            if (!cardNumberRegex.test(cardNumber)) {
                alert('Please enter a valid card number in the format XXXX XXXX XXXX XXXX.');
                return false;
            }

            var expirationDateRegex = /^(0[1-9]|1[0-2])\/\d{2}$/;
            if (!expirationDateRegex.test(expirationDate)) {
                alert('Please enter a valid expiration date in the format MM/YY.');
                return false;
            }

            var cvcRegex = /^\d{3}$/;
            if (!cvcRegex.test(cvc)) {
                alert('Please enter a valid CVC (three digits).');
                return false;
            }
        }
        return true;
    }

    function toggleCardInputs() {
        var cardDetails = document.getElementById('card-details');
        var kartouRadio = document.getElementById('kartou');

        if (kartouRadio.checked) {
            cardDetails.style.display = 'block';
        } else {
            cardDetails.style.display = 'none';
        }
    }
</script>

</body>
</html>
