@extends('layouts.shop-layout')

@section('title', 'Alt Temscilcilerim')

@section('content')
<div class="page-wrapper">


    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <!-- Statistics Cards -->
            <div class="row row-deck row-cards mb-4">
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Toplam Temsilci</div>
                                <div class="ms-auto lh-1">

                                </div>
                            </div>
                            <div class="d-flex align-items-baseline">
                                <div class="h1 mb-0 me-2">{{ $downlineAffiliates->count() ?? '' }}</div>
                                <div class="me-auto">

                                </div>
                            </div>
                        </div>
                        <div id="chart-revenue-bg" class="chart-sm"></div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Kazanılan Komisyon</div>
                            </div>
                            <div class="d-flex align-items-baseline">
                                <div class="h1 mb-3 me-2">{{ $totalCommissions ?? '' }}</div>
                                <div class="me-auto">
                                    <span class="text-green d-inline-flex align-items-center lh-1">
                                        12% <i class="fas fa-trending-up ms-1"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-primary" style="width: 75%" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                    <span class="visually-hidden">75% Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Bu Ay Kayıt</div>
                            </div>
                            <div class="d-flex align-items-baseline">
                                <div class="h1 mb-3 me-2">{{ $thisMonthRegistrations ?? '6' }}</div>
                                <div class="me-auto">
                                    <span class="text-yellow d-inline-flex align-items-center lh-1">
                                        0% <i class="fas fa-minus ms-1"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-yellow" style="width: 25%" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                    <span class="visually-hidden">25% Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Ortalama Satış</div>
                            </div>
                            <div class="d-flex align-items-baseline">
                                <div class="h1 mb-3 me-2">₺{{ number_format($averageSales ?? 45780, 0, ',', '.') }}</div>
                                <div class="me-auto">
                                    <span class="text-green d-inline-flex align-items-center lh-1">
                                        15% <i class="fas fa-trending-up ms-1"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Representatives Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Alt Temsilcilerim</h3>
                            <div class="card-actions">
                                <div class="dropdown">

                                </div>
                            </div>
                        </div>


                        <div class="card-body p-0">

                            @if ($downlineAffiliates->isEmpty())
                                <div class="p-4 text-center text-muted">
                                    Henüz alt temsilciniz bulunmuyor.
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0 dataListTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Temsilci</th>
                                                <th>Seviye</th>
                                                <th>Kayıt Tarihi</th>
                                                <th>Alt Üye</th>
                                                <th>Toplam Satış</th>
                                                <th>Kazandırdığı</th>
                                                <th>Detay</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($downlineAffiliates as $downlineAffiliate)
                                                <tr>
                                                    <td>
                                                        <div>
                                                            <div class="fw-bold">
                                                                {{ $downlineAffiliate->customer->first_name . ' ' . $downlineAffiliate->customer->last_name }}
                                                            </div>
                                                            <small
                                                                class="text-muted">{{ $downlineAffiliate->affiliate_code }}</small>
                                                        </div>
                                                    </td>
                                                    <td><span
                                                            class="badge bg-primary  text-white">{{ $downlineAffiliate->level }}</span>
                                                    </td>
                                                    <td>{{ $downlineAffiliate->joined_at?->format('d.m.Y') }}</td>
                                                    <td>{{ $downlineAffiliate->children->count() }}</td>
                                                    <td>{{ core()->formatPrice($downlineAffiliate->customer->orders->whereNotIn('status', ['canceled', 'closed'])->sum('base_grand_total_invoiced')) }}
                                                    </td>
                                                    <td class="text-success fw-bold">
                                                        €{{ number_format($downlineAffiliate->generatedCommissions()->sum('amount'), 2) }}
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('shop.customers.affiliatemodule.profile', $downlineAffiliate->id) }}"
                                                            class="btn btn-icon btn-outline-primary me-1">
                                                            <i class="fas fa-search"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
