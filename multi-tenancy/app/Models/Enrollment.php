<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function contractor()
    {
        return $this->belongsTo(Contractor::class);
    }

    public function operator()
    {
        return $this->belongsTo(Operator::class);
    }
}
