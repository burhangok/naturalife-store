<?php

namespace App\Models;

use App\Models\AffiliatePaymentMethod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webkul\Customer\Models\Customer;
use Webkul\User\Models\Admin;

class Affiliate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'parent_id',
        'customer_id',
        'affiliate_code',
        'level',
        'status',
        'total_commission_earned',
        'last_commission_at',
        'joined_at',
        'description',
        'created_admin_id',
        'updated_admin_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'last_commission_at' => 'datetime',
        'joined_at' => 'datetime',
        'total_commission_earned' => 'decimal:2',
    ];

    /**
     * Get the parent affiliate.
     */
    public function parent()
    {
        return $this->belongsTo(Affiliate::class, 'parent_id');
    }

    /**
     * Get the children affiliates.
     */
    public function children()
    {
        return $this->hasMany(Affiliate::class, 'parent_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Get the user who created this affiliate.
     */
    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_user_id');
    }

    /**
     * Get the user who last updated this affiliate.
     */
    public function updatedBy()
    {
        return $this->belongsTo(Admin::class, 'updated_user_id');
    }

    /**
     * Get the formatted total commission.
     */
    public function getFormattedCommissionAttribute()
    {
        return core()->formatPrice($this->commissions()->sum('amount'));
    }

    /**
     * Get the status badge HTML.
     */
    public function getStatusBadgeAttribute()
    {
        $classes = [
            'active' => 'bg-green-100 text-green-800',
            'inactive' => 'bg-gray-100 text-gray-800',
            'suspended' => 'bg-red-100 text-red-800',
        ];

        $class = $classes[$this->status] ?? 'bg-gray-100 text-gray-800';

        return '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ' . $class . '">' . ucfirst($this->status) . '</span>';
    }

    /**
     * Get all commissions for this affiliate.
     */
    public function commissions()
    {
        return $this->hasMany(AffiliateCommission::class, 'affiliate_id');
    }

    public static function getCommissionsByAffiliateId($affiliateId)
    {
        return AffiliateCommission::where('from_affiliate_id', $affiliateId)->get();
    }

    /**
     * Get all commissions where this affiliate is the source.
     */
    public function generatedCommissions()
    {
        return $this->hasMany(AffiliateCommission::class, 'from_affiliate_id');
    }

    public function clicks()
    {
        return $this->hasMany(AffiliateClick::class);
    }

    // Toplam kazanç hesaplama
    public function getTotalEarningsAttribute()
    {
        return $this->commissions()->sum('amount');
    }



    // Bu ayki kazanç
    public function getThisMonthEarningsAttribute()
    {
        return $this->commissions()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');
    }

    // Toplam click sayısı
    public function getTotalClicksAttribute()
    {
        return $this->clicks()->count();
    }

    // Toplam dönüşüm sayısı
    public function getTotalConversionsAttribute()
    {
        return $this->clicks()->converted()->count();
    }

    // Dönüşüm oranı hesaplama
    public function getConversionRateAttribute()
    {
        $totalClicks = $this->total_clicks;
        $totalConversions = $this->total_conversions;

        if ($totalClicks == 0)
            return 0;

        return round(($totalConversions / $totalClicks) * 100, 2);
    }

    // Bu ayki click sayısı
    public function getThisMonthClicksAttribute()
    {
        return $this->clicks()->thisMonth()->count();
    }

    // Bu ayki dönüşüm sayısı
    public function getThisMonthConversionsAttribute()
    {
        return $this->clicks()->thisMonth()->converted()->count();
    }

    // Bu ayki dönüşüm oranı
    public function getThisMonthConversionRateAttribute()
    {
        $clicks = $this->this_month_clicks;
        $conversions = $this->this_month_conversions;

        if ($clicks == 0)
            return 0;

        return round(($conversions / $clicks) * 100, 2);
    }

    // Bugünkü click sayısı
    public function getTodayClicksAttribute()
    {
        return $this->clicks()->today()->count();
    }

    // Bugünkü dönüşüm sayısı
    public function getTodayConversionsAttribute()
    {
        return $this->clicks()->today()->converted()->count();
    }



    // Click başına ortalama değer (RPM - Revenue Per Mille)
    public function getRevenuePerClickAttribute()
    {
        $totalClicks = $this->total_clicks;
        $totalRevenue = $this->commissions()->sum('amount');

        if ($totalClicks == 0)
            return 0;

        return round($totalRevenue / $totalClicks, 4);
    }

    public function paymentMethod()
    {
        return $this->hasOne(AffiliatePaymentMethod::class);
    }

    public function payments()
    {
        return $this->hasMany(AffiliatePayment::class);
    }

    public function getTotalPaidCommissionAttribute()
    {
        return $this->payments()->sum('amount');
    }

    // Cari hesap bakiyesi
    public function getCurrentAccountBalanceAttribute()
    {
        $totalEarned = $this->getTotalEarningsAttribute(); // Bu fonksiyonu kendinize göre yazın
        $totalPaid = $this->getTotalPaidCommissionAttribute();

        return $totalEarned - $totalPaid;
    }

// Son ödeme
public function getLastPayment()
{
    return $this->payments()->latest()->first();
}

public function getCommissionEarnedFrom(Affiliate $fromAffiliate): float
    {
        return AffiliateCommission::where('affiliate_id', $this->id)
            ->where('from_affiliate_id', $fromAffiliate->id)
            ->sum('amount');
    }

    public function getLastCommission()
    {
        return $this->commissions()->latest()->first();
    }


    public function getDescendantOrderTotalsPerLevel()
    {
        $result = [];
        $maxLevel = \DB::table('commission_rules')->max('level');

        $queue = [
            [
                'affiliate' => $this,
                'level' => 0
            ]
        ];

        while (!empty($queue)) {
            $current = array_shift($queue);
            $currentAffiliate = $current['affiliate'];
            $currentLevel = $current['level'];

            if ($currentLevel >= $maxLevel) {
                continue;
            }

            foreach ($currentAffiliate->children as $child) {
                $nextLevel = $currentLevel + 1;

                $orderTotal = optional($child->customer)->orders()
                    ->whereNotIn('status', ['canceled', 'closed'])
                    ->sum('base_grand_total_invoiced');

                if (!isset($result[$nextLevel])) {
                    $result[$nextLevel] = 0;
                }

                $result[$nextLevel] += $orderTotal;

                $queue[] = [
                    'affiliate' => $child,
                    'level' => $nextLevel
                ];
            }
        }

        return $result; // [1 => 1200, 2 => 3400, ...]
    }

    public function getTotalCommissionFromNetwork(): float
    {
        return AffiliateCommission::where('affiliate_id', $this->id)->sum('amount');
    }



}
