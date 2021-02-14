<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    use HasFactory;

    public function tenant()
    {
        return $this->morphOne(Tenant::class, 'tenantable');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function enrollmentContractors()
    {
        return $this->belongsToMany(Contractor::class, 'enrollments');
    }

    public function getNameAttribute()
    {
        return $this->tenant->name;
    }
}
