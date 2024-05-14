<div class="sticky-top">
    <div class="d-flex justify-content-center w-100 bg-white">
        <a class="logo" href="{{ route('landing_page') }}">KVP</a>
    </div>
    <nav class="navbar navbar-expand-lg bg-white">
        <div class="container-fluid">
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup"
                aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link" href="{{ route('landing_page') }}">
                        <button class="btn btn-outline-secondary">Domov</button></a>
                    <a class="nav-link" href="{{ route('products') }}">
                        <button class="btn btn-outline-secondary">Produkty</button>
                    </a>
                </div>
                <div class="navbar-nav ms-auto">
                @if (!Auth::check())
                    <a class="nav-link" href="{{ route('login') }}">
                        <button class="btn btn-outline-secondary">
                        Prihlásenie
                        </button>
                    </a>
                    <a class="nav-link" href="{{ route('register') }}">
                        <button class="btn btn-outline-primary">Registrácia</button>
                    </a>
                @else
                    <a class="nav-link">
                        <x-responsive-nav-link :href="route('profile.edit')">
                            <button class="btn btn-outline-secondary">{{ Auth::user()->name}}</button>
                        </x-responsive-nav-link>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="nav-link">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                this.closest('form').submit();">
                            <button class="btn btn-outline-primary">{{'Odhlásiť sa'}}</button>
                        </x-responsive-nav-link>
                    </form>
                @endif
                </div>
            </div>
        </div>
    </nav>
</div>