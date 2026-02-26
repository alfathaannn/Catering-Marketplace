<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Menu;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    /**
     * Display a listing of the menus.
     */
    public function index(Request $request)
    {
        $merchant = $request->user()->merchant;

        $query = $merchant->menus();

        // Handle Tabs (Active vs Archived)
        $tab = $request->query('tab', 'active');
        if ($tab === 'archived') {
            $query->onlyTrashed();
        }

        // Handle Search
        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Handle Sorting
        $sortBy = $request->query('sort', 'created_at');
        $direction = $request->query('direction', 'desc');
        $validSorts = ['name', 'price', 'created_at'];

        if (in_array($sortBy, $validSorts)) {
            $query->orderBy($sortBy, $direction == 'asc' ? 'asc' : 'desc');
        } else {
            $query->latest();
        }

        $menus = $query->paginate(10)->withQueryString();

        return view('merchant.menus.index', compact('menus', 'tab'));
    }

    /**
     * Store a newly created menu in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048'
        ]);

        $merchant = $request->user()->merchant;

        $data = $request->only('name', 'price', 'description');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('menus', 'public');
            $data['image'] = $path;
        }

        $merchant->menus()->create($data);

        return back()->with('success', 'Menu created successfully!');
    }

    /**
     * Update the specified menu in storage.
     */
    public function update(Request $request, $id)
    {
        $merchant = $request->user()->merchant;
        $menu = $merchant->menus()->withTrashed()->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048'
        ]);

        $data = $request->only('name', 'price', 'description');

        if ($request->hasFile('image')) {
            // Delete old image
            if ($menu->image) {
                Storage::disk('public')->delete($menu->image);
            }
            $path = $request->file('image')->store('menus', 'public');
            $data['image'] = $path;
        }

        $menu->update($data);

        return back()->with('success', 'Menu updated successfully!');
    }

    /**
     * Archive (Soft Delete) the specified menu.
     */
    public function destroy(Request $request, $id)
    {
        $merchant = $request->user()->merchant;
        $menu = $merchant->menus()->findOrFail($id);

        $menu->delete();

        return back()->with('success', 'Menu archived successfully.');
    }

    /**
     * Restore an archived menu.
     */
    public function restore(Request $request, $id)
    {
        $merchant = $request->user()->merchant;
        $menu = $merchant->menus()->onlyTrashed()->findOrFail($id);

        $menu->restore();

        return back()->with('success', 'Menu restored successfully.');
    }

    /**
     * Permanently delete the specified menu.
     */
    public function forceDelete(Request $request, $id)
    {
        $merchant = $request->user()->merchant;
        $menu = $merchant->menus()->onlyTrashed()->findOrFail($id);

        if ($menu->image) {
            Storage::disk('public')->delete($menu->image);
        }

        $menu->forceDelete();

        return back()->with('success', 'Menu permanently deleted.');
    }
}
