<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'domain', 
        'status', 
        'expires_at', 
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }
    public function isBanned(): bool
    {
        return $this->status === 'banned';
    }
    public function isExpired(): bool
    {
        return $this->status === 'expired' && $this->expired_at < now();
    }
}
