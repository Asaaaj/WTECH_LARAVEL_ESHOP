<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
   @include('head')
</head>
<body>
@include('navbar')
<main class="container" style="text-align: center">
    <h2><b>Hurá</b></h2>
    <br>
    <h4>Vaša objednávka s identifikačným číslom {{ request('orderId') }} bola úspešne vytvorená</h4>
    <br>
    <a class="nav-link" href="{{ route('landing_page') }}"
    ><button class="btn btn-outline-secondary">
        Domov
    </button></a
    >
    <br>
</main>

@include('footer')
</body>
</html>
