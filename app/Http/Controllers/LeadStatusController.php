<?php

namespace App\Http\Controllers;

use App\Models\LeadStatus;
use Illuminate\Http\Request;

class LeadStatusController extends Controller
{
    public function index()
    {
        // Mengambil status dan mengurutkannya berdasarkan kolom 'order'
        $statuses = LeadStatus::orderBy('order', 'asc')->get();
        return view('statuses.index', compact('statuses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:50',
            'order' => 'required|integer',
        ], [
            'name.required' => 'Nama status wajib diisi.',
            'color.required' => 'Warna kolom wajib dipilih.',
            'order.required' => 'Urutan wajib diisi.'
        ]);

        LeadStatus::create($validated);

        return redirect()->route('statuses.index')->with('success', 'Kolom Status baru berhasil ditambahkan!');
    }

    public function destroy(LeadStatus $status)
    {
        // Proteksi: Jangan izinkan hapus kalau masih ada lead yang nyangkut di status ini
        if ($status->leads()->count() > 0) {
            return redirect()->route('statuses.index')->withErrors(['Gagal! Masih ada data prospek di dalam kolom ini. Pindahkan dulu sebelum dihapus.']);
        }

        $status->delete();
        return redirect()->route('statuses.index')->with('success', 'Kolom Status berhasil dihapus!');
    }
}
