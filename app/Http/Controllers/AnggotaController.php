<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        $search  = $request->input('search');
        $dari    = $request->input('dari', '');
        $sampai  = $request->input('sampai', '');

        $anggotas = Anggota::when($search, function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('telepon', 'like', "%{$search}%");
            })
            ->when($dari,   fn($q) => $q->whereDate('created_at', '>=', $dari))
            ->when($sampai, fn($q) => $q->whereDate('created_at', '<=', $sampai))
            ->latest()->paginate(10)->withQueryString();

        return view('anggota.index', compact('anggotas', 'search', 'dari', 'sampai'));
    }

    public function create()
    {
        return view('anggota.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'    => 'required|string|max:255',
            'alamat'  => 'required|string',
            'telepon' => 'required|string|max:20',
            'email'   => 'required|email|unique:anggotas|unique:users,email',
        ]);
        Anggota::create($request->all());
        User::create([
            'name'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make('password123'),
            'role'     => 'anggota',
        ]);
        return redirect()->route('anggota.index')
            ->with('success', 'Anggota ditambahkan. Login: ' . $request->email . ' / password123');
    }

    public function show(Anggota $anggota)
    {
        return view('anggota.show', compact('anggota'));
    }

    public function edit(Anggota $anggota)
    {
        return view('anggota.edit', compact('anggota'));
    }

    public function update(Request $request, Anggota $anggota)
    {
        $request->validate([
            'nama'    => 'required|string|max:255',
            'alamat'  => 'required|string',
            'telepon' => 'required|string|max:20',
            'email'   => 'required|email|unique:anggotas,email,' . $anggota->id . '|unique:users,email,' . optional(User::where('email', $anggota->email)->first())->id,
        ]);
        $user = User::where('email', $anggota->email)->first();
        if ($user) {
            $user->update([
                'name'  => $request->nama,
                'email' => $request->email,
            ]);
        }
        $anggota->update($request->all());
        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil diperbarui.');
    }

    public function destroy(Anggota $anggota)
    {
        User::where('email', $anggota->email)->delete();
        $anggota->delete();
        return redirect()->route('anggota.index')->with('success', 'Anggota dan akun login berhasil dihapus.');
    }
}
