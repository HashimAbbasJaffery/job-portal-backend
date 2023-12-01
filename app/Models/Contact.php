<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Message;

class Contact extends Model
{
    protected $table = "contact_relationship";

    public function messages() {
        return $this->hasOne(Message::class, "message_id");
    }
    use HasFactory;
}
