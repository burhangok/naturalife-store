<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html
    lang="{{ app()->getLocale() }}"
    dir="{{ core()->getCurrentLocale()->direction }}"
>
    <head>
        <!-- meta tags -->
        <meta
            http-equiv="Cache-control"
            content="no-cache"
        >

        <meta
            http-equiv="Content-Type"
            content="text/html; charset=utf-8"
        />

        @php
            $fontPath = [];

            // Get the default locale code.
            $getLocale = app()->getLocale();

            // Get the current currency code.
            $currencyCode = core()->getBaseCurrencyCode();

            if ($getLocale == 'en' && $currencyCode == 'INR') {
                $fontFamily = [
                    'regular' => 'DejaVu Sans',
                    'bold'    => 'DejaVu Sans',
                ];
            }  else {
                $fontFamily = [
                    'regular' => 'Arial, sans-serif',
                    'bold'    => 'Arial, sans-serif',
                ];
            }


            if (in_array($getLocale, ['ar', 'he', 'fa', 'tr', 'ru', 'uk'])) {
                $fontFamily = [
                    'regular' => 'DejaVu Sans',
                    'bold'    => 'DejaVu Sans',
                ];
            } elseif ($getLocale == 'zh_CN') {
                $fontPath = [
                    'regular' => asset('fonts/NotoSansSC-Regular.ttf'),
                    'bold'    => asset('fonts/NotoSansSC-Bold.ttf'),
                ];

                $fontFamily = [
                    'regular' => 'Noto Sans SC',
                    'bold'    => 'Noto Sans SC Bold',
                ];
            } elseif ($getLocale == 'ja') {
                $fontPath = [
                    'regular' => asset('fonts/NotoSansJP-Regular.ttf'),
                    'bold'    => asset('fonts/NotoSansJP-Bold.ttf'),
                ];

                $fontFamily = [
                    'regular' => 'Noto Sans JP',
                    'bold'    => 'Noto Sans JP Bold',
                ];
            } elseif ($getLocale == 'hi_IN') {
                $fontPath = [
                    'regular' => asset('fonts/Hind-Regular.ttf'),
                    'bold'    => asset('fonts/Hind-Bold.ttf'),
                ];

                $fontFamily = [
                    'regular' => 'Hind',
                    'bold'    => 'Hind Bold',
                ];
            } elseif ($getLocale == 'bn') {
                $fontPath = [
                    'regular' => asset('fonts/NotoSansBengali-Regular.ttf'),
                    'bold'    => asset('fonts/NotoSansBengali-Bold.ttf'),
                ];

                $fontFamily = [
                    'regular' => 'Noto Sans Bengali',
                    'bold'    => 'Noto Sans Bengali Bold',
                ];
            } elseif ($getLocale == 'sin') {
                $fontPath = [
                    'regular' => asset('fonts/NotoSansSinhala-Regular.ttf'),
                    'bold'    => asset('fonts/NotoSansSinhala-Bold.ttf'),
                ];

                $fontFamily = [
                    'regular' => 'Noto Sans Sinhala',
                    'bold'    => 'Noto Sans Sinhala Bold',
                ];
            }
        @endphp

        <!-- lang supports inclusion -->
        <style type="text/css">
            @if (! empty($fontPath['regular']))
                @font-face {
                    src: url({{ $fontPath['regular'] }}) format('truetype');
                    font-family: {{ $fontFamily['regular'] }};
                }
            @endif

            @if (! empty($fontPath['bold']))
                @font-face {
                    src: url({{ $fontPath['bold'] }}) format('truetype');
                    font-family: {{ $fontFamily['bold'] }};
                    font-style: bold;
                }
            @endif

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: {{ $fontFamily['regular'] }};
            }

            body {
                font-size: 10px;
                color: #091341;
                font-family: "{{ $fontFamily['regular'] }}";
            }

            b, th {
                font-family: "{{ $fontFamily['bold'] }}";
            }

            .page-content {
                padding: 12px;
            }

            .page-header {
                border-bottom: 1px solid #E9EFFC;
                text-align: center;
                font-size: 24px;
                text-transform: uppercase;
                color: #4B8712;
                padding: 24px 0;
                margin: 0;
            }

            .logo-container {
                position: absolute;
                top: 20px;
                left: 20px;
            }

            .logo-container.rtl {
                left: auto;
                right: 20px;
            }

            .logo-container img {
                max-width: 100%;
                height: auto;
            }

            .page-header b {
                display: inline-block;
                vertical-align: middle;
            }

            .small-text {
                font-size: 7px;
            }

            table {
                width: 100%;
                border-spacing: 1px 0;
                border-collapse: separate;
                margin-bottom: 16px;
            }

            table thead th {
                background-color: #E9EFFC;
                color: ##4B8712;
                padding: 6px 18px;
                text-align: left;
            }

            table.rtl thead tr th {
                text-align: right;
            }

            table tbody td {
                padding: 9px 18px;
                border-bottom: 1px solid #E9EFFC;
                text-align: left;
                vertical-align: top;
            }

            table.rtl tbody tr td {
                text-align: right;
            }

            .summary {
                width: 100%;
                display: inline-block;
            }

            .summary table {
                float: right;
                width: 250px;
                padding-top: 5px;
                padding-bottom: 5px;
                background-color: #e8f5e8;
                white-space: nowrap;
            }

            .summary table.rtl {
                width: 280px;
            }

            .summary table.rtl {
                margin-right: 480px;
            }

            .summary table td {
                padding: 5px 10px;
            }

            .summary table td:nth-child(2) {
                text-align: center;
            }

            .summary table td:nth-child(3) {
                text-align: right;
            }
        </style>
    </head>

    <body dir="{{ core()->getCurrentLocale()->direction }}">
        <div class="logo-container {{ core()->getCurrentLocale()->direction }}">
            @if (core()->getConfigData('sales.invoice_settings.pdf_print_outs.logo'))
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(Storage::url(core()->getConfigData('sales.invoice_settings.pdf_print_outs.logo')))) }}"/>
            @else
                <img  style="max-width: 100; height: auto;"  src="data:image/png;base64,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3DW2ZqWMhB+deVJQAtcIKmcKeBooakUjoq/tBX7jiSdkadfvn3vDIDXYOgzff6hX3hGlCwbpX5vLV1c9RdRSJ72Z7R2O+mFz1AgbozdzLGu0zzH97Omyq2rW5L8tnr1X1uxaFBz4odBg1/vdO9T+rHkYGorat0SbqdKpaIQe8FwJpYkoCB969BnGg/r5qaeyYs1yDXihEKt33XXXc//6p+t+ucce7/r85NGJ6Uop95Vlq76w7bbbvhJKeO77zz23GBs1Z0tW9c2map1vR+wyROfZjq/S1u5uAAABQklEQVTzz+AHRXPYalL7/zTVxC4Hfq/295akN3ODG1T9VKd3HA2L2Qdv2PwnB5KhDIXOOGE2a9asIdn9Kqeeeiq3/vYXnHrqqRzwtT8kPQ/1h3Om9Bx77LG4Uz/OqDG7lEUje0eRGy/TtRobwYCgKXafb811K0AniiZlWTE75Ee9LWjYU7BOW4k2fkrZ0uM4XNG4Tm8KbTEJfzjMHuBPN4mxYwyw446P09jYaCNi9mqN5LudOJGmMbsMq9y3I72QTpd0cCMO3Ci6goXptHTkO43R1+mdRnXW+j9IW/1oFwUOnbEPfR1d5PN59thhIlpr/v7EM4wePZonF0jwvNLsrEuQdapTneq0SfS2YPjgB4S3GAPrSWsTqNUZfp3qVKc6bR5tNYY/ZA+ZTXClqVOd6lSnOg2k/zaMVZ3qVKc61akG/T9Of75AFEbBqAAAALRlWElmSUkqAAgAAAAGABIBAwABAAAAAQAAABoBBQABAAAAVgAAABsBBQABAAAAXgAAACgBAwABAAAAAgAAABMCAwABAAAAAQAAAGmHBAABAAAAZgAAAAAAAABIAAAAAQAAAEgAAAABAAAABgAAkAcABAAAADAyMTABkQcABAAAAAECAwAAoAcABAAAADAxMDABoAMAAQAAAP//AAACoAQAAQAAAHwBAAADoAQAAQAAAHYAAAAAAAAA012YngAAACV0RVh0ZGF0ZTpjcmVhdGUAMjAyNS0wNC0zMFQxMzoyNzoyOSswMDowMLAvqvoAAAAldEVYdGRhdGU6bW9kaWZ5ADIwMjUtMDQtMzBUMTM6Mjc6MjkrMDA6MDDBchJGAAAAKHRFWHRkYXRlOnRpbWVzdGFtcAAyMDI1LTA0LTMwVDEzOjI3OjMwKzAwOjAwz1V21AAAABV0RVh0ZXhpZjpDb2xvclNwYWNlADY1NTM1M3sAbgAAACB0RVh0ZXhpZjpDb21wb25lbnRzQ29uZmlndXJhdGlvbgAuLi5q8qFkAAAAE3RFWHRleGlmOkV4aWZPZmZzZXQAMTAyc0IppwAAABV0RVh0ZXhpZjpFeGlmVmVyc2lvbgAwMjEwuHZWeAAAABl0RVh0ZXhpZjpGbGFzaFBpeFZlcnNpb24AMDEwMBLUKKwAAAAYdEVYdGV4aWY6UGl4ZWxYRGltZW5zaW9uADM4MI1vHgsAAAAYdEVYdGV4aWY6UGl4ZWxZRGltZW5zaW9uADExOMz9GGgAAAAXdEVYdGV4aWY6WUNiQ3JQb3NpdGlvbmluZwAxrA+AYwAAABF0RVh0aWNjOmNvcHlyaWdodABDQzD91FYtAAAAFHRFWHRpY2M6ZGVzY3JpcHRpb24AYzJjaf8K914AAAAASUVORK5CYII="/>
            @endif
        </div>

        <div class="page">
            <!-- Header -->
            <div class="page-header">
                <b>@lang('admin::app.sales.invoices.invoice-pdf.invoice')</b>
            </div>

            <div class="page-content">


