<?php

namespace App\Http\Controllers;

use App\Models\Widget;
use Illuminate\Http\Request;

class WidgetController extends Controller
{
    public function index()
    {
        $headerWidgets = Widget::aktif()->byPosition('header')->orderBy('order')->get();
        $sidebarLeftWidgets = Widget::aktif()->byPosition('sidebar-left')->orderBy('order')->get();
        $sidebarRightWidgets = Widget::aktif()->byPosition('sidebar-right')->orderBy('order')->get();
        $footerWidgets = Widget::aktif()->byPosition('footer')->orderBy('order')->get();
        $homeWidgets = Widget::aktif()->byPosition('home')->orderBy('order')->get();

        return view_theme('admin', 'widgets.index', compact(
            'headerWidgets',
            'sidebarLeftWidgets', 
            'sidebarRightWidgets',
            'footerWidgets',
            'homeWidgets'
        ));
    }

    public function create()
    {
        return view_theme('admin', 'widgets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:plugin,text,html',
            'position' => 'required|in:header,sidebar-left,sidebar-right,footer,home',
            'status' => 'required|in:aktif,nonaktif',
            'content' => 'nullable|string',
            'plugin_name' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'settings' => 'nullable|array'
        ]);

        Widget::create($request->all());

        return redirect()->route('panel.widgets.index')->with('success', 'Widget berhasil ditambahkan.');
    }

    public function show(Widget $widget)
    {
        return view_theme('admin', 'widgets.show', compact('widget'));
    }

    public function edit(Widget $widget)
    {
        return view_theme('admin', 'widgets.edit', compact('widget'));
    }

    public function update(Request $request, Widget $widget)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:plugin,text,html',
            'position' => 'required|in:header,sidebar-left,sidebar-right,footer,home',
            'status' => 'required|in:aktif,nonaktif',
            'content' => 'nullable|string',
            'plugin_name' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'settings' => 'nullable|array'
        ]);

        $widget->update($request->all());

        return redirect()->route('panel.widgets.index')->with('success', 'Widget berhasil diperbarui.');
    }

    public function destroy(Widget $widget)
    {
        $widget->delete();

        return redirect()->route('panel.widgets.index')->with('success', 'Widget berhasil dihapus.');
    }

    public function updateOrder(Request $request)
    {
        // Validasi untuk struktur data baru yang mengirimkan semua widget sekaligus
        if ($request->has('all_widgets')) {
            $request->validate([
                'all_widgets' => 'required|array',
                'all_widgets.*.id' => 'required|integer|exists:widgets,id',
                'all_widgets.*.position' => 'required|in:header,sidebar-left,sidebar-right,footer,home',
                'all_widgets.*.order' => 'required|integer'
            ]);

            $allWidgets = $request->all_widgets;

            foreach ($allWidgets as $widgetData) {
                Widget::where('id', $widgetData['id'])
                       ->update([
                           'position' => $widgetData['position'],
                           'order' => $widgetData['order']
                       ]);
            }
        } else {
            // Validasi untuk struktur data baru yang mengirimkan posisi dan widget_ids
            $request->validate([
                'position' => 'required|in:header,sidebar-left,sidebar-right,footer,home',
                'widget_ids' => 'required|array',
                'widget_ids.*.id' => 'required|integer|exists:widgets,id',
                'widget_ids.*.order' => 'required|integer'
            ]);

            $position = $request->position;
            $widgetOrders = $request->widget_ids;

            foreach ($widgetOrders as $widgetData) {
                Widget::where('id', $widgetData['id'])
                       ->where('position', $position)
                       ->update(['order' => $widgetData['order']]);
            }
        }

        return response()->json(['success' => true]);
    }

    public function updatePosition(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:widgets,id',
            'position' => 'required|in:header,sidebar-left,sidebar-right,footer,home'
        ]);

        $widget = Widget::findOrFail($request->id);
        $widget->position = $request->position;
        $widget->save();

        return response()->json(['success' => true]);
    }
}