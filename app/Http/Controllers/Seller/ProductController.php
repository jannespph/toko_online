<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    // ─── INDEX ─────────────────────────────────────────────────────
    public function index(): Response
    {
        // Hanya produk milik seller yang sedang login
        $products = Product::where('user_id', auth()->id())
            ->with('categories')
            ->latest()
            ->paginate(10);

        return Inertia::render('Seller/Products/Index', compact('products'));
    }

    // ─── CREATE ────────────────────────────────────────────────────
    public function create(): Response
    {
        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return Inertia::render('Seller/Products/Create', compact('categories'));
    }

    // ─── STORE ─────────────────────────────────────────────────────
    public function store(Request $request, ImageService $imageService): RedirectResponse
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:200',
            'description'    => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'stock'          => 'required|integer|min:0',
            'status'         => 'required|in:active,inactive,draft',
            'image'          => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'category_ids'   => 'array',
            'category_ids.*' => 'exists:categories,id',
        ]);

        $validated['user_id'] = auth()->id();

        $validated['image'] = $imageService->upload(
            $request->file('image')
        );

        $product = Product::create($validated);

        $product->categories()->sync(
            $request->input('category_ids', [])
        );

        return redirect()
            ->route('seller.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    // ─── EDIT ──────────────────────────────────────────────────────
    public function edit(Product $product): Response
    {
        // Proteksi kepemilikan
        abort_if(
            $product->user_id !== auth()->id(),
            403,
            'Anda tidak memiliki izin mengedit produk ini.'
        );

        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $product->load('categories');

        return Inertia::render(
            'Seller/Products/Edit',
            compact('product', 'categories')
        );
    }

    // ─── UPDATE ────────────────────────────────────────────────────
    public function update(
        Request $request,
        Product $product,
        ImageService $imageService
    ): RedirectResponse {
        abort_if($product->user_id !== auth()->id(), 403);

        $validated = $request->validate([
            'name'           => 'required|string|max:200',
            'description'    => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'stock'          => 'required|integer|min:0',
            'status'         => 'required|in:active,inactive,draft',
            'image'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'category_ids'   => 'array',
            'category_ids.*' => 'exists:categories,id',
        ]);

        // Ganti foto jika upload baru
        if ($request->hasFile('image')) {
            $imageService->delete($product->image);

            $validated['image'] = $imageService->upload(
                $request->file('image')
            );
        }

        $product->update($validated);

        $product->categories()->sync(
            $request->input('category_ids', [])
        );

        return redirect()
            ->route('seller.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    // ─── DESTROY ───────────────────────────────────────────────────
    public function destroy(Product $product): RedirectResponse
    {
        abort_if($product->user_id !== auth()->id(), 403);

        // Soft delete
        $product->delete();

        return redirect()
            ->route('seller.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}