<!-- Invoice Details Section -->
<table class="{{ core()->getCurrentLocale()->direction }}" style="width: 100%; margin-bottom: 5px;">
    <tbody>
        <tr>
            @if (core()->getConfigData('sales.invoice_settings.pdf_print_outs.footer_text'))
            <td style="width: 50%; padding: 8px 10px; border: none; border-radius: 8px;">
                <div style="font-weight: bold; color: #4CAF50; margin-bottom: 10px;">

                </div>
                <div style="background: white; padding: 5px; border-radius: 5px; border: 2px solid #e9ecef;">
                    {!! core()->getConfigData('sales.invoice_settings.pdf_print_outs.footer_text') !!}
                </div>
            </td>
        @endif
            <td style="width: 50%; padding: 8px 10px; border: none; text-align: right;">
                @if (core()->getConfigData('sales.invoice_settings.pdf_print_outs.invoice_id'))
                    <div style="margin-bottom: 12px;">
                        <b style="color: #495057;">
                            @lang('admin::app.sales.invoices.invoice-pdf.invoice-id'):
                        </b>
                        <span style="color: #4CAF50; font-weight: bold;">
                            #{{ $invoice->increment_id ?? $invoice->id }}
                        </span>
                    </div>
                @endif

                @if (core()->getConfigData('sales.invoice_settings.pdf_print_outs.order_id'))
                    <div style="margin-bottom: 12px;">
                        <b style="color: #495057;">
                            @lang('admin::app.sales.invoices.invoice-pdf.order-id'):
                        </b>
                        <span style="color: #4CAF50; font-weight: bold;">
                            #{{ $invoice->order->increment_id }}
                        </span>
                    </div>
                @endif

                <div style="margin-bottom: 12px;">
                    <b style="color: #495057;">
                        @lang('admin::app.sales.invoices.invoice-pdf.date'):
                    </b>
                    <span style="color: #212529;">
                        {{ core()->formatDate($invoice->created_at, 'd.m.Y') }}
                    </span>
                </div>

                <div style="margin-bottom: 12px;">
                    <b style="color: #495057;">
                        @lang('admin::app.sales.invoices.invoice-pdf.order-date'):
                    </b>
                    <span style="color: #212529;">
                        {{ core()->formatDate($invoice->order->created_at, 'H:i') }}
                    </span>
                </div>
            </td>
        </tr>
    </tbody>
</table>

<!-- Section Divider -->
<div style="height: 3px; background: linear-gradient(to right, #4CAF50, #45a049); margin: 5px 0; border-radius: 2px;"></div>

<!-- Store and Payment Information -->
<table class="{{ core()->getCurrentLocale()->direction }}" style="width: 100%; margin-bottom: 5px;">
    <tbody>
        <tr>
            @if (! empty(core()->getConfigData('sales.shipping.origin.country')))
                <td style="width: 50%; padding: 8px 5px; border: none; background: #f8f9fa; border-radius: 8px;">
                    <b style="display: inline-block; margin-bottom: 5px; color: #4CAF50;  ">
                        @lang('admin::app.sales.invoices.invoice-pdf.store-info')
                    </b>

                    <div style="background: white; padding: 5px; border-radius: 5px; line-height: 1.6;">
                        <div style="font-weight: bold; margin-bottom: 8px;">
                        {{ core()->getConfigData('sales.shipping.origin.store_name') }}
                        </div>
                        <div>{{ core()->getConfigData('sales.shipping.origin.address') }}</div>
                        <div>{{ core()->getConfigData('sales.shipping.origin.zipcode') . ' ' . core()->getConfigData('sales.shipping.origin.city') }}</div>
                        <div>{{ core()->getConfigData('sales.shipping.origin.state') . ', ' . core()->getConfigData('sales.shipping.origin.country') }}</div>
                    </div>
                </td>
            @endif

            <td style="width: 50%; padding: 8px 10px; border: none;">
                @if ($invoice->hasPaymentTerm())
                    <div style="margin-bottom: 5px; background: #f8f9fa; padding: 5px; border-radius: 8px;">
                        <b style="display: inline-block; margin-bottom: 8px; color: #4CAF50;">
                            @lang('admin::app.sales.invoices.invoice-pdf.payment-terms'):
                        </b>
                        <div style="color: #495057;">
                            {{ $invoice->getFormattedPaymentTerm() }}
                        </div>
                    </div>
                @endif

                @if (core()->getConfigData('sales.shipping.origin.bank_details'))
                    <div style="background: #f8f9fa; padding: 5px; border-radius: 8px;">
                        <b style="display: inline-block; margin-bottom: 8px; color: #4CAF50;">
                            @lang('admin::app.sales.invoices.invoice-pdf.bank-details'):
                        </b>
                        <div style="color: #495057; line-height: 1.6;">
                            {!! nl2br(core()->getConfigData('sales.shipping.origin.bank_details')) !!}
                        </div>
                    </div>
                @endif
            </td>
        </tr>
    </tbody>
