<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lead;
use App\Models\LeadStatus;
use Faker\Factory as Faker;

class LeadSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Tarik semua ID status yang sudah dibuat LeadStatusSeeder
        $statusIds = LeadStatus::pluck('id')->toArray();
        $sources = ['Google Ads', 'Meta Ads', 'Website', 'WhatsApp', 'Referral', 'Organic'];

        $customNotes = [
            'Tanya spesifikasi wire strainer untuk Honda Vario 150.',
            'Mencari stok kamera digital vintage Canon IXUS dan Kodak.',
            'Berminat dengan aplikasi berpalet warna Y2K yang manly but bright.',
            'Order partai besar untuk pengiriman ke area Lebaksiu, Tegal.',
            'Tertarik kerja sama pengembangan web menggunakan Laravel dan Astro.',
            'Tanya ketersediaan paket hosting untuk deployment di Hostinger.',
            'Klien mencari solusi identifikasi elemen geologi organik yang simpel.',
            'Konsultasi untuk perbaikan error lensa pada kamera Nikon Coolpix.',
            'Minta di-follow up via WhatsApp minggu depan.',
            'Tanya ketersediaan suku cadang dari supplier internasional.'
        ];

        for ($i = 0; $i < 35; $i++) {
            Lead::create([
                'name' => $faker->name,
                'phone' => $faker->phoneNumber,
                'email' => $faker->unique()->safeEmail,
                'company' => $faker->company,
                // Menggunakan lead_status_id, bukan text status
                'lead_status_id' => $faker->randomElement($statusIds),
                'source' => $faker->randomElement($sources),
                'notes' => $faker->randomElement($customNotes),
                'assigned_to' => 2, // ID Akun Marketing
                'created_at' => $faker->dateTimeBetween('-3 months', 'now'),
            ]);
        }
    }
}
