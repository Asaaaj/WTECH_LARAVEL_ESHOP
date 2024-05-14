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
          <div class="d-flex justify-content-center">
            <a class="" href="{{ route('products') }}"
              ><button class="btn btn-outline-secondary">Späť</button></a
            >
          </div>
          <h3 class="d-flex justify-content-center mt-4">Nový produkt</h3>
          <form class="" method="POST" action="{{ route('new_product_admin') }}" enctype="multipart/form-data">
            @csrf
            <div class="d-block">
              <label for="validationName" class="form-label"
                >Názov produktu</label
              >
              <input
                name="name"
                type="text"
                class="form-control"
                id="validationName"
                placeholder="Zadajte názov"
                required />
            </div>

            <div class="d-block mt-2">
              <label for="validationPrice" class="form-label">Cena</label>
              <div class="input-group">
                <span class="input-group-text" id="inputGroupPrepend">€</span>
                <input
                name="price"
                  type="number"
                  class="form-control"
                  id="validationPrice"
                  aria-describedby="inputGroupPrepend"
                  placeholder="0"
                  required 
                  min="0"/>
              </div>
            </div>
            <div class="d-block mt-2">
                <label for="validationCount" class="form-label">Počet kusov</label>
                <div class="input-group">
                  
                  <input
                    name="count"
                    type="number"
                    class="form-control"
                    id="validationCount"
                    aria-describedby="inputGroupAppend"
                    placeholder="0"
                    required 
                    min="0"/>
                    <span class="input-group-text" id="inputGroupAppend">ks</span>
                </div>
              </div>
            <div class="d-block mt-2">
                <label for="type" class="form-label">Kategória</label>
              <select class="form-select" aria-label="Kategoria" name="type" id="type">
                <option value="Kúrenie" selected>Kúrenie</option>
                <option value="Voda">Voda</option>
                <option value="Plyn">Plyn</option>
              </select>
            </div>
            <div class="d-block mt-2">
              <label for="floatingTextarea" class="form-label"
                >Informácie o produkte</label
              >
              <textarea
                name="info"
                class="form-control"
                placeholder="Info"
                id="floatingTextarea"
                required
                style="resize: none"></textarea>
            </div>
            <div class="d-block mt-2">
              <label for="formFile" class="form-label" >Vložte obrázky</label>
              <input class="form-control" type="file" id="formFile" name="images[]"  accept="image/*" multiple required/>
            </div>
            <div class="d-flex justify-content-center mt-4">
              <button class="btn btn-primary" type="submit">
                Vytvoriť nový produkt
              </button>
            </div>
          </form>
        </div>
      </div>
    </main>

    @include('footer')
  </body>
</html>
