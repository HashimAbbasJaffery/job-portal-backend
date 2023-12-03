<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $with = "role";
    protected $guarded = [];
    protected $table = "profile";
    use HasFactory;

    public function role() {
        return $this->belongsTo(Role::class, "role_id");
    }
}
