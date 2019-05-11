<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{

    protected $fillable = [
        'province',
        'city',
        'district',
        'address',
        'contact_name',
        'contact_phone',
        'zip',
        'last_use'];

    //

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    public function getFullAddressAttribute()
    {
        return "{$this->province}·{$this->city}·{$this->district} {$this->address}";
    }
}
