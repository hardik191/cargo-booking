<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Order extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $table = 'orders'; // Specify the table name

    protected $fillable = [
        'order_code',
        'sender_name',
        'sender_email',
        'sender_country_code',
        'sender_phone_no',
        'sender_port_id',
        'receiver_name',
        'receiver_email',
        'receiver_country_code',
        'receiver_phone_no',
        'receiver_port_id',
        'total_capacity',
        'total_qty',
        'total_price',
        'total_charge',
        'final_total',
        'order_status', // 1 For Pending ,2 For Accepted, 3 For Rejected, 4 For Shipped, 5 For Deliver Default(1)
        'payment_status', // 1 For Pending ,2 For Successful, 3 For Cancelled Default(1)
        'is_deleted',
        'add_by',
        'receiver_id',
        'updated_by'
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'total_charge' => 'decimal:2',
        'final_total' => 'decimal:2',
        'order_status' => 'integer',
        'payment_status' => 'integer',
        'is_deleted' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        // Generate Order Code before creating a new order
        static::creating(function ($order) {
            $order->order_code = self::generateOrderCode();
        });
    }

    private static function generateOrderCode()
    {
        // Get the current year and determine the financial year
        $currentYear = date('Y');
        $nextYear = date('y', strtotime('+1 year'));
        $prevYear = date('y', strtotime('-1 year'));

        // If the current month is before April, use the previous financial year
        if (date('m') < 4) {
            $financialYear = $prevYear . '-' . substr($currentYear, -2);
        } else {
            $financialYear = substr($currentYear, -2) . '-' . $nextYear;
        }

        // Find the last order for the same financial year
        $lastOrder = self::where('order_code', 'LIKE', 'ORD-' . $financialYear . '-%')
            ->orderBy('id', 'desc')
            ->first();

        // Determine next increment number
        if ($lastOrder) {
            $lastNumber = (int) substr($lastOrder->order_code, -2);
            $newNumber = str_pad($lastNumber + 1, 2, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '01';
        }

        // Generate and return the new order code
        return 'ORD-' . $financialYear . '-' . $newNumber;
    }
    
    /**
     * Define relationships
     */
    public function senderPortId()
    {
        return $this->belongsTo(Port::class, 'sender_port_id');
    }

    public function receiverPortId()
    {
        return $this->belongsTo(Port::class, 'receiver_port_id');
    }

    public function addBy()
    {
        return $this->belongsTo(User::class, 'add_by');
    }

    public function receiverId()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
