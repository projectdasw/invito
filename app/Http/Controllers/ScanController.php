<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;

class ScanController extends Controller
{
    public function index()
    {
        return view('scan.index');
    }

    public function lookup(Request $request)
    {
        $validated = $request->validate([
            'qr_code' => [
                'required',
                'string',
            ],
        ]);

        $guest = Guest::where('qr_code', $validated['qr_code'])->first();

        if (!$guest) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code tidak terdaftar.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data tamu ditemukan.',
            'guest' => [
                'id' => $guest->id,
                'name' => $guest->name,
                'no_hp' => $guest->no_hp,
                'address' => $guest->address,
                'qr_code' => $guest->qr_code,
                'status' => $guest->status,
            ],
        ]);
    }

    public function checkIn(Request $request)
    {
        $validated = $request->validate([
            'qr_code' => [
                'required',
                'string',
            ],
        ]);

        $guest = Guest::where('qr_code', $validated['qr_code'])->first();

        if (!$guest) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code tidak terdaftar.',
            ], 404);
        }

        if ($guest->status === 'checked_in') {
            return response()->json([
                'success' => false,
                'message' => 'Tamu ini sudah melakukan check-in.',
                'guest' => [
                    'name' => $guest->name,
                    'qr_code' => $guest->qr_code,
                    'status' => $guest->status,
                ],
            ], 422);
        }

        $guest->update([
            'status' => 'checked_in',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tamu berhasil melakukan check-in.',
            'guest' => [
                'name' => $guest->name,
                'qr_code' => $guest->qr_code,
                'status' => $guest->status,
            ],
        ]);
    }
}