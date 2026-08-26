<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LeadStatus;

class LeadStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            ['name' => 'Lead', 'color' => 'bg-[#93c5fd]'], // Biru
            ['name' => 'Qualified', 'color' => 'bg-[#c4b5fd]'], // Ungu
            ['name' => 'Trial', 'color' => 'bg-[#fde047]'], // Kuning
            ['name' => 'Demo/Meet', 'color' => 'bg-[#fdba74]'], // Orange
            ['name' => 'Visit', 'color' => 'bg-[#fca5a5]'], // Merah
            ['name' => 'Quotation', 'color' => 'bg-[#67e8f9]'], // Cyan
            ['name' => 'Purchase', 'color' => 'bg-[#86efac]'], // Hijau Terang
            ['name' => 'Payment', 'color' => 'bg-[#6ee7b7]'], // Hijau Mint
            ['name' => 'Instalation', 'color' => 'bg-[#a3e635]'], // Hijau Lime
        ];

        foreach ($statuses as $index => $status) {
            LeadStatus::create([
                'name' => $status['name'],
                'color' => $status['color'],
                'order' => $index + 1,
            ]);
        }
    }
}
