<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'company',
        'lead_status_id',
        'status',
        'source',
        'notes',
        'assigned_to',
        'created_at',
    ];

    public function status()
    {
        return $this->belongsTo(LeadStatus::class, 'lead_status_id');
    }

    public function marketing()
    {
        // Relasi kembali ke User
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
