<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lead;
use Faker\Factory as Faker;

class LeadSeeder extends Seeder
{
    public function run(): void
    {
        // Menggunakan Faker dengan pengaturan bahasa Indonesia
        $faker = Faker::create('id_ID');

        $statuses = ['cool', 'warm', 'hot', 'close'];
        $sources = ['Google Ads', 'Meta Ads', 'Website', 'WhatsApp', 'Referral', 'Organic'];

        // Beberapa catatan spesifik agar pencarian lebih bervariasi saat dites
        $customNotes = [
            'Tanya spesifikasi wire strainer untuk Honda Vario 150.',
            'Mencari stok kamera digital vintage Kodak dan Canon.',
            'Berminat dengan aplikasi berpalet warna Y2K yang manly but bright.',
            'Order partai besar untuk acara makan Bakso dan Mie Aceh di Tegal.',
            'Butuh sparepart aksesoris untuk Yamaha Fazzio.',
            'Tanya ketersediaan lensa untuk Olympus dan Lumix.',
            'Tertarik kerja sama pengembangan aplikasi AI menggunakan FastAPI.',
            'Klien mencari solusi identifikasi elemen geologi organik yang simpel.',
            'Minta di-follow up via WhatsApp minggu depan.',
            'Tanya ketersediaan suku cadang dari supplier internasional.',
            'Konsultasi untuk perbaikan error lensa kamera Casio.'
        ];

        // Looping untuk membuat 35 data lead dummy
        for ($i = 0; $i < 35; $i++) {
            Lead::create([
                'name' => $faker->name,
                'phone' => $faker->phoneNumber,
                'email' => $faker->unique()->safeEmail,
                'company' => $faker->company,
                'status' => $faker->randomElement($statuses),
                'source' => $faker->randomElement($sources),
                'notes' => $faker->randomElement($customNotes),

                // Set ID 2 (Akun Marketing yang dibuat di UserSeeder sebelumnya)
                'assigned_to' => 2,

                // Acak tanggal pembuatan dari 3 bulan lalu hingga hari ini
                'created_at' => $faker->dateTimeBetween('-3 months', 'now'),
            ]);
        }
    }
}
