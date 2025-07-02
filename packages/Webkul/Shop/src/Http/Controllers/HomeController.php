<?php

namespace Webkul\Shop\Http\Controllers;

use App\Models\Affiliate;
use App\Models\AffiliateClick;
use Illuminate\Support\Facades\Mail;
use Webkul\Shop\Http\Requests\ContactRequest;
use Webkul\Shop\Mail\ContactUs;
use Webkul\Theme\Repositories\ThemeCustomizationRepository;

class HomeController extends Controller
{
    /**
     * Using const variable for status
     */
    const STATUS = 1;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected ThemeCustomizationRepository $themeCustomizationRepository) {}

    /**
     * Loads the home page for the storefront.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        visitor()->visit();

        $customizations = $this->themeCustomizationRepository->orderBy('sort_order')->findWhere([
            'status'     => self::STATUS,
            'channel_id' => core()->getCurrentChannel()->id,
            'theme_code' => core()->getCurrentChannel()->theme,
        ]);

        return view('shop::home.index', compact('customizations'));
    }

    /**
     * Loads the home page for the storefront if something wrong.
     *
     * @return \Exception
     */
    public function notFound()
    {
        abort(404);
    }

    /**
     * Summary of contact.
     *
     * @return \Illuminate\View\View
     */
    public function contactUs()
    {
        return view('shop::home.contact-us');
    }

    /**
     * Summary of store.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendContactUsMail(ContactRequest $contactRequest)
    {
        try {
            Mail::queue(new ContactUs($contactRequest->only([
                'name',
                'email',
                'contact',
                'message',
            ])));

            session()->flash('success', trans('shop::app.home.thanks-for-contact'));
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());

            report($e);
        }

        return back();
    }


    //burhangok 02.06.2025
    public function applyCoupon($code)
    {
        // Kupon kodunu session'a kaydet
        session(['auto_apply_coupon' => $code]);

        // Ana sayfaya veya ürün sayfasına yönlendir
        return redirect('/')->with('success', 'Gutscheincode erfolgreich angewendet. ' . $code);
    }

    public function registerAffiliateWithReference($refAffCode) {// Affiliate kodunu kontrol et
        $affiliate = Affiliate::where('affiliate_code', $refAffCode)
            ->first();

        if ($affiliate) {
            // Session'a kaydet
            session([
                'parent_affiliate_id' => $affiliate->id,
                'parent_affiliate_code' => $refAffCode,
                'parent_affiliate_name' => $affiliate->getFullName(),

            ]);

            // Click'i kaydet
            $this->recordAffiliateClick($affiliate);



            return redirect('/customer/register')
                ->with('success', 'Ihr Sponsor/oberer Vertreter, der Sie im System registriert: ' . $affiliate->getFullName());
        } else {
            return redirect('/customer/register')
                ->with('error', 'Ungültiger Sponsor-/Upline-Code: ' . $refAffCode);
        }
    }

    private function recordAffiliateClick($affiliate)
    {
        try {
            // Affiliate click tablosuna kaydet
       $affiliateClick= AffiliateClick::create([
                'affiliate_id' => $affiliate->id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'referrer' => request()->headers->get('referer'),
                'clicked_at' => now()
            ]);

            session([
                'affiliate_click_id' => $affiliateClick->id

            ]);
        } catch (\Exception $e) {
            \Log::error('Affiliate click kayıt hatası: ' . $e->getMessage());
        }
    }

}