</table>

<!-- Billing & Shipping Address -->
<table class="{{ core()->getCurrentLocale()->direction }}" style="width: 100%; margin-bottom: 5px;">
    <thead>
        <tr>
            @if ($invoice->order->billing_address)
                <th style="width: 50%; background: #4CAF50; color: white; padding: 5px; border-radius: 8px 0 0 0;">
                    <b style=" ">
                        @lang('admin::app.sales.invoices.invoice-pdf.bill-to')
                    </b>
                </th>
            @endif

            @if ($invoice->order->shipping_address)
                <th style="width: 50%; background: #45a049; color: white; padding: 5px; border-radius: 0 8px 0 0;">
                    <b style=" ">
                        @lang('admin::app.sales.invoices.invoice-pdf.ship-to')
                    </b>
                </th>
            @endif
        </tr>
    </thead>

    <tbody>
        <tr>
            @if ($invoice->order->billing_address)
                <td style="width: 50%; padding: 5px; background: #f8f9fa; border-radius: 0 0 0 8px; vertical-align: top;">
                    @if($invoice->order->billing_address->company_name)
                        <div style="font-weight: bold; margin-bottom: 8px; color: #4CAF50;">
                            {{ $invoice->order->billing_address->company_name }}
                        </div>
                    @endif

                    <div style="  font-weight: bold; margin-bottom: 8px;">
                        {{ $invoice->order->billing_address->name }}
                    </div>

                    <div style="line-height: 1.6; color: #495057;">
                        <div>{{ $invoice->order->billing_address->address }}</div>
                        <div>{{ $invoice->order->billing_address->postcode . ' ' . $invoice->order->billing_address->city }}</div>
                        <div>{{ $invoice->order->billing_address->state . ', ' . core()->country_name($invoice->order->billing_address->country) }}</div>
                        <div style="margin-top: 8px;">
                            <b>@lang('admin::app.sales.invoices.invoice-pdf.contact'):</b> {{ $invoice->order->billing_address->phone }}
                        </div>
                    </div>
                </td>
            @endif

            @if ($invoice->order->shipping_address)
                <td style="width: 50%; padding: 5px; background: #f8f9fa; border-radius: 0 0 8px 0; vertical-align: top;">
                    @if($invoice->order->shipping_address->company_name)
                        <div style="font-weight: bold; margin-bottom: 8px; color: #45a049;">
                            {{ $invoice->order->shipping_address->company_name }}
                        </div>
                    @endif

                    <div style="  font-weight: bold; margin-bottom: 8px;">
                        {{ $invoice->order->shipping_address->name }}
                    </div>

                    <div style="line-height: 1.6; color: #495057;">
                        <div>{{ $invoice->order->shipping_address->address }}</div>
                        <div>{{ $invoice->order->shipping_address->postcode . ' ' . $invoice->order->shipping_address->city }}</div>
                        <div>{{ $invoice->order->shipping_address->state . ', ' . core()->country_name($invoice->order->shipping_address->country) }}</div>
                        <div style="margin-top: 8px;">
                            <b>@lang('admin::app.sales.invoices.invoice-pdf.contact'):</b> {{ $invoice->order->shipping_address->phone }}
                        </div>
                    </div>
                </td>
            @endif
        </tr>
    </tbody>
