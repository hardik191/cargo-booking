<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class OrderContainerDetail extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $table = 'order_container_details'; // Specify the table name

    protected $fillable = [
        'order_id',
        'container_id',
        'max_capacity',
        'capacity_unit',
        'base_price',
        'my_order_qty',
        'my_capacity',
        'sub_price',
        'add_by',
        'updated_by',
    ];

    protected $casts = [
        'max_capacity' => 'decimal:2',
        'base_price' => 'decimal:2',
        'my_capacity' => 'decimal:2',
        'sub_price' => 'decimal:2',
        'capacity_unit' => 'integer',
        'my_order_qty' => 'integer',
    ];

    /**
     * Define relationships
     */
    public function orderId()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function containerId()
    {
        return $this->belongsTo(Container::class, 'container_id');
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
