<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoices_details extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_invoice',
        'invoice_number',
        'product',
        'section',
        'status',
        'value_status',
        'note',
        'user_id',
    ];


    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
