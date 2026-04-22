<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $search    = $request->input('search');
        $kategoriId = $request->input('kategori_id');
        $penerbit  = $request->input('penerbit');

        $bukus = Buku::with('kategori')
            ->when($search, function ($q) use ($search) {
                $q->where(function($q) use ($search) {
                    $q->where('judul', 'like', "%{$search}%")
                      ->orWhere('penulis', 'like', "%{$search}%")
                      ->orWhere('isbn', 'like', "%{$search}%")
                      ->orWhereHas('kategori', fn($q) => $q->where('nama', 'like', "%{$search}%"));
                });
            })
            ->when($kategoriId, fn($q) => $q->where('kategori_id', $kategoriId))
            ->when($penerbit, fn($q) => $q->where('penerbit', $penerbit))
            ->latest()->paginate(12)->withQueryString();

        $kategoris = \App\Models\Kategori::orderBy('nama')->get();
        $penerbitList = Buku::select('penerbit')->distinct()->orderBy('penerbit')->pluck('penerbit');

        return view('buku.index', compact('bukus', 'search', 'kategoriId', 'penerbit', 'kategoris', 'penerbitList'));
    }

    public function create()
    {
        abort_unless(auth()->user()->isAdmin(), 403);
        $kategoris = Kategori::all();
        return view('buku.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->isAdmin(), 403);
        $request->validate([
            'judul'        => 'required|string|max:255',
            'penulis'      => 'required|string|max:255',
            'penerbit'     => 'required|string|max:255',
            'tahun_terbit' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'isbn'         => 'required|string|unique:bukus',
            'kategori_id'  => 'required|exists:kategoris,id',
            'stok'         => 'required|integer|min:1',
            'foto'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
        $data = $request->except('foto');
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('buku', 'public');
        }
        Buku::create($data);
        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show(Buku $buku)
    {
        return view('buku.show', compact('buku'));
    }

    public function edit(Buku $buku)
    {
        abort_unless(auth()->user()->isAdmin(), 403);
        $kategoris = Kategori::all();
        return view('buku.edit', compact('buku', 'kategoris'));
    }

    public function update(Request $request, Buku $buku)
    {
        abort_unless(auth()->user()->isAdmin(), 403);
        $request->validate([
            'judul'        => 'required|string|max:255',
            'penulis'      => 'required|string|max:255',
            'penerbit'     => 'required|string|max:255',
            'tahun_terbit' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'isbn'         => 'required|string|unique:bukus,isbn,' . $buku->id,
            'kategori_id'  => 'required|exists:kategoris,id',
            'stok'         => 'required|integer|min:1',
            'foto'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
        $data = $request->except('foto');
        if ($request->hasFile('foto')) {
            if ($buku->foto) Storage::disk('public')->delete($buku->foto);
            $data['foto'] = $request->file('foto')->store('buku', 'public');
        }
        $buku->update($data);
        return redirect()->route('buku.index')->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Buku $buku)
    {
        abort_unless(auth()->user()->isAdmin(), 403);
        if ($buku->foto) Storage::disk('public')->delete($buku->foto);
        $buku->delete();
        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus.');
    }
}
