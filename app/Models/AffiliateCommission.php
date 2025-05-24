<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webkul\Sales\Models\Order;

class AffiliateCommission extends Model
{
    use HasFactory;

    protected $table = 'affiliate_commissions';

    protected $fillable = [
        'affiliate_id',
        'order_id',
        'from_affiliate_id',
        'level',
        'amount',
        'percentage',
        'status',
        'description',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'amount' => 'decimal:4',
        'percentage' => 'decimal:2',
    ];

    /**
     * Komisyonun ait olduğu affiliate
     */
    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class, 'affiliate_id');
    }

    /**
     * Komisyonun bağlı olduğu sipariş
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Komisyonun geldiği alt affiliate
     */
    public function fromAffiliate()
    {
        return $this->belongsTo(Affiliate::class, 'from_affiliate_id');
    }

    /**
     * Bekleyen komisyonları filtrele
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Onaylanmış komisyonları filtrele
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Ödenmiş komisyonları filtrele
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    /**
     * Reddedilmiş komisyonları filtrele
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}
