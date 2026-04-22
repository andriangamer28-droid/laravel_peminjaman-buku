<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    public function index()
    {
        // Mengambil semua data
        $tools = Tool::all();
        // Mengirim variabel $tools ke view
        return view('tools.index', compact('tools'));
    }

    public function create()
    {
        return view('tools.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_alat' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'jumlah'    => 'required|integer|min:0',
        ]);

        Tool::create($validated);

        return redirect()->route('tools.index')->with('success', 'Data berhasil ditambah!');
    }
}