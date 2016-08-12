<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $table = 'transactions';

    protected $fillable = [
        'transaction_id',
        'state',
        'payment_method',
        'amount',
        'invoice_number',
        'payer_id',
        'payer_email',
        'payer_first_name',
        'payer_last_name',
        'payer_shipping_address',
        'payer_billing_address'
    ];
}
