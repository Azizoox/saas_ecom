<?php

namespace App\Http\Controllers;

use App\Models\ShopComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ShopComponentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $shops = $user->shops;

        if ($shops->isEmpty()) {
            abort(403, 'Aucune boutique.');
        }

        $shopId = request()->integer('shop_id');
        $shop = $shopId
            ? $shops->firstWhere('id', $shopId)
            : $user->shop;

        if (!$shop) {
            $shop = $user->shop;
        }

        $components = $shop->components;
        return view('dashboard.builder.index', compact('shop', 'shops', 'components'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $shops = $user->shops;

        $shopId = (int) $request->input('shop_id');
        $shop = $shopId ? $shops->firstWhere('id', $shopId) : $user->shop;
        if (!$shop) {
            abort(403);
        }

        $request->validate([
            'type' => 'required|string|in:categories,slider,banner,reviews,premium_categories',
        ]);

        $content = [];
        
        // Default content based on type
        switch ($request->type) {
            case 'categories':
                $content = ['title' => 'Nos Catégories', 'categories' => [], 'style' => 'grid'];
                break;
            case 'slider':
                $content = ['slides' => [], 'options' => ['autoplay' => true, 'pagination' => true, 'arrows' => true]];
                break;
            case 'banner':
                $content = ['text_main' => 'Offre Spéciale', 'text_secondary' => '', 'speed' => 10, 'bg_color' => '#000000', 'link' => ''];
                break;
            case 'reviews':
                $content = ['title' => 'Avis Clients', 'reviews' => [], 'style' => 'slider'];
                break;
            case 'premium_categories':
                $content = ['categories' => [], 'badge_text' => 'Premium'];
                break;
        }

        $shop->components()->create([
            'type' => $request->type,
            'content' => $content,
            'order' => ((int) $shop->components()->max('order')) + 1,
        ]);

        return back()->with('success', 'Composant ajouté avec succès.');
    }

    public function update(Request $request, ShopComponent $component)
    {
        $this->authorizeOwner($component);

        $content = $request->input('content', []);

        // Normaliser les booléens (checkboxes non cochées => absentes => false)
        if ($component->type === 'slider') {
            $content['options'] = array_merge($component->content['options'] ?? [], [
                'autoplay' => $request->boolean('content.options.autoplay'),
                'pagination' => $request->boolean('content.options.pagination'),
                'arrows' => $request->boolean('content.options.arrows'),
            ]);
        }

        // Handle file uploads (slider images)
        if ($component->type === 'slider') {
            $slides = $component->content['slides'] ?? [];
            $uploadedSlides = $request->file('content.slides', []);

            foreach ($uploadedSlides as $index => $slideData) {
                if (isset($slideData['image']) && $slideData['image']) {
                    if (isset($slides[$index]['image'])) {
                        Storage::disk('public')->delete($slides[$index]['image']);
                    }
                    $slides[$index]['image'] = $slideData['image']->store('components/slides', 'public');
                }
            }

            // Merge non-file slide fields (title/link/description) onto existing slides
            $slideInputs = $content['slides'] ?? [];
            foreach ($slideInputs as $index => $data) {
                $slides[$index] = array_merge($slides[$index] ?? [], $data);
            }
            $content['slides'] = $slides;
        }

        $newContent = array_replace_recursive($component->content ?? [], $content);

        $component->update([
            'content' => $newContent,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', 'Composant mis à jour.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'exists:shop_components,id',
        ]);

        $ownedShopIds = Auth::user()->shops->pluck('id')->all();

        foreach ($request->order as $index => $id) {
            $component = ShopComponent::find($id);
            if ($component && in_array($component->shop_id, $ownedShopIds, true)) {
                $component->update(['order' => $index]);
            }
        }

        return response()->json(['success' => true]);
    }

    public function destroy(ShopComponent $component)
    {
        $this->authorizeOwner($component);
        
        // Delete associated files
        if ($component->type === 'slider' && isset($component->content['slides'])) {
            foreach ($component->content['slides'] as $slide) {
                if (isset($slide['image'])) {
                    Storage::disk('public')->delete($slide['image']);
                }
            }
        }

        $component->delete();
        return back()->with('success', 'Composant supprimé.');
    }

    private function authorizeOwner(ShopComponent $component)
    {
        if (!Auth::user()->shops->contains('id', $component->shop_id)) {
            abort(403);
        }
    }
}
