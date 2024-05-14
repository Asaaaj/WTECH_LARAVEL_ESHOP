<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
   @include('head')
</head>
<body>
  @include('navbar')
  <main class="container my-5">
      <div class="row">
        <div class="col-md-6 offset-md-3">
          <h3 class="d-flex justify-content-center">Prihlásenie</h3>
          <form class="needs-validation" novalidate>
            <div class="d-block mt-2">
              <label for="email" class="form-label">E-mail</label>
              <div class="input-group has-validation">
                <span class="input-group-text" id="inputGroupPrepend">@</span>
                <input
                  type="email"
                  class="form-control"
                  id="email"
                  aria-describedby="inputGroupPrepend"
                  placeholder="Zadajte e-mail"
                  required />
              </div>
            </div>
            <div class="d-block mt-2">
              <label for="password" class="form-label">Heslo</label>
              <input
                type="password"
                class="form-control"
                id="password"
                placeholder="Zadajte heslo"
                required />
            </div>
            <div class="d-flex justify-content-center mt-4">
              <button class="btn btn-primary" type="submit">
                Prihlásiť sa
              </button>
            </div>
          </form>
        </div>
        <div class="d-flex justify-content-center mt-4">
          <a class="" href="{{ route('register') }}"
            ><button class="btn btn-outline-secondary">
              Ešte nemám účet
            </button></a
          >
        </div>
      </div>
    </main>

  @include('footer')
  </body>
</html>
