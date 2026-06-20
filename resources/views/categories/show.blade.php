@extends('layouts.dashboard')

@section('title', 'Détails de la catégorie')

@section('content')
<div class="mx-auto max-w-7xl">
    <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between mb-6">
        <div class="min-w-0">
            <div class="flex items-center gap-3">
                <div class="grid h-10 w-10 place-items-center rounded-xl bg-indigo-600 text-white shadow-sm">
                    <i class="bi bi-tags text-lg"></i>
                </div>
                <div class="min-w-0">
                    <h1 class="text-xl md:text-2xl font-semibold tracking-tight text-slate-900 truncate mb-0">
                        {{ $category->name }}
                    </h1>
                    <div class="mt-1 flex flex-wrap items-center gap-x-3 gap-y-2 text-sm text-slate-500">
                        <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-semibold ring-1 ring-inset {{ $category->is_active ? 'bg-emerald-50 text-emerald-700 ring-emerald-200' : 'bg-slate-50 text-slate-700 ring-slate-200' }}">
                            {{ $category->is_active ? 'Actif' : 'Inactif' }}
                        </span>
                        <span class="hidden sm:inline">•</span>
                        <span>Slug: <span class="font-medium text-slate-700">{{ $category->slug }}</span></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap gap-2">
            <a href="{{ route('categories.index') }}"
               class="inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm ring-1 ring-inset ring-slate-200 hover:bg-slate-50">
                <i class="bi bi-arrow-left"></i>
                Retour
            </a>
            <a href="{{ route('categories.edit', $category) }}"
               class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">
                <i class="bi bi-pencil-square"></i>
                Modifier
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <div class="lg:col-span-8 space-y-6">
            <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-200">
                    <p class="text-sm font-semibold text-slate-900 mb-0">Informations générales</p>
                </div>
                <div class="p-5">
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="rounded-xl bg-slate-50 ring-1 ring-inset ring-slate-200 p-4">
                            <dt class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Boutique</dt>
                            <dd class="mt-1 text-sm font-semibold text-slate-900">{{ $category->shop->name ?? 'N/A' }}</dd>
                        </div>
                        <div class="rounded-xl bg-slate-50 ring-1 ring-inset ring-slate-200 p-4">
                            <dt class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Parent</dt>
                            <dd class="mt-1 text-sm font-semibold text-slate-900">{{ $category->parent->name ?? 'Aucun (catégorie racine)' }}</dd>
                        </div>
                        <div class="rounded-xl bg-slate-50 ring-1 ring-inset ring-slate-200 p-4">
                            <dt class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Ordre</dt>
                            <dd class="mt-1 text-sm font-semibold text-slate-900">{{ $category->order }}</dd>
                        </div>
                        <div class="rounded-xl bg-slate-50 ring-1 ring-inset ring-slate-200 p-4">
                            <dt class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Dernière modification</dt>
                            <dd class="mt-1 text-sm font-semibold text-slate-900">{{ $category->updated_at->format('d/m/Y H:i') }}</dd>
                        </div>
                    </dl>

                    @if($category->description)
                        <div class="mt-5 rounded-xl bg-white ring-1 ring-inset ring-slate-200 p-4">
                            <div class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Description</div>
                            <div class="mt-2 text-sm text-slate-700 leading-relaxed">{{ $category->description }}</div>
                        </div>
                    @endif

                    <div class="mt-5 text-xs text-slate-500">
                        Créée le {{ $category->created_at->format('d/m/Y H:i') }}
                    </div>
                </div>
            </div>

            <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-200">
                    <p class="text-sm font-semibold text-slate-900 mb-0">Hiérarchie</p>
                </div>
                <div class="p-5">
                    <div class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Arborescence</div>
                    <ol class="mt-2 flex flex-wrap items-center gap-2 text-sm">
                        @foreach($category->breadcrumb() as $breadcrumb)
                            <li class="flex items-center gap-2">
                                @if($breadcrumb->id == $category->id)
                                    <span class="font-semibold text-slate-900">{{ $breadcrumb->name }}</span>
                                @else
                                    <a class="text-indigo-700 hover:text-indigo-800 font-semibold" href="{{ route('categories.show', $breadcrumb) }}">
                                        {{ $breadcrumb->name }}
                                    </a>
                                @endif
                                @if(!$loop->last)
                                    <span class="text-slate-300">/</span>
                                @endif
                            </li>
                        @endforeach
                    </ol>

                    <div class="mt-6">
                        <div class="flex items-center justify-between">
                            <div class="text-xs font-semibold text-slate-500 uppercase tracking-wide">
                                Sous-catégories
                            </div>
                            <span class="inline-flex items-center rounded-full bg-slate-50 px-2 py-1 text-xs font-semibold text-slate-700 ring-1 ring-inset ring-slate-200">
                                {{ $category->children->count() }}
                            </span>
                        </div>

                        @if($category->hasChildren())
                            <ul class="mt-3 divide-y divide-slate-200 rounded-xl ring-1 ring-inset ring-slate-200 overflow-hidden">
                                @foreach($category->children as $child)
                                    <li class="flex items-center justify-between gap-3 bg-white px-4 py-3 hover:bg-slate-50/60">
                                        <div class="flex items-center gap-3 min-w-0">
                                            @if($child->icon)
                                                <img src="{{ Storage::url($child->icon) }}" alt="{{ $child->name }}" class="h-9 w-9 rounded-lg object-contain bg-white ring-1 ring-inset ring-slate-200">
                                            @else
                                                <div class="grid h-9 w-9 place-items-center rounded-lg bg-slate-100 text-slate-600 ring-1 ring-inset ring-slate-200">
                                                    <i class="bi bi-tag"></i>
                                                </div>
                                            @endif
                                            <div class="min-w-0">
                                                <div class="text-sm font-semibold text-slate-900 truncate">{{ $child->name }}</div>
                                                <div class="text-xs text-slate-500 truncate">{{ $child->slug }}</div>
                                            </div>
                                        </div>
                                        <a href="{{ route('categories.show', $child) }}"
                                           class="inline-flex items-center gap-2 rounded-xl bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm ring-1 ring-inset ring-slate-200 hover:bg-slate-50">
                                            <i class="bi bi-eye"></i>
                                            Voir
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="mt-3 rounded-xl bg-slate-50 ring-1 ring-inset ring-slate-200 p-4 text-sm text-slate-600">
                                Cette catégorie n'a pas de sous-catégories.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <aside class="lg:col-span-4 space-y-6">
            <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-200">
                    <p class="text-sm font-semibold text-slate-900 mb-0">Médias</p>
                </div>
                <div class="p-5 space-y-5">
                    <div>
                        <div class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">Icône</div>
                        @if($category->icon)
                            <img src="{{ Storage::url($category->icon) }}" alt="{{ $category->name }}" class="h-20 w-20 rounded-2xl object-contain bg-white ring-1 ring-inset ring-slate-200">
                        @else
                            <div class="rounded-xl bg-slate-50 ring-1 ring-inset ring-slate-200 p-4 text-sm text-slate-600">
                                Aucune icône
                            </div>
                        @endif
                    </div>

                    <div>
                        <div class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">Image</div>
                        @if($category->image)
                            <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" class="w-full rounded-2xl object-cover ring-1 ring-inset ring-slate-200">
                        @else
                            <div class="rounded-xl bg-slate-50 ring-1 ring-inset ring-slate-200 p-4 text-sm text-slate-600">
                                Aucune image
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-200">
                    <p class="text-sm font-semibold text-slate-900 mb-0">Statistiques</p>
                </div>
                <div class="p-5 space-y-3 text-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-600">Produits dans cette catégorie</span>
                        @if($category->products)
                            <span class="inline-flex items-center rounded-full bg-indigo-50 px-2 py-1 text-xs font-semibold text-indigo-700 ring-1 ring-inset ring-indigo-200">
                                {{ $category->products->count() }}
                            </span>
                        @else
                            <span class="text-slate-400">—</span>
                        @endif
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-600">Sous-catégories directes</span>
                        <span class="inline-flex items-center rounded-full bg-slate-50 px-2 py-1 text-xs font-semibold text-slate-700 ring-1 ring-inset ring-slate-200">
                            {{ $category->children->count() }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-600">Niveau dans l'arborescence</span>
                        <span class="inline-flex items-center rounded-full bg-slate-50 px-2 py-1 text-xs font-semibold text-slate-700 ring-1 ring-inset ring-slate-200">
                            {{ $category->breadcrumb()->count() }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-200">
                    <p class="text-sm font-semibold text-slate-900 mb-0">Actions rapides</p>
                </div>
                <div class="p-5 grid grid-cols-1 gap-2">
                    <a href="{{ route('categories.create') }}?parent_id={{ $category->id }}"
                       class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">
                        <i class="bi bi-plus-circle"></i>
                        Ajouter une sous-catégorie
                    </a>
                    <a href="{{ route('categories.edit', $category) }}"
                       class="inline-flex items-center justify-center gap-2 rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm ring-1 ring-inset ring-slate-200 hover:bg-slate-50">
                        <i class="bi bi-pencil-square"></i>
                        Modifier
                    </a>
                    <button type="button"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-rose-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-rose-700"
                            onclick="confirmDelete({{ $category->id }}, '{{ $category->name }}')">
                        <i class="bi bi-trash"></i>
                        Supprimer
                    </button>
                </div>
            </div>
        </aside>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer la catégorie "<strong id="categoryName"></strong>" ?</p>
                <p class="text-danger"><small>Cette action est irréversible.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function confirmDelete(categoryId, categoryName) {
    document.getElementById('categoryName').textContent = categoryName;
    document.getElementById('deleteForm').action = `/categories/${categoryId}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endsection