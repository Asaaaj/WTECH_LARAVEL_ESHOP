<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
   @include('head')
   <link rel="stylesheet" href="{{ asset('css/landing_page_carousel.css') }}">
  </head>
  <body>
   @include('navbar')
    <div>
      <div>
        <div
          id="carouselExampleInterval"
          class="carousel slide"
          data-bs-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="3000">
              <img
                src="https://images.unsplash.com/photo-1599028274511-e02a767949a3?q=80&w=2071&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                class="carousel-img"
                alt="Heating" />
            </div>
            <div class="carousel-item" data-bs-interval="3000">
              <img
                src="https://images.unsplash.com/photo-1542013936693-884638332954?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                class="carousel-img"
                alt="Water" />
            </div>
            <div class="carousel-item" data-bs-interval="3000">
              <img
                src="https://images.unsplash.com/photo-1601914697928-0b536e76d048?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTR8fGdhc3xlbnwwfHwwfHx8Mg%3D%3D"
                class="carousel-img"
                alt="Gas" />
            </div>
          </div>
        </div>
        <button
          class="carousel-control-prev"
          type="button"
          data-bs-target="#carouselExampleInterval"
          data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button
          class="carousel-control-next"
          type="button"
          data-bs-target="#carouselExampleInterval"
          data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </div>

    <div class="d-flex justify-content-center my-5">
      <a class="" href="{{ route('products') }}"
        ><button class="btn btn-lg btn-outline-secondary w-100">
          Vstúpiť
        </button></a
      >
    </div>

  @include('footer')
  </body>
</html>
