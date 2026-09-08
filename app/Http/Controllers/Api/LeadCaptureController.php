<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\LeadStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LeadCaptureController extends Controller
{
    public function handleWebhook(Request $request)
    {
        // 1. Catat semua data yang masuk ke log server untuk keperluan debugging (opsional tapi penting)
        Log::info('Webhook Lead Masuk:', $request->all());

        $name = $request->input('name') ?? 'Prospek Tanpa Nama';
        $phone = $request->input('phone') ?? $request->input('sender');
        $email = $request->input('email');
        $company = $request->input('company');
        $source = $request->input('source') ?? 'Organic';
        $notes = $request->input('message') ?? 'Otomatis via Webhook';
        $assignedTo = $request->input('assigned_to'); // Jika ingin langsung assign ke PIC

        // 3. Validasi dasar: Jangan proses kalau nomor telepon kosong
        if (!$phone) {
            return response()->json(['error' => 'Nomor telepon wajib ada'], 400);
        }

        // 4. Cari ID untuk kolom pertama (status default) di Kanban
        // Kita ambil status dengan urutan (order) paling kecil/pertama
        $firstStatus = LeadStatus::orderBy('order', 'asc')->first();

        // 5. Eksekusi penyimpanan ke database
        $lead = Lead::create([
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'company' => $company,
            'source' => $source,
            'assigned_to' => $assignedTo,
            'notes' => 'Otomatis dari Webhook. Pesan: ' . $notes,
            'lead_status_id' => $firstStatus->id ?? 1, // Pastikan masuk ke kolom pertama
            'created_at' => now(),
        ]);

        // 6. Beri respon sukses ke server pengirim (Meta/Google/WA) agar mereka tahu paketnya sampai
        return response()->json([
            'status' => 'success',
            'message' => 'Lead berhasil ditangkap',
            'data' => $lead
        ], 201);
    }
}
