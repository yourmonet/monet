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

        $users = $query->orderBy('name')->paginate(30);
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
        // Editing member profiles is not allowed for Bendahara role
        return redirect()->route('bendahara.manajemen-data-anggota.show', $id)
            ->with('error', 'Anda tidak memiliki izin untuk mengedit profil anggota.');
    }

    public function update(Request $request, $id)
    {
        // Disallow updates – return forbidden response
        abort(403, 'Tidak diizinkan mengubah data anggota.');
    }
}
