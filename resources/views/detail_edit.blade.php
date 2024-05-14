<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
   @include('head')
</head>
<body>
@include('navbar')

<main class="container" style="margin-top: 50px; text-align: center">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <a href="{{ route('detail', ['id' => $product->id]) }}">
                <button class="btn btn-outline-secondary">Späť</button>
            </a>
            <br><br>
            <form action="{{ route('product.update', $product->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="nazov" class="form-label">Názov:</label>
                    <input type="text" id="nazov" name="nazov" class="form-control" value="{{ $product->name }}" placeholder="Názov produktu">
                </div>
                <div class="mb-3">
                    <label for="cena" class="form-label">Cena:</label>
                    <input type="number" id="cena" name="cena" class="form-control" value="{{ $product->price }}" placeholder="Cena produktu">
                </div>
                <div class="mb-3">
                    <label for="pocet" class="form-label">Počet:</label>
                    <input type="number" id="pocet" name="pocet" class="form-control" value="{{ $product->stock }}" placeholder="Počet produktov">
                </div>
                <div class="mb-3">
                    <label for="informacie" class="form-label">Informácie o produkte:</label>
                    <textarea id="informacie" name="informacie" class="form-control" placeholder="Informácie o produkte">{{ $product->description }}</textarea>
                </div>
                <div class="mb-3">  
                    <label for="obrazky" class="form-label">Obrázky:</label>
                    <input type="file" id="obrazky" name="obrazky[]" class="form-control" multiple accept="image/*">
                </div>
                <br>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Uložiť a zmeniť</button>
                </div>
            </form>

            <div class="mb-3">
                <form id="deleteForm" action="{{ route('product.delete', ['id' => $product->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Vymazať produkt</button>
                </form>
            </div>
            <br>
            <br>
            
            @if($images->isNotEmpty())
                <div class="mb-3">
                    <label for="existingImages" class="form-label">Existujúce obrázky:</label>
                    <div id="existingImages">
                        @foreach($images as $image)
                            <div>
                                <img src="{{ $image->url }}" alt="{{ $image->name }}" style="max-width: 200px;margin-top: 50px;">
                                <form action="{{ route('product.removeImage', ['productId' => $product->id, 'imageId' => $image->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Odstrániť</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            
        </div>
    </div>
</main>

@include('footer')
</body>
</html>
