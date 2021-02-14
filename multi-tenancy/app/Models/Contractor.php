<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contractor extends Tenant
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

    public function enrollmentOperators()
    {
        return $this->belongsToMany(Operator::class, 'enrollments');
    }

    public function getNameAttribute()
    {
        return $this->tenant->name;
    }
}
