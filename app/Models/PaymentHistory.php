<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    use HasFactory;
    protected $fillable = ['user_name', 'phone', 'address', 'payment_type', 'payslip_image', 'total_atm', 'order_code'];
}
