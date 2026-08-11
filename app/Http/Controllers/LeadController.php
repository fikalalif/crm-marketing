<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        // Mulai query dengan relasi marketing
        $query = Lead::with('marketing')->latest();

        // 1. Fitur Search (Nama, Phone, Email, Company)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('company', 'like', "%{$search}%");
            });
        }

        // 2. Fitur Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 3. Fitur Filter Source
        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        // 4. Fitur Filter Tanggal (berdasarkan tanggal dibuat)
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // Eksekusi query dengan pagination (10 data per halaman)
        // withQueryString() sangat penting agar filter tidak hilang saat pindah halaman
        $leads = $query->paginate(10)->withQueryString();

        return view('leads.index', compact('leads'));
    }

    // Menampilkan form tambah lead
    public function create()
    {
        return view('leads.create');
    }

    // Memproses penyimpanan data ke database
    public function store(Request $request)
    {
        // 1. Validasi Backend sesuai dokumen brief
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'company' => 'nullable|string|max:255',
            'status' => 'required|in:cool,warm,hot,close',
            'source' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ], [
            // Kustomisasi pesan error
            'name.required' => 'Nama customer wajib diisi.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'status.required' => 'Status wajib dipilih.'
        ]);

        // 2. Set assigned_to otomatis ke user yang sedang login
        $validated['assigned_to'] = auth()->id();

        // 3. Simpan ke database
        Lead::create($validated);

        // 4. Redirect kembali ke tabel dengan pesan sukses
        return redirect()->route('leads.index')->with('success', 'Lead baru berhasil ditambahkan!');
    }

    // Menampilkan form edit lead
    public function edit(Lead $lead)
    {
        return view('leads.edit', compact('lead'));
    }

    // Memproses update data ke database
    public function update(Request $request, Lead $lead)
    {
        // Validasi data input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'company' => 'nullable|string|max:255',
            'status' => 'required|in:cool,warm,hot,close',
            'source' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ], [
            'name.required' => 'Nama customer wajib diisi.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'status.required' => 'Status wajib dipilih.'
        ]);

        // Update data lead
        $lead->update($validated);

        return redirect()->route('leads.index')->with('success', 'Data lead berhasil diperbarui!');
    }

    // Menghapus data lead dari database
    public function destroy(Lead $lead)
    {
        $lead->delete();

        return redirect()->route('leads.index')->with('success', 'Data lead berhasil dihapus!');
    }

    // ... biarkan fungsi edit, update, destroy kosong untuk sementara
}
