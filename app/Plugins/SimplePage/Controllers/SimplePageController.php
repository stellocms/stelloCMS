<?php

namespace App\Plugins\SimplePage\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SimplePageController extends Controller
{
    public function index()
    {
        return view_theme('admin', 'simplepage.index');
    }

    public function create()
    {
        return view_theme('admin', 'simplepage.create');
    }

    public function store(Request $request)
    {
        // Logic to store new page
        return redirect()->route('simplepage.index')->with('success', 'Page created successfully');
    }

    public function edit($id)
    {
        return view_theme('admin', 'simplepage.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        // Logic to update page
        return redirect()->route('simplepage.index')->with('success', 'Page updated successfully');
    }

    public function destroy($id)
    {
        // Logic to delete page
        return redirect()->route('simplepage.index')->with('success', 'Page deleted successfully');
    }
}