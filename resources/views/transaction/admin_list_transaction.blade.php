@extends('layout/template')

@section('contents')
    @if (session('status'))
        <div class="row">
            <div class="col-md-12 mb-3">
                {!! session('status') !!}
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card rounded-border" id="orderList">
                <div class="card-header border-0 rounded-border">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Daftar Transaksi</h5>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form method="GET">
                        <div class="row g-3">
                            <div class="col-xl-2 col-md-3 col-sm-4">
                                <div>
                                    <select class="form-control" data-choices data-choices-sorting-false data-choices-search-false name="status">
                                        <option value="">Pilih Status</option>
                                        <option value="all" {{ Request::get("status") == 'all' ? 'selected' : '' }}>Semua</option>
                                        <option value="pending" {{ Request::get("status") == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="waiting_payment" {{ Request::get("status") == 'waiting_payment' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                                        <option value="verify" {{ Request::get("status") == 'verify' ? 'selected' : '' }}>Verifikasi</option>
                                        <option value="completed" {{ Request::get("status") == 'completed' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xl-1 col-md-2 col-sm-4">
                                <div>
                                    <button type="submit" class="btn btn-outline-primary rounded-pill w-100"> <i class="ri-equalizer-fill me-1 align-bottom"></i>
                                        Cari
                                    </button>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </form>
                </div>
            </div>

            <div class="card rounded-border mt-4">
                <div class="card-body">
                    <div class="mb-3">
                        <div class="table-responsive table-card mb-1 rounded-border">
                            <table class="table table-nowrap align-middle">
                                <thead class="text-muted table-primary">
                                    <tr class="text-uppercase">
                                        <th style="width:5%">No</th>
                                        <th style="width:30%">Transaksi</th>
                                        <th>Jenis</th>
                                        <th>Waktu Generate</th>
                                        <th class="text-center" style="width: 15%;">Status</th>
                                        <th>Total</th>
                                        <th style="width:10%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($list as $row)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                {{ $row->transaction_code }}<br>
                                                <small class="text-muted">
                                                    {{$row->fullname}} <br>
                                                    {{$row->email." / ".$row->phone}}
                                                </small>
                                            </td>
                                            <td>{{ transactionType($row->type) }}</td>
                                            <td>{{ indonesianDate($row->created_at, true) }}</td>
                                            <td class="text-center">{!! transactionStatus($row->status) !!}</td>
                                            <td class="text-end">{{ formatRp($row->amount) }}</td>
                                            <td class="text-end">
                                                <a class="btn btn-outline-secondary rounded-pill" href="/admin/transaction/{{ $row->id }}">Lihat</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection