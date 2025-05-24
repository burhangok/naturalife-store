<x-admin::layouts>

    <x-slot:title>
      Komisyon Detay
    </x-slot>



<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Komisyon Detayı #{{ $commission->id }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.commissions.index') }}" class="btn btn-sm btn-default">
                            <i class="fas fa-arrow-left mr-1"></i> Listeye Dön
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="fas fa-user"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Affiliate Bilgisi</span>
                                    <span class="info-box-number">
                                        @if($commission->affiliate)
                                            <a href="{{ route('admin.affiliates.edit', $commission->affiliate_id) }}">
                                                {{ $commission->affiliate->name ?? $commission->affiliate->user->name ?? 'ID: '.$commission->affiliate_id }}
                                            </a>
                                        @else
                                            Affiliate Silinmiş
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="fas fa-shopping-cart"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Sipariş Bilgisi</span>
                                    <span class="info-box-number">
                                        @if($commission->order)
                                            <a href="{{ route('admin.sales.orders.view', $commission->order_id) }}">
                                                #{{ $commission->order_id }} - {{ number_format($commission->order->total, 2) }} TL
                                            </a>
                                        @else
                                            Sipariş Silinmiş
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width: 200px;">Komisyon ID</th>
                                        <td>{{ $commission->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Alt Affiliate</th>
                                        <td>
                                            @if($commission->fromAffiliate)
                                                <a href="{{ route('admin.affiliates.edit', $commission->from_affiliate_id) }}">
                                                    {{ $commission->fromAffiliate->name ?? $commission->fromAffiliate->user->name ?? 'ID: '.$commission->from_affiliate_id }}
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Seviye</th>
                                        <td>{{ $commission->level }}. Seviye</td>
                                    </tr>
                                    <tr>
                                        <th>Komisyon Tutarı</th>
                                        <td>{{ number_format($commission->amount, 2) }} TL</td>
                                    </tr>
                                    <tr>
                                        <th>Komisyon Oranı</th>
                                        <td>%{{ number_format($commission->percentage, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Durum</th>
                                        <td>
                                            <span class="badge badge-{{
                                                $commission->status == 'pending' ? 'warning' :
                                                ($commission->status == 'approved' ? 'info' :
                                                ($commission->status == 'paid' ? 'success' : 'danger'))
                                            }}">
                                                {{
                                                    $commission->status == 'pending' ? 'Beklemede' :
                                                    ($commission->status == 'approved' ? 'Onaylandı' :
                                                    ($commission->status == 'paid' ? 'Ödendi' : 'Reddedildi'))
                                                }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Açıklama</th>
                                        <td>{{ $commission->description ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Ödeme Tarihi</th>
                                        <td>{{ $commission->paid_at ? $commission->paid_at->format('d.m.Y H:i') : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Oluşturulma Tarihi</th>
                                        <td>{{ $commission->created_at->format('d.m.Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Güncellenme Tarihi</th>
                                        <td>{{ $commission->updated_at->format('d.m.Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Komisyon Durumunu Güncelle</h3>
                                </div>
                                <form method="POST" action="{{ route('admin.commissions.update', $commission) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Durum</label>
                                            <select name="status" class="form-control">
                                                <option value="pending" {{ $commission->status == 'pending' ? 'selected' : '' }}>Beklemede</option>
                                                <option value="approved" {{ $commission->status == 'approved' ? 'selected' : '' }}>Onaylandı</option>
                                                <option value="paid" {{ $commission->status == 'paid' ? 'selected' : '' }}>Ödendi</option>
                                                <option value="rejected" {{ $commission->status == 'rejected' ? 'selected' : '' }}>Reddedildi</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Açıklama</label>
                                            <textarea name="description" class="form-control" rows="3" placeholder="Açıklama">{{ $commission->description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Güncelle</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>

</x-admin::layouts>
