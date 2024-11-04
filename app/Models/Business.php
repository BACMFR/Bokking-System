<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    protected $table = 'businesses';

    protected $fillable = [
        'name',
        'user_id',
        'starting_hour',
        'ending_hour',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
