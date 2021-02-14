<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function tenantable()
    {
        return $this->morphTo();
    }

    public function tenantUsers()
    {
        return $this->hasMany(TenantUser::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'tenant_users');
    }

    public function resolve()
    {
        return $this->tenantable_type::findOrFail($this->tenantable_id);
    }
}
