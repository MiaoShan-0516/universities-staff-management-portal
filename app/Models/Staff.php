<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'dob',
        'email',
        'location',
        'isActive',
    ];

    protected $table = 'staff';
    protected $primaryKey = 'id';

    public function university()
    {
        return $this->belongsTo('App\Models\University','id');
    }
}
