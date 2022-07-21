<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'alamat',
    ];

    // protected $attributes = ['ticket_code'];
    // protected $appends = [
    //     'ticket_code'
    // ];

    // public function getTicketCodeAttribute()
    // {
    //     return 'Ticket-'  . $this->attributes['id'];
    // }
}
