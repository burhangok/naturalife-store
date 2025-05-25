<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliatePayment extends Model
{
    protected $fillable = [
        'affiliate_id',
        'amount',
        'currency',
        'payment_method',
        'transaction_id',
        'description',
        'payment_file_path',
        'created_admin_id',
        'updated_admin_id'
    ];

    // İlişkiler
    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class);
    }

    public function createdAdmin()
    {
        return $this->belongsTo(Admin::class, 'created_admin_id');
    }

    // Ödeme metodları
    public static function getPaymentMethods()
    {
        return [
            'sepa' => 'SEPA Transfer',
            'bank' => 'Banka Transferi',
            'paypal' => 'PayPal',
            'wise' => 'Wise',
            'revolut' => 'Revolut',
            'stripe' => 'Stripe',
        ];
    }

    // Para birimleri
    public static function getCurrencies()
    {
        return [
            'EUR' => 'Euro',
            'USD' => 'Dolar',
            'TRY' => 'TL',
        ];
    }

    // Formatlanmış tutar
    public function getFormattedAmount()
    {
        return number_format($this->amount, 2) . ' ' . $this->currency;
    }
}
