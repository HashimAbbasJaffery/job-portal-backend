<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function assigned_by() {
        return $this->belongsTo(User::class, "assigner_id");
    }
    public function files() {
        return $this->belongsTo(File::class, "file_id");
    }
}
