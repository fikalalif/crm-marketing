<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\LeadStatus; // WAJIB TAMBAH INI UNTUK BOARD TRELLO
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data status untuk header board Trello
        $statuses = LeadStatus::orderBy('order', 'asc')->get();

        // Mulai query dengan relasi marketing DAN status (dinamis)
        $query = Lead::with(['marketing', 'status'])->latest();

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

        // 2. Fitur Filter Status (Dicocokkan dengan lead_status_id yang baru)
        if ($request->filled('status')) {
            $query->where('lead_status_id', $request->status);
        }

        // 3. Fitur Filter Source
        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        // 4. Fitur Filter Tanggal (berdasarkan tanggal dibuat)
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // Eksekusi query TANPA pagination, lalu di-group berdasarkan status ID (Untuk tampilan Trello)
        // Dibatasi 100 agar board tidak terlalu berat memuat data lama
        $leads = $query->limit(100)->get()->groupBy('lead_status_id');

        return view('leads.index', compact('leads', 'statuses'));
    }

    // Menampilkan form tambah lead
    public function create()
    {
        // Lempar data status ke form
        $statuses = LeadStatus::orderBy('order', 'asc')->get();
        return view('leads.create', compact('statuses'));
    }

    // Memproses penyimpanan data ke database
    public function store(Request $request)
    {
        // 1. Validasi Backend sesuai dokumen brief (Disesuaikan untuk dynamic status & input tanggal)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'company' => 'nullable|string|max:255',
            'lead_status_id' => 'required|exists:lead_statuses,id',
            'source' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'created_at' => 'required|date',
        ], [
            // Kustomisasi pesan error
            'name.required' => 'Nama customer wajib diisi.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'lead_status_id.required' => 'Status wajib dipilih.',
            'created_at.required' => 'Tanggal input wajib diisi.',
            'created_at.date' => 'Format tanggal tidak valid.'
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
        // Lempar data status ke form
        $statuses = LeadStatus::orderBy('order', 'asc')->get();
        return view('leads.edit', compact('lead', 'statuses'));
    }

    // Memproses update data ke database
    public function update(Request $request, Lead $lead)
    {
        // Validasi data input (Disesuaikan untuk dynamic status & input tanggal)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'company' => 'nullable|string|max:255',
            'lead_status_id' => 'required|exists:lead_statuses,id',
            'source' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'created_at' => 'required|date',
        ], [
            'name.required' => 'Nama customer wajib diisi.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'lead_status_id.required' => 'Status wajib dipilih.',
            'created_at.required' => 'Tanggal input wajib diisi.',
            'created_at.date' => 'Format tanggal tidak valid.'
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

    // API Endpoint khusus untuk Drag and Drop Trello Board
    public function updateStatus(Request $request, Lead $lead)
    {
        $request->validate(['lead_status_id' => 'required|exists:lead_statuses,id']);
        $lead->update(['lead_status_id' => $request->lead_status_id]);

        return response()->json(['success' => true]);
    }

    // Tambahkan fungsi export ini (Tetap utuh dari kode asli)
    public function exportPdf(Request $request)
    {
        // Tambahkan relasi status
        $query = Lead::with(['marketing', 'status'])->latest();

        // Terapkan filter yang sama persis dengan fungsi index()
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('company', 'like', "%{$search}%");
            });
        }

        // Sesuaikan dengan kolom status yang baru
        if ($request->filled('status')) {
            $query->where('lead_status_id', $request->status);
        }

        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }
        if ($request->filled('days')) {
            $startDate = now()->subDays($request->days)->startOfDay();
            $query->where('created_at', '>=', $startDate);
        }

        // Ambil semua data yang sudah difilter (tanpa pagination)
        $leads = $query->get();

        // Load view PDF dan atur kertas menjadi A4 Landscape agar tabel muat
        $pdf = Pdf::loadView('leads.pdf', compact('leads', 'request'))
            ->setPaper('a4', 'landscape');

        // Buat nama file dinamis
        $fileName = 'Laporan-Leads-' . date('Y-m-d') . '.pdf';

        return $pdf->download($fileName);
    }
}
