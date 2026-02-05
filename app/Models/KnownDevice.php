<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KnownDevice extends Model
{
    use HasFactory;

    protected $table = 'known_devices'; // Correct table name

    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
        'last_login_at'
    ];

    protected $casts = [
        'last_login_at' => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'user_id');
    }
}
