<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GuestController extends Controller
{
    /**
     * Menampilkan daftar tamu.
     */
    public function index()
    {
        $guests = Guest::latest()->paginate(10);

        return view('guests.index', compact('guests'));
    }

    /**
     * Menampilkan form tambah tamu.
     */
    public function create()
    {
        return view('guests.create');
    }

    /**
     * Menyimpan tamu baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'no_hp' => [
                'nullable',
                'string',
                'max:20',
            ],
            'address' => [
                'nullable',
                'string',
            ],
        ], [
            'name.required' => 'Nama tamu wajib diisi.',
            'name.max' => 'Nama tamu maksimal 255 karakter.',
            'no_hp.max' => 'Nomor HP maksimal 20 karakter.',
        ]);

        $validated['qr_code'] = 'INVITO-' . Str::upper(Str::random(12));
        $validated['status'] = 'pending';

        Guest::create($validated);

        return redirect()
            ->route('guests.index')
            ->with('success', 'Tamu berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit tamu.
     */
    public function edit(Guest $guest)
    {
        return view('guests.edit', compact('guest'));
    }

    /**
     * Memperbarui data tamu.
     */
    public function update(Request $request, Guest $guest)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'no_hp' => [
                'nullable',
                'string',
                'max:20',
            ],
            'address' => [
                'nullable',
                'string',
            ],
        ], [
            'name.required' => 'Nama tamu wajib diisi.',
            'name.max' => 'Nama tamu maksimal 255 karakter.',
            'no_hp.max' => 'Nomor HP maksimal 20 karakter.',
        ]);

        $guest->update($validated);

        return redirect()
            ->route('guests.index')
            ->with('success', 'Data tamu berhasil diperbarui.');
    }

    /**
     * Menghapus tamu.
     */
    public function destroy(Guest $guest)
    {
        $guest->delete();

        return redirect()
            ->route('guests.index')
            ->with('success', 'Tamu berhasil dihapus.');
    }
}