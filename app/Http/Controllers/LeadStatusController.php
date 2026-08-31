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
            // Tambahkan aturan unique dan min:1 di sini
            'order' => 'required|integer|min:1|unique:lead_statuses,order',
        ], [
            'name.required' => 'Nama status wajib diisi.',
            'color.required' => 'Warna kolom wajib dipilih.',
            'order.required' => 'Urutan wajib diisi.',
            'order.min' => 'Angka urutan tidak boleh kurang dari 1.',
            'order.unique' => 'Angka urutan ini sudah dipakai. Silakan pilih angka urutan yang lain.'
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
