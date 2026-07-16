<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    // ─── index(): Daftar pesanan buyer ───────────────────────────

    public function index(Request $request): Response
    {
        $orders = Order::where('user_id', $request->user()->id)

            // eager load items untuk menghitung jumlah item
            ->with('items')

            ->latest()

            ->paginate(10);

        return Inertia::render('Orders/Index', compact('orders'));
    }

    // ─── show(): Detail satu pesanan ─────────────────────────────

    public function show(Request $request, Order $order): Response
    {
        // Pastikan order milik user yang sedang login

        abort_if(
            $order->user_id !== $request->user()->id,
            403,
            'Bukan pesanan Anda.'
        );

        // Load relasi yang dibutuhkan

        $order->load([
            'items.product',
            'buyer',
        ]);

        return Inertia::render('Orders/Show', compact('order'));
    }

    // ─── dashboard(): Halaman dashboard buyer ─────────────────────

    public function dashboard(Request $request): Response
    {
        return Inertia::render('Buyer/Dashboard', [
            'user' => $request->user(),
        ]);
    }
}