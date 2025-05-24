<?php

namespace App\Http\Controllers;

use App\Models\Affiliate;
use App\Models\AffiliatePaymentMethod;
use Illuminate\Http\Request;
use Validator;

class AffiliatePaymentMethodController extends Controller
{
    /**
     * Ödeme bilgilerini kaydet veya güncelle
     */
    public function store(Request $request, Affiliate $affiliate)
    {

        dd("store fonksiyonuna geldi");
        try {
            // Affiliate'i bul
            $affiliate = Affiliate::findOrFail($affiliate);

            // Validation kuralları
            $validator = Validator::make($request->all(), [
                'payment_method' => 'nullable|in:sepa,bank,paypal,wise,revolut,stripe',
                'tax_status' => 'nullable|in:individual,company,freelancer,vat_registered',

                // Banka bilgileri
                'account_holder_name' => 'nullable|string|max:255',
                'bank_name' => 'nullable|string|max:255',
                'iban' => 'nullable|string|max:34',
                'bic_swift_code' => 'nullable|string|max:11',
                'bank_address' => 'nullable|string',

                // PayPal bilgileri
                'paypal_email' => 'nullable|email|max:255',
                'paypal_merchant_id' => 'nullable|string|max:255',

                // Dijital cüzdan bilgileri
                'digital_wallet_email' => 'nullable|email|max:255',
                'digital_wallet_account_id' => 'nullable|string|max:255',

                // Vergi bilgileri
                'tax_number' => 'nullable|string|max:50',
                'vat_number' => 'nullable|string|max:50',
                'tax_country' => 'nullable|string|size:2',
                'company_name' => 'nullable|string|max:255',
                'company_registration_number' => 'nullable|string|max:100',

                // Fatura adresi
                'billing_name' => 'nullable|string|max:255',
                'billing_street' => 'nullable|string|max:255',
                'billing_postal_code' => 'nullable|string|max:20',
                'billing_city' => 'nullable|string|max:100',
                'billing_country' => 'nullable|string|size:2',

                // Ödeme koşulları
                'payment_delay_days' => 'nullable|integer|in:0,7,15,30',
                'currency' => 'nullable|string|in:EUR,USD',
                'special_notes' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('error', 'Lütfen form alanlarını kontrol ediniz.');
            }

            // Mevcut ödeme bilgisini kontrol et
            $paymentMethod = $affiliate->paymentMethod;

            if ($paymentMethod) {
                // Güncelle
                $paymentMethod->update($validator->validated());
                $message = 'Ödeme bilgileriniz başarıyla güncellendi.';
            } else {
                // Yeni kayıt oluştur
                $paymentData = $validator->validated();
                $paymentData['affiliate_id'] = $affiliate->id;

                // Default değerler
                if (!isset($paymentData['payment_delay_days'])) {
                    $paymentData['payment_delay_days'] = 15;
                }
                if (!isset($paymentData['currency'])) {
                    $paymentData['currency'] = 'EUR';
                }

                AffiliatePaymentMethod::create($paymentData);
                $message = 'Ödeme bilgileriniz başarıyla kaydedildi.';
            }

            return back()->with('success', $message);

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Bir hata oluştu: ' . $e->getMessage());
        }
    }
}
