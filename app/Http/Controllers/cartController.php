<?php
namespace App\Http\Controllers;

use App\Models\cart;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class cartController extends Controller
{
    public function addToCart($menuId)
    {
        $menu = product::findOrFail($menuId);
        $user = Auth::user();

        // Cek jika menu sudah ada di keranjang
        $cartItem = cart::where('user_id', $user->id)
                        ->where('menu_id', $menuId)
                        ->first();

        if ($cartItem) {
            // Jika sudah ada, update quantity
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            // Jika belum ada, buat item baru
            cart::create([
                'user_id' => $user->id,
                'menu_id' => $menuId,
                'quantity' => 1,
            ]);
        }

        return redirect()->route('menukebablicious');
    }

    public function index()
    {
        $user = Auth::user();
        $cartItems = cart::with('product')->where('user_id', $user->id)->get();

        return view('customerverifed.cart', compact('cartItems'));

    }

    public function updateQuantity(Request $request, $cartId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = Cart::findOrFail($cartId);

        $cartItem->quantity = $request->input('quantity');
        $cartItem->save();

        return response()->json(['success' => true]);
    }

    public function removeFromCart($cartId)
    {
        Cart::destroy($cartId);
        return redirect()->route('keranjang');

    }
}