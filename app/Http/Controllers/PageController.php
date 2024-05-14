<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Image;
use App\Models\CartItem;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;


class PageController extends Controller
{

    public function landingPage()
    {
        if (session_status() == PHP_SESSION_NONE && !Auth::check()) {
            Session::start();
        }
        return view('landing_page');
    }

    public function layout()
    {
        return view('layout');
    }

    public function login()
    {
        return view('login');
    }

    public function newProductAdmin()
    {
        return view('new_product_admin');
    }

    public function order()
    {
        return view('order');
    }

    public function submitOrder(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'meno' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'ulica' => 'required|string|max:255',
            'mesto' => 'required|string|max:255',
            'psc' => 'required|string|max:6',
            'krajina' => 'required|string|max:255',
            'telefon' => 'required|string|max:20',
            'doprava' => 'required|string|in:kurier,packeta',
            'platba' => 'required|string|in:kartou,dobierka',
        ]);
    
        $user = Auth::user();
    
        $address = Address::firstOrCreate([
            'street' => $validatedData['ulica'],
            'city' => $validatedData['mesto'],
            'postal_code' => $validatedData['psc'],
            'country' => $validatedData['krajina'],
        ]);
    
        $order = Order::create([
            'customer_id' => $user->id,
            'address_id' => $address->id,
            'name' => $validatedData['meno'],
            'email' => $validatedData['email'],
            'phone_number' => $validatedData['telefon'],
            'status' => 'pending', 
            'delivery_type' => $validatedData['doprava'],
        ]);

        $orderId = $order->id;
    
        $cartItems = CartItem::where('user_id', $user->id)->get();
    
        foreach ($cartItems as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
            ]);
        }
    
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
    
        $paymentStatus = ($validatedData['platba'] === 'dobierka') ? 'pending' : 'paid';

        Transaction::create([
            'order_id' => $order->id,
            'price' => $totalPrice,
            'payment_status' => $paymentStatus,
            'payment_method' => $validatedData['platba'],
        ]);
    
        CartItem::where('user_id', $user->id)->delete();
    
        return redirect()->route('order', ['orderId' => $orderId])->with('success', 'Objednávka bola úspešne vytvorená.');
    }

    public function payment()
    {
        return view('payment');
    }

    public function products(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort', 'najnovsie');
        $categories = $request->input('category', ['Kúrenie', 'Voda', 'Plyn']);
        $min_price = $request->input('min_price');
        $max_price = $request->input('max_price');

        $productsQuery = Product::query();

        if ($sort === 'najnovsie') {
            $productsQuery->orderBy('created_at', 'desc');
        } elseif ($sort === 'najmensie') {
            $productsQuery->orderBy('price');
        } elseif ($sort === 'najvacsie') {
            $productsQuery->orderBy('price', 'desc');
        }
        if (!empty($categories)) {
            $productsQuery->whereIn('type', $categories);
        }
        if (!empty($min_price)) {
            $productsQuery->where('price', '>=', $min_price);
        }
        
        if (!empty($max_price)) {
            $productsQuery->where('price', '<=', $max_price);
        }

        if (!empty($search)) {
            $productsQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%");
            });
        }

        $products = $productsQuery->paginate(9)->withQueryString();

        return view('products', compact('products'));
    }

    public function detail(Request $request)
    {
        $productId = $request->input('id');
        $product = Product::findOrFail($productId);
        $user = Auth::user();
        $cartItems = [];

        if ($user) {
            $cartItems = CartItem::where('user_id', $user->id)
                ->where('product_id', $productId)
                ->get();
        }

        $cart = Session::get('cart', []);
        $quantityInCart = isset($cart[$productId]['quantity']) ? $cart[$productId]['quantity'] : 0;

        return view('detail', [
            'product' => $product,
            'cartItems' => $cartItems,
            'quantityInCart' => $quantityInCart
        ]);
    }

    public function addToSession(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');
    
        $cart = Session::get('cart', []);
    
        if ($quantity == 0) {
            unset($cart[$productId]);
        } else {
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] = $quantity;
            } else {
                $product = Product::findOrFail($productId);
                $cart[$productId] = [
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'product' => $product,
                ];
            }
        }
    
        Session::put('cart', $cart);
    
        return redirect()->route('detail', ['id' => $productId])->with('success', 'Zmena v košíku bola úspešná.');
    }
    

    public function editCartAmount(Request $request)
    {
        $productId = $request->input('product_id');
        $userId = $request->input('user_id');
        $quantity = $request->input('quantity');

        $existingCartItem = CartItem::where('product_id', $productId)
            ->where('user_id', $userId)
            ->first();

        if ($quantity == 0 && $existingCartItem) {
            $existingCartItem->delete();
        } elseif ($existingCartItem) {
            $existingCartItem->quantity = $quantity;
            $existingCartItem->save();
        } elseif ($quantity > 0) {
            CartItem::create([
                'product_id' => $productId,
                'user_id' => $userId,
                'quantity' => $quantity,
            ]);
        }
        return redirect()->route('detail', ['id' => $productId])->with('success', 'Zmena v košíku bola úspešná.');
    }

    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $images = $product->images;
        return view('detail_edit', compact('product', 'images'));
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
    
        foreach ($product->images as $image) {
            $imagePath = public_path('images/' . $image->name);
            if (file_exists($imagePath)) {
                unlink($imagePath); 
            }
        }
        $product->images()->delete();

        $product->delete();
    
        return redirect()->route('products')->with('success', 'Produkt bol úspešne vymazaný.');
    }


    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $product->name = $request->input('nazov');
        $product->price = $request->input('cena');
        $product->stock = $request->input('pocet');
        $product->description = $request->input('informacie');

        $product->save();

        $images = $request->file('obrazky');

        if ($images) {
            foreach($images as $image) {
                $imageName = $image->getClientOriginalName();
                $extension = $image->getClientOriginalExtension();
                $publicImagesFolder = public_path('images');

                $counter = 1;
                $imageNameNew = $imageName;
                while (file_exists($publicImagesFolder . '/' . $imageNameNew)) {
                    $imageNameNew = pathinfo($imageName, PATHINFO_FILENAME) . "($counter).$extension";
                    $counter++;
                }
            
                $image->move($publicImagesFolder, $imageNameNew);

                $newImage = new Image();
                $newImage->name = $imageNameNew;
                $newImage->product_id = $product->id;
                $newImage->url = 'http://localhost:8000/images/' . $imageName;
                $newImage->save();
            }
        }
        return redirect()->route('detail', ['id' => $id],)->with('success', 'Produkt bol úspešne upravený.');
    }

    public function removeImage($productId, $imageId)
    {
        $product = Product::findOrFail($productId);
        $image = Image::findOrFail($imageId);

        $imagePath = public_path('images/' . $image->name);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        $image->delete();

        return back()->with('success', 'Obrázok bol úspešne odstránený.');
    }

    public function shoppingCart()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $cartItems = CartItem::with('product')->where('user_id', $user->id)->get();
        } else {
            $cart = Session::get('cart', []);
            $productIds = array_keys($cart);
            $cartItems = Product::whereIn('id', $productIds)
                ->get()
                ->map(function ($product) use ($cart) {
                    $productId = $product->id;
                    $quantity = $cart[$productId]['quantity'];
                    return (object) [
                        'id' => $productId,
                        'product' => $product,
                        'quantity' => $quantity,
                    ];
                });
        }
    
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
    
        return view('shopping_cart', compact('cartItems', 'totalPrice'));
    }
    
    public function updateCartItems(Request $request, $id)
    {
        if (Auth::check()) {
            $cartItem = CartItem::findOrFail($id);
            $quantity = $request->input('quantity');
        
            if ($quantity == 0) {
                $cartItem->delete();
            } else {
                $cartItem->update($request->all());
            }
        } else {
            $quantity = $request->input('quantity');
            $cart = Session::get('cart', []);
            if ($quantity != 0) {
                if (isset($cart[$id])) {
                    $cart[$id]['quantity'] = $quantity;
                    Session::put('cart', $cart);
                }
            } else {
                if (isset($cart[$id])) {
                    unset($cart[$id]);
                    Session::put('cart', $cart);
                }
            }
        }
        return redirect()->route('shopping_cart')->with('success', 'Zmena v košíku bola úspešná.');
    }


    public function removeCartItem($id)
    {
        if (Auth::check()) {
            $cartItem = CartItem::findOrFail($id);
            $cartItem->delete();
        }
        else{
            $cart = Session::get('cart', []);
            if (isset($cart[$id])) {
                unset($cart[$id]);
                Session::put('cart', $cart);
            }
        }
        return redirect()->route('shopping_cart')->with('success', 'Produkt bol úspešne odstránený');
    }

    public function register()
    {
        return view('register');
    }

}
