<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClickUz extends Model
{
    use HasFactory;
    protected $fillable = ['click_trans_id', 'merchant_trans_id', 'amount', 'sign_time', 'situation', 'status'];

}
