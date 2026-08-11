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
        'status',
        'source',
        'notes',
        'assigned_to',
    ];

    public function marketing()
    {
        // Relasi kembali ke User
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
