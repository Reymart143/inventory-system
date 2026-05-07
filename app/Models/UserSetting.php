<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sidebar_color',
    ];

    // Define the relationship with the User model (if needed)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
