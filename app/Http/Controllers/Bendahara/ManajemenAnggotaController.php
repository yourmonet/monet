<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManajemenAnggotaController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\User::withCount(['penagihans as belum_lunas_count' => function($q) {
            $q->where('status', 'belum_lunas');
        }]);

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->orderBy('name')->get();
        return view('bendahara.manajemen-anggota.index', compact('users'));
    }

    public function show($id)
    {
        $user = \App\Models\User::with('kasMasuks')
                    ->withCount(['penagihans as belum_lunas_count' => function($q) {
                        $q->where('status', 'belum_lunas');
                    }])->findOrFail($id);
        return view('bendahara.manajemen-anggota.show', compact('user'));
    }

    public function edit($id)
    {
        $user = \App\Models\User::withCount(['penagihans as belum_lunas_count' => function($q) {
            $q->where('status', 'belum_lunas');
        }])->findOrFail($id);
        return view('bendahara.manajemen-anggota.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$id,
            'phone_number' => 'nullable|string|max:20',
            'role' => 'required|in:anggota,pengurus,bendahara',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'role' => $request->role,
        ]);

        return redirect()->route('bendahara.manajemen-data-anggota.index')->with('success', 'Data anggota berhasil diperbarui.');
    }
}
