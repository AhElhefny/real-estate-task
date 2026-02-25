<?php

namespace App\Models;

use App\Enums\ContractStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    /** @use HasFactory<\Database\Factories\ContractFactory> */
    use HasFactory;

    public $fillable = [
        'tenant_id',
        'unit_name',
        'customer_name',
        'rent_amount',
        'start_date',
        'end_date',
        'status'
    ];

    public $casts = [
        'status' => ContractStatusEnum::class,
        'start_date' => 'date',
        'end_date' => 'date',
        'rent_amount' => 'decimal:2',
    ];

    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

}
