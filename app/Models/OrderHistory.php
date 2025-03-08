<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class OrderHistory extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $table = 'order_histories';

    protected $fillable = [
        'order_id',
        'description',
        'order_status',
        'add_by',
        'updated_by',
    ];

    protected $casts = [
        'order_status' => 'integer',
    ];

    /**
     * Define relationships
     */
    public function orderId()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function addBy()
    {
        return $this->belongsTo(User::class, 'add_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
