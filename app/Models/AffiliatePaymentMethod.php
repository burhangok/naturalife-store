<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AffiliatePaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'affiliate_id',
        'payment_method',
        'tax_status',
        'account_holder_name',
        'bank_name',
        'iban',
        'bic_swift_code',
        'bank_address',
        'paypal_email',
        'paypal_merchant_id',
        'digital_wallet_email',
        'digital_wallet_account_id',
        'tax_number',
        'vat_number',
        'tax_country',
        'company_name',
        'company_registration_number',
        'billing_name',
        'billing_street',
        'billing_postal_code',
        'billing_city',
        'billing_country',
        'payment_delay_days',
        'currency',
        'special_notes',
    ];

    protected $casts = [
        'payment_delay_days' => 'integer',
    ];

    /**
     * Affiliate ile ilişki
     */
    public function affiliate(): BelongsTo
    {
        return $this->belongsTo(Affiliate::class);
    }

    /**
     * Ödeme yöntemi seçenekleri
     */
    public static function getPaymentMethods(): array
    {
        return [
            'sepa' => 'SEPA Transfer (Avrupa)',
            'bank' => 'Uluslararası Banka Transferi',
            'paypal' => 'PayPal',
            'wise' => 'Wise (eski TransferWise)',
            'revolut' => 'Revolut Business',
            'stripe' => 'Stripe Connect',
        ];
    }

    /**
     * Vergi durumu seçenekleri
     */
    public static function getTaxStatuses(): array
    {
        return [
            'individual' => 'Bireysel',
            'company' => 'Şirket',
            'freelancer' => 'Serbest Meslek',
            'vat_registered' => 'KDV Kayıtlı',
        ];
    }

    /**
     * Desteklenen ülkeler
     */
    public static function getSupportedCountries(): array
    {
        return [
            'DE' => 'Almanya',
            'FR' => 'Fransa',
            'NL' => 'Hollanda',
            'AT' => 'Avusturya',
            'BE' => 'Belçika',
            'IT' => 'İtalya',
            'ES' => 'İspanya',
            'PT' => 'Portekiz',
        ];
    }

    /**
     * Para birimleri
     */
    public static function getCurrencies(): array
    {
        return [
            'EUR' => 'Euro (EUR)',
            'USD' => 'Amerikan Doları (USD)',
        ];
    }

    /**
     * Ödeme gecikme günleri
     */
    public static function getPaymentDelayOptions(): array
    {
        return [
            0 => 'Hemen',
            7 => '7 Gün',
            15 => '15 Gün',
            30 => '30 Gün',
        ];
    }

    /**
     * IBAN formatını doğrula
     */
    public function validateIban(): bool
    {
        if (!$this->iban) {
            return false;
        }

        // Basit IBAN formatı kontrolü
        $iban = preg_replace('/\s+/', '', $this->iban);
        return preg_match('/^[A-Z]{2}[0-9]{2}[A-Z0-9]+$/', $iban) && strlen($iban) >= 15;
    }

    /**
     * Email adresini doğrula (PayPal veya dijital cüzdan için)
     */
    public function validateEmail(string $email = null): bool
    {
        $emailToValidate = $email ?? $this->paypal_email ?? $this->digital_wallet_email;
        return filter_var($emailToValidate, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Ödeme yönteminin görünen adı
     */
    public function getPaymentMethodNameAttribute(): ?string
    {
        if (!$this->payment_method) {
            return null;
        }

        $methods = self::getPaymentMethods();
        return $methods[$this->payment_method] ?? $this->payment_method;
    }

    /**
     * Vergi durumunun görünen adı
     */
    public function getTaxStatusNameAttribute(): ?string
    {
        if (!$this->tax_status) {
            return null;
        }

        $statuses = self::getTaxStatuses();
        return $statuses[$this->tax_status] ?? $this->tax_status;
    }

    /**
     * Tam fatura adresi
     */
    public function getFullBillingAddressAttribute(): string
    {
        $address = [];

        if ($this->billing_name)
            $address[] = $this->billing_name;
        if ($this->billing_street)
            $address[] = $this->billing_street;

        $cityLine = [];
        if ($this->billing_postal_code)
            $cityLine[] = $this->billing_postal_code;
        if ($this->billing_city)
            $cityLine[] = $this->billing_city;
        if (!empty($cityLine))
            $address[] = implode(' ', $cityLine);

        if ($this->billing_country) {
            $countries = self::getSupportedCountries();
            $address[] = $countries[$this->billing_country] ?? $this->billing_country;
        }

        return implode(', ', $address);
    }

    /**
     * Ödeme bilgilerinin eksiksiz olup olmadığını kontrol et
     */
    public function isComplete(): bool
    {
        if (!$this->payment_method) {
            return false;
        }

        switch ($this->payment_method) {
            case 'sepa':
            case 'bank':
                return !empty($this->account_holder_name) &&
                    !empty($this->bank_name) &&
                    !empty($this->iban) &&
                    !empty($this->bic_swift_code);

            case 'paypal':
                return !empty($this->paypal_email) && $this->validateEmail($this->paypal_email);

            case 'wise':
            case 'revolut':
                return !empty($this->digital_wallet_email) && $this->validateEmail($this->digital_wallet_email);

            case 'stripe':
                return !empty($this->digital_wallet_email);

            default:
                return false;
        }
    }

    /**
     * Fatura bilgilerinin eksiksiz olup olmadığını kontrol et
     */
    public function hasBillingInfo(): bool
    {
        return !empty($this->billing_name) &&
            !empty($this->billing_street) &&
            !empty($this->billing_postal_code) &&
            !empty($this->billing_city) &&
            !empty($this->billing_country);
    }

    /**
     * Vergi bilgilerinin mevcut olup olmadığını kontrol et
     */
    public function hasTaxInfo(): bool
    {
        return !empty($this->tax_status) ||
            !empty($this->tax_number) ||
            !empty($this->vat_number);
    }

    /**
     * Belirli bir ödeme yöntemine göre filtrele
     */
    public function scopeByPaymentMethod($query, $method)
    {
        return $query->where('payment_method', $method);
    }

    /**
     * Eksiksiz ödeme bilgilerine sahip olanları filtrele
     */
    public function scopeComplete($query)
    {
        return $query->whereNotNull('payment_method')
            ->where(function ($q) {
                $q->where('payment_method', 'sepa')
                    ->whereNotNull('account_holder_name')
                    ->whereNotNull('bank_name')
                    ->whereNotNull('iban')
                    ->whereNotNull('bic_swift_code');
            })
            ->orWhere(function ($q) {
                $q->where('payment_method', 'bank')
                    ->whereNotNull('account_holder_name')
                    ->whereNotNull('bank_name')
                    ->whereNotNull('iban')
                    ->whereNotNull('bic_swift_code');
            })
            ->orWhere(function ($q) {
                $q->where('payment_method', 'paypal')
                    ->whereNotNull('paypal_email');
            })
            ->orWhere(function ($q) {
                $q->whereIn('payment_method', ['wise', 'revolut', 'stripe'])
                    ->whereNotNull('digital_wallet_email');
            });
    }
}
