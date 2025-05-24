<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webkul\Customer\Models\Customer;
use Webkul\Sales\Models\Order;

class AffiliateClick extends Model
{
    // Tablo adı otomatik belirlenir; gerekirse açıkça da yazabilirsiniz:
    // protected $table = 'affiliate_clicks';

    protected $fillable = [
        'affiliate_id',
        'ip_address',
        'user_agent',
        'referrer_url',
        'device_type',
        'browser',
        'browser_version',
        'operating_system',
        'operating_system_version',
        'is_bot',
        'country',
        'region',
        'city',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
        'converted',
        'conversion_id',
        'landing_page',
        'first_visit_time',
        'last_visit_time',
        'visit_count',
        'session_id',
        'time_on_site',
        'customer_id',
    ];

    protected $casts = [
        'is_bot' => 'boolean',
        'converted' => 'boolean',
        'first_visit_time' => 'datetime',
        'last_visit_time' => 'datetime',
        'visit_count' => 'integer',
        'time_on_site' => 'integer',
    ];

    /**
     * Affiliate ile olan ilişki
     */
    public function affiliate(): BelongsTo
    {
        return $this->belongsTo(Affiliate::class);
    }

    /**
     * (Opsiyonel) Müşteri ile olan ilişki
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    //Sipariş ile ilişki
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Dönüşüm yapan clickler için scope
    public function scopeConverted($query)
    {
        return $query->where('converted', true);
    }

    // Bugünkü clickler
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    // Bu ayki clickler
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
    }
}
