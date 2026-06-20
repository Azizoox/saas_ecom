<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $shop = $user->shops()->first();

        // make sure we have a shop before querying
        if (!$shop) {
            // no shops for this user, show empty list
            $categories = collect();
            $rootCategories = collect();
        } else {
            $categories = Category::with('children', 'parent')
                ->where('shop_id', $shop->id)
                ->orderBy('order')
                ->get();

            $rootCategories = Category::where('shop_id', $shop->id)
                ->whereNull('parent_id')
                ->orderBy('order')
                ->get();
        }

        // all shops belonging to user for the create form (modal/select)
        $shops = $user->shops;

        return view('categories.index', compact('categories', 'rootCategories', 'shops'));
    }

    public function create()
    {
        $shops = Auth::user()->shops;
        // only categories belonging to one of the user's shops
        $categories = Category::whereIn('shop_id', $shops->pluck('id'))
            ->orderBy('name')
            ->get();
        
        return view('categories.create', compact('shops', 'categories'));
    }

    public function store(Request $request)
{
    try {
        // Validation des données
        $validated = $request->validate([
            'shop_id' => 'required|exists:shops,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'parent_id' => 'nullable|exists:categories,id',
            'icon' => 'nullable|file|mimes:jpg,jpeg,png,svg,gif|max:2048',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,svg,gif,webp|max:5120',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ], [
            'shop_id.required' => 'La boutique est obligatoire.',
            'shop_id.exists' => 'La boutique sélectionnée n\'existe pas.',
            'name.required' => 'Le nom de la catégorie est obligatoire.',
            'name.max' => 'Le nom ne peut pas dépasser 255 caractères.',
            'parent_id.exists' => 'La catégorie parente sélectionnée n\'existe pas.',
            'icon.mimes' => 'L\'icône doit être un fichier de type : jpg, jpeg, png, svg, gif.',
            'icon.max' => 'L\'icône ne peut pas dépasser 2 Mo.',
            'image.mimes' => 'L\'image doit être un fichier de type : jpg, jpeg, png, svg, gif, webp.',
            'image.max' => 'L\'image ne peut pas dépasser 5 Mo.',
            'order.min' => 'L\'ordre doit être un nombre positif.',
        ]);

        // Déterminer le shop_id
        $shopId = $request->filled('shop_id') ? $request->shop_id : null;
        
        if (!$shopId) {
            $shop = Auth::user()->shops()->first();
            if (!$shop) {
                return redirect()->back()
                    ->withErrors(['shop_id' => 'Vous devez avoir au moins une boutique pour créer une catégorie.'])
                    ->withInput();
            }
            $shopId = $shop->id;
        }

        // Vérifier que l'utilisateur a accès à cette boutique
        if (!Auth::user()->shops()->where('id', $shopId)->exists()) {
            return redirect()->back()
                ->withErrors(['shop_id' => 'Vous n\'avez pas accès à cette boutique.'])
                ->withInput();
        }

        // Générer le slug unique
        $slug = Str::slug($validated['name']);
        $originalSlug = $slug;
        $counter = 1;
        
        // Vérifier l'unicité du slug
        while (Category::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Préparer les données
        $data = [
            'shop_id' => $shopId,
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'parent_id' => $validated['parent_id'] ?? null,
            'order' => $validated['order'] ?? 0,
            'is_active' => $request->boolean('is_active', true),


        ];

        // Validation supplémentaire : vérifier que la catégorie parente appartient à la même boutique
        if ($data['parent_id']) {
            $parentCategory = Category::find($data['parent_id']);
            if ($parentCategory && $parentCategory->shop_id != $shopId) {
                return redirect()->back()
                    ->withErrors(['parent_id' => 'La catégorie parente doit appartenir à la même boutique.'])
                    ->withInput();
            }
        }

        // Gestion de l'upload de l'icône
        if ($request->hasFile('icon')) {
            $iconFile = $request->file('icon');
            $iconName = time() . '_icon_' . Str::slug($validated['name']) . '.' . $iconFile->getClientOriginalExtension();
            $data['icon'] = $iconFile->storeAs('categories/icons', $iconName, 'public');
        }

        // Gestion de l'upload de l'image
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $imageName = time() . '_image_' . Str::slug($validated['name']) . '.' . $imageFile->getClientOriginalExtension();
            $data['image'] = $imageFile->storeAs('categories/images', $imageName, 'public');
        }

        // Créer la catégorie
        $category = Category::create($data);

        // Log de l'activité (optionnel)
        // activity()
        //     ->performedOn($category)
        //     ->causedBy(Auth::user())
        //     ->log('Catégorie créée');

        return redirect()
            ->route('categories.index')
            ->with('success', 'Catégorie "' . $category->name . '" créée avec succès!');

    } catch (\Illuminate\Validation\ValidationException $e) {
        // Erreurs de validation
        return redirect()->back()
            ->withErrors($e->validator)
            ->withInput();
            
    } catch (\Exception $e) {
        // Supprimer les fichiers uploadés en cas d'erreur
        if (isset($data['icon']) && Storage::disk('public')->exists($data['icon'])) {
            Storage::disk('public')->delete($data['icon']);
        }
        if (isset($data['image']) && Storage::disk('public')->exists($data['image'])) {
            Storage::disk('public')->delete($data['image']);
        }

        // Log de l'erreur
        \Log::error('Erreur lors de la création de la catégorie: ' . $e->getMessage(), [
            'user_id' => Auth::id(),
            'request_data' => $request->except(['icon', 'image']),
            'trace' => $e->getTraceAsString()
        ]);

        return redirect()->back()
            ->withErrors(['error' => 'Une erreur est survenue lors de la création de la catégorie. Veuillez réessayer.'])
            ->withInput();
    }
}

    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        $shops = Auth::user()->shops;
        // only categories that belong to one of the user's shops (excluding current)
        $categories = Category::whereIn('shop_id', $shops->pluck('id'))
            ->where('id', '!=', $category->id)
            ->orderBy('name')
            ->get();
        
        return view('categories.edit', compact('category', 'shops', 'categories'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'shop_id' => 'required|exists:shops,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'parent_id' => 'nullable|exists:categories,id',
            'icon' => 'nullable|file|mimes:jpg,jpeg,png,svg,gif|max:2048',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,svg,gif,webp|max:5120',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);
        
        // Ensure the category belongs to one of the authenticated user's shops
        $userShops = Auth::user()->shops->pluck('id')->toArray();
        if (!in_array($category->shop_id, $userShops)) {
            abort(403, 'Vous n\'avez pas le droit de modifier cette catégorie.');
        }
        
        // Prepare data from validated input only
        $data = [
            'shop_id' => $validated['shop_id'],
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'parent_id' => $validated['parent_id'] ?? null,
            'order' => $validated['order'] ?? 0,
            'is_active' => $request->boolean('is_active', false),
        ];
        
        // Additional check: if parent_id provided ensure it belongs to same shop
        if (!empty($data['parent_id'])) {
            $parent = Category::find($data['parent_id']);
            if ($parent && $parent->shop_id !== $category->shop_id) {
                return redirect()->back()
                    ->withErrors(['parent_id' => 'La catégorie parente doit appartenir à la même boutique.'])
                    ->withInput();
            }
        }
        
        // Handle file uploads
        if ($request->hasFile('icon')) {
            // Delete old file if exists
            if ($category->icon) {
                Storage::disk('public')->delete($category->icon);
            }
            $iconFile = $request->file('icon');
            $iconName = time() . '_icon_' . Str::slug($validated['name']) . '.' . $iconFile->getClientOriginalExtension();
            $data['icon'] = $iconFile->storeAs('categories/icons', $iconName, 'public');
        }
        
        if ($request->hasFile('image')) {
            // Delete old file if exists
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $imageFile = $request->file('image');
            $imageName = time() . '_image_' . Str::slug($validated['name']) . '.' . $imageFile->getClientOriginalExtension();
            $data['image'] = $imageFile->storeAs('categories/images', $imageName, 'public');
        }
        
        // Update category and ensure updated_at timestamp is refreshed
        $category->update($data);
        $category->touch();
        
        return redirect()->route('categories.index')->with('success', 'Catégorie mise à jour avec succès!');
    }

    public function destroy(Category $category)
    {
        // Ensure the category belongs to one of the authenticated user's shops
        $userShops = Auth::user()->shops->pluck('id')->toArray();
        if (!in_array($category->shop_id, $userShops)) {
            abort(403, 'Vous n\'avez pas le droit de supprimer cette catégorie.');
        }
        
        // Delete associated files
        if ($category->icon) {
            Storage::disk('public')->delete($category->icon);
        }
        
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }
        
        $category->delete();
        
        return redirect()->route('categories.index')->with('success', 'Catégorie supprimée avec succès!');
    }

    public function getSubcategories($parentId)
    {
        $subcategories = Category::where('parent_id', $parentId)->get();
        return response()->json($subcategories);
    }
}
