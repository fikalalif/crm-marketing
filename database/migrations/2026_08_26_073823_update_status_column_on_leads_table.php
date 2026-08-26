<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            // Hapus kolom status lama (enum)
            $table->dropColumn('status');
            // Tambah foreign key baru
            $table->foreignId('lead_status_id')->nullable()->constrained('lead_statuses')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropForeign(['lead_status_id']);
            $table->dropColumn('lead_status_id');
            $table->string('status')->default('cool');
        });
    }
};