</table>
              <!-- Payment & Shipping Methods -->
<table class="{{ core()->getCurrentLocale()->direction }}" style="width: 100%; border-collapse: collapse; margin: 5px 0; bborder-radius: 8px; overflow: hidden;">
    <thead>
        <tr>
            <th style="width: 50%; background: #4CAF50; color: white; padding: 5px; border-radius: 8px 0 0 0;">
                <b>
                    @lang('admin::app.sales.invoices.invoice-pdf.payment-method')
                </b>
            </th>

            @if ($invoice->order->shipping_address)
                <th style="width: 50%; background: #4CAF50; color: white; padding: 5px; border-radius: 0 8px 0 0;  text-align: left;">
                    <b>
                        @lang('admin::app.sales.invoices.invoice-pdf.shipping-method')
                    </b>
                </th>
            @endif
        </tr>
    </thead>

    <tbody>
        <tr>
            <td style="width: 50%; padding: 5px; background: #f8f9fa; border-radius: 0 0 0 8px; vertical-align: top;">



                <div >
                    <div style="  font-weight: bold; margin-bottom: 5px; color: #2c3e50;">
                        {{ core()->getConfigData('sales.payment_methods.' . $invoice->order->payment->method . '.title') }}
                    </div>

                    @php $additionalDetails = \Webkul\Payment\Payment::getAdditionalDetails($invoice->order->payment->method); @endphp

                    @if (! empty($additionalDetails))
                        <div style="margin-top: 5px; padding-top: 5px; border-top: 1px solid #e9ecef; line-height: 1.6;">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="font-weight: 600; color: #4CAF50;">{{ $additionalDetails['title'] }}:</span>
                                <span style="font-weight: 500; color: #495057;">{{ $additionalDetails['value'] }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </td>

            @if ($invoice->order->shipping_address)
                <td style="width: 50%; padding: 5px; background: #f8f9fa;  vertical-align: top;">


                    <div >
                        <div style=" font-weight: bold; color: #2c3e50; line-height: 1.6;">
                            {{ $invoice->order->shipping_title }}
                        </div>
                    </div>
                </td>
            @endif
        </tr>
    </tbody>
</table>

<div class="items">
    <table class="{{ core()->getCurrentLocale()->direction }}" style="width: 100%; border-collapse: collapse; margin: 5px 0; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden;">
        <thead>
            <tr>
                <th style="background: #4CAF50; color: white; padding: 5px;  text-align: left; font-weight: bold; border-right: 1px solid rgba(255,255,255,0.2);">
                    @lang('admin::app.sales.invoices.invoice-pdf.sku')
                </th>

                <th style="background: #4CAF50; color: white; padding: 5px; text-align: left; font-weight: bold; border-right: 1px solid rgba(255,255,255,0.2);">
                    @lang('admin::app.sales.invoices.invoice-pdf.product-name')
                </th>

                <th style="background: #4CAF50; color: white; padding: 5px;  text-align: center; font-weight: bold; border-right: 1px solid rgba(255,255,255,0.2);">
                    @lang('admin::app.sales.invoices.invoice-pdf.price')
                </th>

                <th style="background: #4CAF50; color: white; padding: 5px;  text-align: center; font-weight: bold; border-right: 1px solid rgba(255,255,255,0.2);">
                    @lang('admin::app.sales.invoices.invoice-pdf.qty')
                </th>

                <th style="background: #4CAF50; color: white; padding: 5px;  text-align: right; font-weight: bold;">
                    @lang('admin::app.sales.invoices.invoice-pdf.subtotal')
                </th>
            </tr>
        </thead>

        <tbody>
            @foreach ($invoice->items as $item)
                <tr style="border-bottom: 1px solid #e9ecef; transition: all 0.3s ease;">
                    <td style="padding: 5px; background: white; border-right: 1px solid #f1f3f4; vertical-align: top;">
                        <div style="font-family: 'Courier New', monospace;  color: #6c757d; background: #f8f9fa; padding: 6px 10px; border-radius: 4px; border-left: 3px solid #4CAF50;">
                            {{ $item->getTypeInstance()->getOrderedItem($item)->sku }}
                        </div>
                    </td>

                    <td style="padding: 5px; background: white; border-right: 1px solid #f1f3f4; vertical-align: top;">
                        <div style="font-weight: bold; color: #2c3e50; margin-bottom: 8px; ">
                            {{ $item->name }}
                        </div>

                        @if (isset($item->additional['attributes']))
                            <div style="margin-top: 10px; padding: 5px; background: #f8f9fa; border-radius: 6px; border-left: 3px solid #17a2b8;">
                                @foreach ($item->additional['attributes'] as $attribute)
                                    @if (
                                        ! isset($attribute['attribute_type'])
                                        || $attribute['attribute_type'] !== 'file'
                                    )
                                        <div style="margin-bottom: 4px; line-height: 1.4;">
                                            <b style="color: #17a2b8; ">{{ $attribute['attribute_name'] }} :</b>
                                            <span style="color: #495057; ">{{ $attribute['option_label'] }}</span>
                                        </div>
                                    @else
                                        <div style="margin-bottom: 4px; line-height: 1.4;">
                                            <b style="color: #17a2b8; ">{{ $attribute['attribute_name'] }} :</b>
                                            <a
                                                href="{{ Storage::url($attribute['option_label']) }}"
                                                style="color: #007bff; text-decoration: none; font-weight: 500;"
                                                download="{{ File::basename($attribute['option_label']) }}"
                                            >
                                                {{ File::basename($attribute['option_label']) }}
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </td>

                    <td style="padding: 5px; background: white; border-right: 1px solid #f1f3f4; vertical-align: top; text-align: center;">
                        <div style="font-weight: bold; color: #2c3e50;  ">
                            @if (core()->getConfigData('sales.taxes.sales.display_prices') == 'including_tax')
                                {!! core()->formatBasePrice($item->base_price_incl_tax, true) !!}
                            @elseif (core()->getConfigData('sales.taxes.sales.display_prices') == 'both')
                                {!! core()->formatBasePrice($item->base_price_incl_tax, true) !!}

                                <div style="color: #6c757d; margin-top: 4px; font-weight: normal;">
                                    @lang('admin::app.sales.invoices.invoice-pdf.excl-tax')
                                    <span style="font-weight: 500;">
                                        {{ core()->formatPrice($item->base_price) }}
                                    </span>
                                </div>
                            @else
                                {!! core()->formatBasePrice($item->base_price, true) !!}
                            @endif
                        </div>
                    </td>

                    <td style="padding: 5px; background: white; border-right: 1px solid #f1f3f4; vertical-align: top; text-align: center;">
                        <div style="display: inline-block; background: #e8f5e8; color: #2e7d32; padding: 6px 12px; border-radius: 20px; font-weight: bold;  min-width: 20px;">
                            {{ $item->qty }}
                        </div>
                    </td>

                    <td style="padding: 5px; background: white; vertical-align: top; text-align: right;">
                        <div style="font-weight: bold; color: #2c3e50;  ">
                            @if (core()->getConfigData('sales.taxes.sales.display_subtotal') == 'including_tax')
                                {!! core()->formatBasePrice($item->base_total_incl_tax, true) !!}
                            @elseif (core()->getConfigData('sales.taxes.sales.display_subtotal') == 'both')
                                {!! core()->formatBasePrice($item->base_total_incl_tax, true) !!}

                                <div style=" color: #6c757d; margin-top: 4px; font-weight: normal;">
                                    @lang('admin::app.sales.invoices.invoice-pdf.excl-tax')
                                    <span style="font-weight: 500;">
                                        {{ core()->formatPrice($item->base_total) }}
                                    </span>
                                </div>
                            @else
                                {!! core()->formatBasePrice($item->base_total, true) !!}
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
                <!-- Summary Table -->
                <div class="summary">
                    <table class="{{ core()->getCurrentLocale()->direction }}">
                        <tbody>
                            @if (core()->getConfigData('sales.taxes.sales.display_subtotal') == 'including_tax')
                                <tr>
                                    <td>@lang('admin::app.sales.invoices.invoice-pdf.subtotal')</td>
                                    <td>-</td>
                                    <td>{!! core()->formatBasePrice($invoice->base_sub_total_incl_tax, true) !!}</td>
                                </tr>
                            @elseif (core()->getConfigData('sales.taxes.sales.display_subtotal') == 'both')
                                <tr>
                                    <td>@lang('admin::app.sales.invoices.invoice-pdf.subtotal-incl-tax')</td>
                                    <td>-</td>
                                    <td>{!! core()->formatBasePrice($invoice->base_sub_total_incl_tax, true) !!}</td>
                                </tr>

                                <tr>
                                    <td>@lang('admin::app.sales.invoices.invoice-pdf.subtotal-excl-tax')</td>
                                    <td>-</td>
                                    <td>{!! core()->formatBasePrice($invoice->base_sub_total, true) !!}</td>
                                </tr>
                            @else
                                <tr>
                                    <td>@lang('admin::app.sales.invoices.invoice-pdf.subtotal')</td>
                                    <td>-</td>
                                    <td>{!! core()->formatBasePrice($invoice->base_sub_total, true) !!}</td>
                                </tr>
                            @endif

                            @if (core()->getConfigData('sales.taxes.sales.display_shipping_amount') == 'including_tax')
                                <tr>
                                    <td>@lang('admin::app.sales.invoices.invoice-pdf.shipping-handling')</td>
                                    <td>-</td>
                                    <td>{!! core()->formatBasePrice($invoice->base_shipping_amount_incl_tax, true) !!}</td>
                                </tr>
                            @elseif (core()->getConfigData('sales.taxes.sales.display_shipping_amount') == 'both')
                                <tr>
                                    <td>@lang('admin::app.sales.invoices.invoice-pdf.shipping-handling-incl-tax')</td>
                                    <td>-</td>
                                    <td>{!! core()->formatBasePrice($invoice->base_shipping_amount_incl_tax, true) !!}</td>
                                </tr>

                                <tr>
                                    <td>@lang('admin::app.sales.invoices.invoice-pdf.shipping-handling-excl-tax')</td>
                                    <td>-</td>
                                    <td>{!! core()->formatBasePrice($invoice->base_shipping_amount, true) !!}</td>
                                </tr>
                            @else
                                <tr>
                                    <td>@lang('admin::app.sales.invoices.invoice-pdf.shipping-handling')</td>
                                    <td>-</td>
                                    <td>{!! core()->formatBasePrice($invoice->base_shipping_amount, true) !!}</td>
                                </tr>
                            @endif

                            <tr>
                                <td>@lang('admin::app.sales.invoices.invoice-pdf.tax')</td>
                                <td>-</td>
                                <td>{!! core()->formatBasePrice($invoice->base_tax_amount, true) !!}</td>
                            </tr>

                            <tr>
                                <td>@lang('admin::app.sales.invoices.invoice-pdf.discount')</td>
                                <td>-</td>
                                <td>{!! core()->formatBasePrice($invoice->base_discount_amount, true) !!}</td>
                            </tr>

                            <tr>
                                <td style="border-top: 1px solid #FFFFFF;">
                                    <b>@lang('admin::app.sales.invoices.invoice-pdf.grand-total')</b>
                                </td>
                                <td style="border-top: 1px solid #FFFFFF;">-</td>
                                <td style="border-top: 1px solid #FFFFFF;">
                                    <b>{!! core()->formatBasePrice($invoice->base_grand_total, true) !!}</b>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Footer Content
                @if (core()->getConfigData('sales.invoice_settings.pdf_print_outs.footer_text'))
                    <div>
                        {!! core()->getConfigData('sales.invoice_settings.pdf_print_outs.footer_text') !!}
                    </div>
                @endif -->
            </div>
        </div>
    </body>
</html>
