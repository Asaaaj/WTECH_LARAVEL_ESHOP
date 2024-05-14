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
          <h3 class="d-flex justify-content-center">Registrácia</h3>
          <form class="needs-validation" novalidate>
            <div class="d-block">
              <label for="validationName" class="form-label"
                >Meno a Priezvisko</label
              >
              <input
                type="text"
                class="form-control"
                id="validationName"
                placeholder="Zadajte meno"
                required />
              <div class="invalid-feedback">Prosím zadajte správne údaje.</div>
            </div>

            <div class="d-block mt-2">
              <label for="validationEmail" class="form-label">E-mail</label>
              <div class="input-group has-validation">
                <span class="input-group-text" id="inputGroupPrepend">@</span>
                <input
                  type="email"
                  class="form-control"
                  id="validationEmail"
                  aria-describedby="inputGroupPrepend"
                  placeholder="Zadajte e-mail"
                  required />
                <div class="invalid-feedback">
                  Prosím zadajte správne údaje.
                </div>
              </div>
            </div>
            <div class="d-block mt-2">
              <label for="validationPassword" class="form-label">Heslo</label>
              <input
                type="password"
                class="form-control"
                id="validationPassword"
                placeholder="Zadajte heslo"
                required />
              <div class="invalid-feedback">Prosím zadajte správne údaje.</div>
            </div>
            <div class="d-flex justify-content-center mt-4">
              <button class="btn btn-primary" type="submit">Registrovať</button>
            </div>
          </form>
        </div>
        <div class="d-flex justify-content-center mt-4">
          <a class="" href="{{ route('login') }}"
            ><button class="btn btn-outline-secondary">Už mám účet</button></a
          >
        </div>
      </div>
    </main>

  @include('footer')
  <script src="{{ asset('js/form-validation.js') }}"></script>
  </body>
</html>
