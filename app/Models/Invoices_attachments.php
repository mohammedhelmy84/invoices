<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Invoices_attachments extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsTo(User::class,'created_by');
    }

    // public function invoices()
    // {
    //     return $this->belongsTo(Invoices::class,'invoice_id');
    // }

    public function invoices(): BelongsTo
    {
        return $this->belongsTo(Invoices::class);
    }

}
