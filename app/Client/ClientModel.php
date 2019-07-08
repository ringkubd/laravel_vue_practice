<?php

namespace App\Client;

use Illuminate\Database\Eloquent\Model;

class ClientModel extends Model
{
    protected $table = "clients";
    protected $fillable = [
        "name",
        "address",
        "email",
        "contact_number",
    ];
}
