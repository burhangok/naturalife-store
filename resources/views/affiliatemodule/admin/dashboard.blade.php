@extends('layouts.admin-layout')

@section('title', 'Temsilcilik Modülü Yönetim Paneli')

@section('content')
<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">

                    </div>
                    <h2 class="page-title">
                        Özet Bilgiler
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('admin.affiliatemodule.admin.dashboard') }}" class="btn btn-primary" >
                            <i class="fas fa-sync-alt me-1"></i>
                            Yenile
                        </a>
                        <a href="{{ route('admin.affiliatemodule.admin.commissions.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-list me-1"></i>
                            Komisyonlar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <!-- İstatistik Kartları -->
            <div class="row row-deck row-cards">
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Toplam Temsilci</div>
                            </div>
                            <div class="h1 mb-3">{{ number_format($totalAffiliates) }}</div>
                            <div class="d-flex mb-2">
                                <div class="flex-fill">
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-primary" style="width: 100%" role="progressbar"></div>
                                    </div>
                                </div>
                                <div class="ms-2">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Son 7 Gün Satış</div>
                            </div>
                            <div class="h1 mb-3">₺{{ number_format($lastWeekSales, 2) }}</div>
                            <div class="d-flex mb-2">
                                <div class="flex-fill">
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-success" style="width: 85%" role="progressbar"></div>
                                    </div>
                                </div>
                                <div class="ms-2">
                                    <small class="text-white bg-success rounded px-2 py-1">+{{ $additionalStats['thisWeekCommissionCount'] }} sipariş</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Son 7 Gün Komisyon</div>
                            </div>
                            <div class="h1 mb-3">₺{{ number_format($lastWeekCommission, 2) }}</div>
                            <div class="d-flex mb-2">
                                <div class="flex-fill">
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-warning" style="width: 65%" role="progressbar"></div>
                                    </div>
                                </div>
                                <div class="ms-2">
                                    <small class="text-white bg-warning rounded px-2 py-1">7 gün</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Bugünkü Komisyon</div>
                            </div>
                            <div class="h1 mb-3">₺{{ number_format($additionalStats['todayCommissions'], 2) }}</div>
                            <div class="d-flex mb-2">
                                <div class="flex-fill">
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-info" style="width: 45%" role="progressbar"></div>
                                    </div>
                                </div>
                                <div class="ms-2">
                                    <small class="text-white bg-info rounded px-2 py-1">Bugün</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row row-deck row-cards mt-4">
                <!-- Haftalık Komisyon Grafiği -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Son 7 Günlük Komisyon Trendi</h3>
                        </div>
                        <div class="card-body">
                            <div id="chart-commission-trend" style="height: 300px;"></div>
                        </div>
                    </div>
                </div>

                <!-- Bu Ay İstatistikleri -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Bu Ay Özeti</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <div class="text-muted small">Bu Ay Toplam Komisyon</div>
                                        <div class="h3 text-success">₺{{ number_format($additionalStats['thisMonthCommission'], 2) }}</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <div class="text-muted small">Genel Toplam Komisyon</div>
                                        <div class="h3 text-primary">₺{{ number_format($additionalStats['totalCommissions'], 2) }}</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <div class="text-muted small">Toplam Temsilci (Tümü)</div>
                                        <div class="h3 text-info">{{ number_format($additionalStats['totalAffiliatesAll']) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row row-deck row-cards mt-4">
                <!-- Seviye Bazında Komisyon Dağılımı -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Seviye Bazında Komisyon Dağılımı</h3>
                        </div>
                        <div class="card-body">
                            @foreach($additionalStats['commissionsByLevel'] as $level)
                            <div class="d-flex align-items-center mb-3">
                                <div class="me-3">
                                    <span class="text-white bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                        {{ $level->level }}
                                    </span>
                                </div>
                                <div class="flex-fill">
                                    <div class="font-weight-medium">Seviye {{ $level->level }}</div>
                                    <div class="text-muted small">{{ $level->count }} komisyon</div>
                                </div>
                                <div class="ms-auto">
                                    <div class="font-weight-medium">₺{{ number_format($level->total_amount, 2) }}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- En Başarılı Affiliateler -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">En Çok Kazanan Temsilciler</h3>
                        </div>
                        <div class="card-body">
                            @foreach($additionalStats['topEarningAffiliates'] as $index => $affiliate)
                            <div class="d-flex align-items-center mb-3">
                                <div class="me-3">
                                    <span class="text-white bg-success rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                        {{ $index + 1 }}
                                    </span>
                                </div>
                                <div class="flex-fill">
                                    <div class="font-weight-medium">{{ $affiliate->affiliate->getFullName() ?? 'Bilinmeyen' }}</div>
                                    <div class="text-muted small">{{ $affiliate->affiliate->affiliate_code ?? '' }}</div>
                                </div>
                                <div class="ms-auto">
                                    <div class="font-weight-medium text-success">₺{{ number_format($affiliate->total_earnings, 2) }}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Son Komisyonlar Tablosu -->
            <div class="row row-deck row-cards mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Son 10 Komisyon</h3>
                            <div class="card-actions">
                                <a href="{{ route('admin.affiliatemodule.admin.commissions.index') }}" class="btn btn-sm btn-outline-primary">
                                    Tümünü Gör
                                </a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-vcenter card-table">
                                    <thead>
                                        <tr>
                                            <th>TEMSİLCİ</th>
                                            <th>SİPARİŞ ID</th>
                                            <th>SEVİYE</th>
                                            <th>KOMİSYON TUTARI</th>
                                            <th>ORAN</th>
                                            <th>REFERANS</th>
                                            <th>TARİH</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentCommissions as $commission)
                                        <tr>
                                            <td>
                                                <div class="d-flex py-1 align-items-center">
                                                    <div class="flex-fill">
                                                        <div class="font-weight-medium">{{ $commission->affiliate->getFullName() ?? '-' }}</div>
                                                        <div class="text-muted small">{{ $commission->affiliate->affiliate_code ?? '' }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-muted">
                                                <strong>#{{ $commission->order_id }}</strong>
                                            </td>
                                            <td>
                                                <span class="text-white bg-info rounded px-2 py-1">
                                                {{ $commission->level }}
                                                </span>
                                            </td>
                                            <td class="text-success font-weight-medium">
                                                ₺{{ number_format($commission->amount, 2) }}
                                            </td>
                                            <td>
                                                <span class="text-white bg-warning rounded px-2 py-1">
                                                    %{{ number_format($commission->percentage, 1) }}
                                                </span>
                                            </td>
                                            <td class="text-muted">
                                                {{ $commission->fromAffiliate->getFullName() ?? 'Direkt' }}
                                            </td>
                                            <td class="text-muted">
                                                {{ $commission->created_at->format('d.m.Y H:i') }}
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-4">
                                                Henüz komisyon bulunmuyor
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.44.0/apexcharts.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Komisyon trendi grafiği
    const chartData = @json($additionalStats['dailyCommissions']);

    const options = {
        chart: {
            type: 'line',
            height: 300,
            toolbar: {
                show: false
            }
        },
        series: [{
            name: 'Komisyon',
            data: chartData.map(item => ({
                x: item.date,
                y: parseFloat(item.total_amount)
            }))
        }],
        stroke: {
            curve: 'smooth',
            width: 3
        },
        colors: ['#206bc4'],
        xaxis: {
            type: 'datetime',
            labels: {
                format: 'dd MMM'
            }
        },
        yaxis: {
            labels: {
                formatter: function(value) {
                    return '₺' + value.toFixed(2);
                }
            }
        },
        tooltip: {
            y: {
                formatter: function(value) {
                    return '₺' + value.toFixed(2);
                }
            }
        },
        grid: {
            borderColor: '#e9ecef'
        }
    };

    const chart = new ApexCharts(document.querySelector("#chart-commission-trend"), options);
    chart.render();
});

function refreshDashboard() {
    const btn = event.target;
    const originalHtml = btn.innerHTML;

    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Yenileniyor...';
    btn.disabled = true;

    fetch('{{ route("admin.affiliatemodule.admin.dashboard") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Veriler yenilenirken hata oluştu!');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Bir hata oluştu!');
    })
    .finally(() => {
        btn.innerHTML = originalHtml;
        btn.disabled = false;
    });
}
</script>
@endsection

@push('scripts')
<script>
    // Burada dashboard için gerekli JavaScript kodları yer alacak
    document.addEventListener("DOMContentLoaded", function() {
        // Grafik yükleme kodları buraya gelebilir
        console.log("Dashboard sayfası yüklendi!");
    });
</script>
@endpush
