<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['description','is_completed','user_id','deadline'];
    protected $casts = [
        'is_completed' => 'boolean',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
