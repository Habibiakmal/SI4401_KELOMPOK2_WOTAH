@extends('layout/template')

@section('contents')
    <div class="row">
        <div class="col-12">
            <div class="card rounded-border" id="orderList">
                <div class="card-header border-0 rounded-border">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Generate Tagihan</h5>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form method="GET">
                        <div class="row g-3">
                            <div class="col-xl-2 col-md-3 col-sm-4">
                                <a href="/admin/bill?user_id={{$user_id}}&year={{$year}}" class="btn btn-secondary add-btn rounded-pill"><i class="ri-add-line align-bottom me-1"></i> Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if (session('status'))
        <div class="row">
            <div class="col-md-12 mb-3">
                {!! session('status') !!}
            </div>
        </div>
    @endif

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="/admin/bill/insert/{{$user_id}}/{{$year}}/{{$month}}">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <table style="width:50%">
                                    <tr>
                                        <td>
                                            <small>Nama Lengkap</small><br>
                                            <b>{{$user->fullname}}</b>
                                        </td>
                                        <td>
                                            <small>Email</small><br>
                                            <b>{{$user->email}}</b>
                                        </td>
                                        <td>
                                            <small>Nomor Handphone</small><br>
                                            <b>{{$user->phone}}</b>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <table class="table">
                                    <tr>
                                        <th style="width:20%">Penggunaan Air (m3)</th>
                                        <td>
                                            <input type="number" required name="usage" class="form-control" autocomplete="off">
                                        </td>
                                    </tr>

                                    <tr>
                                        <th style="width:20%">Biaya Beban Tetap Air (Rp)</th>
                                        <td>
                                            <input type="number" required name="amount_per_usage" class="form-control" autocomplete="off">
                                        </td>
                                    </tr>

                                    <tr>
                                        <th style="width:20%">Biaya Pemeliharaan Meter (Rp)</th>
                                        <td>
                                            <input type="number" required name="maintenance_price" class="form-control" autocomplete="off">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <button class="btn btn-primary rounded-pill">Buat Tagihan Sekarang</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection