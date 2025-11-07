<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuManagementController extends Controller
{
    public function index()
    {
        $menus = Menu::with('parent')->orderBy('order')->get();
        return view_theme('admin', 'menus.index', compact('menus'));
    }

    public function create()
    {
        $parents = Menu::whereNull('parent_id')->get();
        return view_theme('admin', 'menus.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'route' => 'nullable|string|max:255',
            'url' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
            'roles' => 'nullable|array',
            'plugin_name' => 'nullable|string|max:255',
        ]);

        Menu::create([
            'name' => $request->name,
            'title' => $request->title,
            'route' => $request->route,
            'url' => $request->url,
            'icon' => $request->icon,
            'parent_id' => $request->parent_id,
            'order' => $request->order ?? 0,
            'is_active' => $request->is_active ?? false,
            'roles' => $request->roles ?? [],
            'plugin_name' => $request->plugin_name,
        ]);

        return redirect()->route('menus.index')->with('success', 'Menu created successfully');
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        $parents = Menu::whereNull('parent_id')->where('id', '!=', $id)->get();
        return view_theme('admin', 'menus.edit', compact('menu', 'parents'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'route' => 'nullable|string|max:255',
            'url' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
            'roles' => 'nullable|array',
            'plugin_name' => 'nullable|string|max:255',
        ]);

        $menu = Menu::findOrFail($id);
        $menu->update([
            'name' => $request->name,
            'title' => $request->title,
            'route' => $request->route,
            'url' => $request->url,
            'icon' => $request->icon,
            'parent_id' => $request->parent_id,
            'order' => $request->order ?? 0,
            'is_active' => $request->is_active ?? false,
            'roles' => $request->roles ?? [],
            'plugin_name' => $request->plugin_name,
        ]);

        return redirect()->route('menus.index')->with('success', 'Menu updated successfully');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()->route('menus.index')->with('success', 'Menu deleted successfully');
    }
}