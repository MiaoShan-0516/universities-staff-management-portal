<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'url',
    ];

    protected $table = 'universities';
    protected $primaryKey = 'id';

    public function staff()
    {
        return $this->hasMany('App\Models\Staff','university_id');
    }
}
