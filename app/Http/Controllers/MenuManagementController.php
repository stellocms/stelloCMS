<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuManagementController extends Controller
{
    public function index()
    {
        $adminMenus = Menu::where('type', 'admin')->with('parent')->orderBy('order')->get();
        $frontendMenus = Menu::where('type', 'frontend')->with('parent')->orderBy('order')->get();
        
        return view_theme('admin', 'menus.index', compact('adminMenus', 'frontendMenus'));
    }

    /**
     * Update menu order via drag and drop
     */
    public function updateOrder(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'menu_ids' => 'required|array',
            'menu_ids.*' => 'exists:menus,id',
            'type' => 'required|string|in:admin,frontend'
        ]);

        $menuIds = $request->menu_ids;
        $type = $request->type;

        foreach ($menuIds as $index => $menuId) {
            \App\Models\Menu::where('id', $menuId)
                           ->where('type', $type)
                           ->update(['order' => $index]);
        }

        return response()->json(['success' => true, 'message' => 'Urutan menu berhasil diperbarui']);
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
            'type' => 'required|in:admin,frontend',
            'position' => 'required|in:header,sidebar-left,sidebar-right,footer',
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
            'type' => $request->type,
            'position' => $request->position,
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
            'type' => 'required|in:admin,frontend',
            'position' => 'required|in:header,sidebar-left,sidebar-right,footer',
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
            'type' => $request->type,
            'position' => $request->position,
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