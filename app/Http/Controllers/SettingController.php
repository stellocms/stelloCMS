<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all();
        return view('theme.admin.adminlte.settings.index', compact('settings'));
    }

    public function create()
    {
        return view('theme.admin.adminlte.settings.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pengaturan' => 'required|string|max:255|unique:settings,pengaturan',
            'nilai' => 'required|string',
            'status' => 'required|in:aktif,nonaktif'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Setting::create($request->all());

        return redirect()->route('setting.index')->with('success', 'Pengaturan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $setting = Setting::findOrFail($id);
        return view('theme.admin.adminlte.settings.edit', compact('setting'));
    }

    public function update(Request $request, $id)
    {
        $setting = Setting::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'pengaturan' => 'required|string|max:255|unique:settings,pengaturan,' . $id,
            'nilai' => 'required|string',
            'status' => 'required|in:aktif,nonaktif'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $setting->update($request->all());

        return redirect()->route('setting.index')->with('success', 'Pengaturan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $setting = Setting::findOrFail($id);
        $setting->delete();

        return redirect()->route('setting.index')->with('success', 'Pengaturan berhasil dihapus.');
    }
}