<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Shop;
use App\Models\Category;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $shops = $user->shops;
        
        // Récupérer tous les produits des boutiques de l'utilisateur
        $products = Product::whereIn('shop_id', $shops->pluck('id'))
            ->with('shop')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('products.index', [
            'products' => $products,
            'shops' => $shops,
        ]);
    }

    public function create(): View
    {
        $user = Auth::user();
        $shops = $user->shops()->get();
        $categories = Category::whereIn('shop_id', $shops->pluck('id'))->orderBy('name')->get();

        return view('products.create_advanced', [
            'shops' => $shops,
            'categories' => $categories,
        ]);
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $validated = $request->validated();

        // Vérifier que la catégorie appartient bien à la boutique sélectionnée
        if (!empty($validated['category_id'])) {
            $category = Category::find($validated['category_id']);
            if (!$category || $category->shop_id != $validated['shop_id']) {
                return back()
                    ->withInput()
                    ->withErrors(['category_id' => 'La catégorie sélectionnée doit appartenir à la même boutique que le produit.']);
            }
        }

        // Gérer is_active : si la checkbox est cochée, elle est présente, sinon elle est absente
        $validated['is_active'] = $request->has('is_active');

        // Gérer les images multiples
        if ($request->has('images')) {
            $validated['images'] = json_encode($request->images);
        }
        // Gérer l'image principale
        if ($request->hasFile('image')) {
            // Créer le dossier s'il n'existe pas
            if (!file_exists(storage_path('app/public/products'))) {
                mkdir(storage_path('app/public/products'), 0755, true);
            }
            
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        // Gérer les variantes
        if ($request->has('variants')) {
            $validated['variants'] = json_encode($request->variants);
        }

        try {
            $product = Product::create($validated);
            
            return redirect()->route('products.index')
                ->with('success', 'Produit créé avec succès !');
        } catch (\Exception $e) {
            Log::error('Erreur création produit: ' . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()
                ->withInput()
                ->withErrors(['error' => 'Erreur lors de la création du produit. Veuillez vérifier que tous les champs sont correctement remplis.']);
        }
    }

    public function edit(Product $product): View
    {
        $user = Auth::user();
        
        // Vérifier que l'utilisateur possède la boutique du produit
        if (!$user->shops->contains('id', $product->shop_id)) {
            abort(403, 'Accès non autorisé');
        }

        $shops = $user->shops()->get();
        $categories = Category::where('shop_id', $product->shop_id)->get();

        return view('products.edit_advanced', [
            'product' => $product,
            'shops' => $shops,
            'categories' => $categories,
        ]);
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $user = Auth::user();
        
        // Vérifier que l'utilisateur possède la boutique du produit
        if (!$user->shops->contains('id', $product->shop_id)) {
            abort(403, 'Accès non autorisé');
        }

        $validated = $request->validated();

        // Vérifier que la catégorie appartient bien à la boutique sélectionnée
        if (!empty($validated['category_id'])) {
            $category = Category::find($validated['category_id']);
            if (!$category || $category->shop_id != $validated['shop_id']) {
                return back()
                    ->withInput()
                    ->withErrors(['category_id' => 'La catégorie sélectionnée doit appartenir à la même boutique que le produit.']);
            }
        }

        // Gérer is_active : si la checkbox est cochée, elle est présente, sinon elle est absente
        $validated['is_active'] = $request->has('is_active');

        // Gérer les images multiples
        if ($request->has('images')) {
            $validated['images'] = json_encode($request->images);
        }

        // Gérer l'image principale
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        // Gérer les variantes
        if ($request->has('variants')) {
            $validated['variants'] = json_encode($request->variants);
        }

        try {
            $product->update($validated);

            return redirect()->route('products.index')
                ->with('success', 'Produit mis à jour avec succès !');
        } catch (\Exception $e) {
            \Log::error('Erreur mise à jour produit: ' . $e->getMessage(), [
                'product_id' => $product->id,
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()
                ->withInput()
                ->withErrors(['error' => 'Erreur lors de la mise à jour du produit. Veuillez vérifier que tous les champs sont correctement remplis.']);
        }
    }

    public function destroy(Product $product): RedirectResponse
    {
        $user = Auth::user();
        
        // Vérifier que l'utilisateur possède la boutique du produit
        if (!$user->shops->contains('id', $product->shop_id)) {
            abort(403, 'Accès non autorisé');
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produit supprimé avec succès !');
    }
    

// Méthode à ajouter dans votre ShopController


}