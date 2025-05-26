<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\AffiliatePayment;
use App\Models\Affiliate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AffiliatePaymentController extends Controller
{
    // Liste
    public function index(Request $request)
    {
        $payments = AffiliatePayment::with(['affiliate', 'createdAdmin'])
            ->when($request->affiliate_id, function($q, $affiliateId) {
                return $q->where('affiliate_id', $affiliateId);
            })
            ->when($request->payment_method, function($q, $method) {
                return $q->where('payment_method', $method);
            })
            ->latest()
            ->get();

        $affiliates = Affiliate::all();
        $paymentMethods = AffiliatePayment::getPaymentMethods();

        return view('affiliatemodule.admin.affiliatepayments.index', compact('payments', 'affiliates', 'paymentMethods'));
    }

    // Yeni ödeme formu
    public function create()
    {
        $affiliates = Affiliate::all();
        $paymentMethods = AffiliatePayment::getPaymentMethods();
        $currencies = AffiliatePayment::getCurrencies();

        return view('affiliatemodule.admin.affiliatepayments.create', compact('affiliates', 'paymentMethods', 'currencies'));
    }

    // Ödeme kaydet
    public function store(Request $request)
    {
        $request->validate([
            'affiliate_id' => 'required|exists:affiliates,id',
            'amount' => 'required|numeric|min:0.01',
            'currency' => 'required|in:EUR,USD,TRY',
            'payment_method' => 'required|in:sepa,bank,paypal,wise,revolut,stripe',
            'transaction_id' => 'nullable|string',
            'description' => 'nullable|string',
            'payment_file' => 'nullable|file|max:5120', // 5MB
        ]);

        $data = $request->only(['affiliate_id', 'amount', 'currency', 'payment_method', 'transaction_id', 'description']);
        $data['created_admin_id'] = auth()->guard('admin')->id();

        // Dosya yükleme
        if ($request->hasFile('payment_file')) {
            $path = $request->file('payment_file')->store('affiliate-payments', 'public');
            $data['payment_file_path'] = $path;
        }

        AffiliatePayment::create($data);

        return redirect()->route('admin.affiliatemodule.admin.affiliatepayments.index')->with('success', 'Ödeme kaydedildi');
    }

    // Ödeme detayı
    public function show(AffiliatePayment $affiliatePayment)
    {
        $affiliatePayment->load(['affiliate', 'createdAdmin']);
        return view('affiliatemodule.admin.affiliatepayments.show', compact('affiliatePayment'));
    }

    // Düzenleme formu
    public function edit(AffiliatePayment $payment)
    {
        $affiliates = Affiliate::all();
        $paymentMethods = AffiliatePayment::getPaymentMethods();
        $currencies = AffiliatePayment::getCurrencies();

        return view('affiliatemodule.admin.affiliatepayments.edit', compact('payment', 'affiliates', 'paymentMethods', 'currencies'));
    }

    // Güncelle
    public function update(Request $request, AffiliatePayment $affiliatePayment)
    {
        $request->validate([
            'affiliate_id' => 'required|exists:affiliates,id',
            'amount' => 'required|numeric|min:0.01',
            'currency' => 'required|in:EUR,USD,TRY',
            'payment_method' => 'required|in:sepa,bank,paypal,wise,revolut,stripe',
            'transaction_id' => 'nullable|string',
            'description' => 'nullable|string',
            'payment_file' => 'nullable|file|max:5120',
        ]);

        $data = $request->only(['affiliate_id', 'amount', 'currency', 'payment_method', 'transaction_id', 'description']);
        $data['updated_admin_id'] = auth()->guard('admin')->id();

        // Yeni dosya yüklendiyse
        if ($request->hasFile('payment_file')) {
            // Eski dosyayı sil
            if ($affiliatePayment->payment_file_path) {
                Storage::disk('public')->delete($affiliatePayment->payment_file_path);
            }
            // Yeni dosyayı yükle
            $path = $request->file('payment_file')->store('affiliate-payments', 'public');
            $data['payment_file_path'] = $path;
        }

        $affiliatePayment->update($data);

        return redirect()->route('admin.affiliatemodule.admin.affiliatepayments.index')->with('success', 'Ödeme güncellendi');
    }

    // Sil
    public function destroy(AffiliatePayment $payment)
    {


        // Dosyayı sil
        if ($payment->payment_file_path) {
            Storage::disk('public')->delete($payment->payment_file_path);
        }

        $payment->delete();

        return redirect()->route('admin.affiliatemodule.admin.affiliatepayments.index')->with('success', 'Ödeme silindi');
    }

}
