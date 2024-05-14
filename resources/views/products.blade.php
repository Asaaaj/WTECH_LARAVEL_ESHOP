<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
   @include('head')
</head>
<body>
   @include('navbar')
    <main class="container mt-2 mb-5 w-75">
      <div class="navbar navbar-expand-lg bg-white">
        <div class="container-fluid">
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#filterNavAltMarkup"
            aria-controls="filterNavAltMarkup"
            aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>Filtrovať
          </button>
          <div class="collapse navbar-collapse" id="filterNavAltMarkup">
            <form action="{{ route('products') }}" method="GET" class="navbar-nav">
            <div class="navbar-nav">
              <div class="dropdown mx-2 mt-lg-0 mt-md-2 mt-sm-2">
                <button
                  class="btn btn-secondary dropdown-toggle"
                  type="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false">
                  Zoradiť podľa
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item {{ Request::get('sort') === 'najnovsie' ? 'active' : '' }}" href="{{ route('products', array_merge(request()->except('sort'), ['sort' => 'najnovsie'])) }}">Najnovšie</a>
                    </li>
                    <li>
                        <a class="dropdown-item {{ Request::get('sort') === 'najmensie' ? 'active' : '' }}" href="{{ route('products', array_merge(request()->except('sort'), ['sort' => 'najmensie'])) }}">Cena od najmenšej</a>
                    </li>
                    <li>
                        <a class="dropdown-item {{ Request::get('sort') === 'najvacsie' ? 'active' : '' }}" href="{{ route('products', array_merge(request()->except('sort'), ['sort' => 'najvacsie'])) }}">Cena od najväčšej</a>
                    </li>
                </ul>
              </div>
            </div>
            <div class="navbar-nav">
                <div class="dropdown mx-2 mt-lg-0 mt-md-2 mt-sm-2">
                    <button
                        class="btn btn-secondary dropdown-toggle"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Kategórie
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <div class="dropdown-item">
                                <input class="form-check-input" name="category[]" type="checkbox" value="Kúrenie" id="kurenieCheckbox" @if(in_array('Kúrenie', request()->input('category', []))) checked @endif>
                                <label class="form-check-label" for="kurenieCheckbox">Kúrenie</label>
                            </div>
                        </li>
                        <li>
                            <div class="dropdown-item">
                                <input class="form-check-input" name="category[]"  type="checkbox" value="Voda" id="vodaCheckbox" @if(in_array('Voda', request()->input('category', []))) checked @endif>
                                <label class="form-check-label" for="vodaCheckbox">Voda</label>
                            </div>
                        </li>
                        <li>
                            <div class="dropdown-item">
                                <input class="form-check-input" name="category[]" type="checkbox" value="Plyn" id="plynCheckbox"  @if(in_array('Plyn', request()->input('category', []))) checked @endif>
                                <label class="form-check-label" for="plynCheckbox">Plyn</label>
                            </div>
                        </li>
                    </ul>
                </div>
              </div>
    
            <div class="navbar-nav vw-50">
              <div class="navbar-link mx-2 mt-lg-0 mt-md-2 mt-sm-2">
                <div
                  class="dropdown-item">
                  <div class="input-group">
                    <span class="input-group-text border-secondary bg-secondary text-white" id="inputGroup-sizing-default">Cena od</span>
                    <input type="number" name="min_price" min="0" placeholder="0" value="{{ Request::get('min_price') }}" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                  </div>
                </div>
              </div>
            </div>
            <div class="navbar-nav vw-50">
                <div class="navbar-link mx-2 mt-lg-0 mt-md-2 mt-sm-2">
                  <div
                    class="dropdown-item">
                    <div class="input-group">
                      <span class="input-group-text bg-secondary text-white" id="inputGroup-sizing-default">Cena do</span>
                      <input type="number" name="max_price" min="0" placeholder="99" value="{{ Request::get('max_price') }}" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                    </div>
                  </div>
                </div>
            </div>
            <div class="navbar-nav">
                <div class="dropdown mx-2 mt-lg-0 mt-md-2 mt-sm-2">
              <button type="submit" class="btn btn-primary">Potvrdiť</button>
                </div>
            </div>
            </form>
            </div>
            </div>
            <div class="ms-auto ms-lg-0">
              <div class="mt-lg-0 mt-md-2 mt-sm-2 my-2">
                <form class="form-inline input-group mx-2 w-100" action="{{ route('products')}}" method="GET">
                    @foreach(request()->except(['search']) as $key => $value)
                        @if(is_array($value))
                            @foreach($value as $item)
                                <input type="hidden" name="{{ $key }}[]" value="{{ $item }}">
                            @endforeach
                        @else
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endif
                    @endforeach
                  <input
                    class="form-control mr-sm-2"
                    type="search"
                    placeholder="Vyhľadať"
                    aria-label="Search" 
                    name="search"/>
                  <button
                    class="btn btn-success my-2 my-sm-0 input-group-text"
                    type="submit">
                    🔍
                  </button>
                </form>
              </div>
            </div>
          
        <div class="mt-lg-0 mt-md-2 mt-sm-2 my-2 mt-lg-0 mx-2">
          <a
            class="mt-lg-0 mt-md-2 mt-sm-2 my-2 mt-lg-0 mx-2"
            href="{{ route('shopping_cart') }}"
            ><button class="btn btn-secondary">
              <span>🛒</span>
            </button></a
          >
        </div>
        @if(Auth::check() && Auth::user()->is_admin) 
        <div class="mt-lg-0 mt-md-2 mt-sm-2 my-2 mt-lg-0 ms-auto">
            <a href="{{ route('new_product_admin') }}"
              ><button class="btn btn-secondary">
                <span>➕</span>
              </button></a
            >
          </div>
        @endif
      </div>
      
        @if ($products->count() > 0)
        <div
        class="row row-cols-1 row-cols-sm-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-3 px-sm-auto">
            @foreach ($products as $product)
                <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-4 mb-4 d-flex justify-content-center">
                    <div class="card" style="width: 18rem">
                        @foreach($product->images as $image)
                            @if ($loop->first)
                              <img src="{{ $image->url }}" class="card-img-top img-fluid" alt="{{ $product->name }}" style="max-height: 150px;">
                            @endif
                        @endforeach
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{\Illuminate\Support\Str::limit($product->description, $limit = 75, $end = '...') }}</p>
                            <div class="d-flex justify-content-evenly align-items-center">
                                <a href="{{ route('detail', ['id' => $product->id]) }}" class="btn btn-primary">Detail</a>
                                <h5>{{ $product->price }}€</h5>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @else
            <div class="mt-4 mb-4 d-flex justify-content-center">
                <h2>Žiadný produkt nie je k dispozícii.</h2>
            </div>
        @endif
        
          
        
      </div>

      <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            @if ($products->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">Prvá stránka</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $products->previousPageUrl() }}" rel="prev">Predchadzajúca</a>
                </li>
            @endif
    
            @if ($products->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $products->nextPageUrl() }}" rel="next">Ďalšia</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">Posledná stránka</span>
                </li>
            @endif
        </ul>
    </nav>
    
    
    
    </main>

    @include('footer')
  </body>
</html>
