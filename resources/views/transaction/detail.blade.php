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
                        <h5 class="card-title mb-0 flex-grow-1">Detail Transaksi</h5>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form method="GET">
                        <div class="row g-3">
                            <div class="col-xl-2 col-md-3 col-sm-4">
                                <a href="/dashboard/transaction" class="btn btn-secondary add-btn rounded-pill"><i class="ri-add-line align-bottom me-1"></i> Kembali</a>
                            </div>
                            <div class="col-xl-10 col-md-9 col-sm-8">
                                <table width="100%">
                                    <tr>
                                        <td>
                                            <small>Kode Transaksi</small> &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<br>
                                            <b>{{ $transaction->transaction_code }}</b>
                                        </td>
                                        <td>
                                            <small>Jenis</small>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<br>
                                            <b>{{ transactionType($transaction->type) }}</b>
                                        </td>
                                        <td>
                                            <small>Status Pembayaran</small>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<br>
                                            <b>{!! transactionStatus($transaction->status) !!}</b>
                                        </td>
                                        <td>
                                            <small>Total Bayar</small>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<br>
                                            <b>{!! formatRp($transaction->amount) !!}</b>
                                        </td>
                                        <td class="text-end">
                                            @if(Session::get('user')->role == 'user')
                                                @if($transaction->status == 'waiting_payment')
                                                    <button type="button" class="btn btn-success add-btn rounded-pill" data-bs-toggle="modal" id="create-btn" data-bs-target="#addModal"><i class="ri-add-line align-bottom me-1"></i> Lakukan Pembayaran</button>
                                                @elseif($transaction->status == 'verify')
                                                    <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal" id="create-btn" data-bs-target="#paymentProof"><i class="ri-add-line align-bottom me-1"></i> Lihat Bukti Pembayaran</button>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if($transaction->type == 'bill')
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th style="width:20%" class="bg-light">Penggunaan Air</th>
                                <td> {{ $bill->usage }} m3</td>
                            </tr>
                            <tr>
                                <th style="width:20%" class="bg-light">Biaya Beban Tetap Air</th>
                                <td> {{ formatRp($bill->amount_per_usage) }}</td>
                            </tr>
                            <tr>
                                <th style="width:20%" class="bg-light">Total Beban Biaya Penggunaan Air</th>
                                <td> {{ formatRp($bill->amount_per_usage * $bill->usage) }}</td>
                            </tr>
                            <tr>
                                <th style="width:20%" class="bg-light">Biaya Pemeliharan Meter</th>
                                <td> {{ formatRp($bill->maintenance_price) }}</td>
                            </tr>
                            <tr>
                                <th style="width:20%" class="bg-light">PPN 10%</th>
                                <td> {{ formatRp($bill->ppn_price) }}</td>
                            </tr>
                            <tr>
                                <th style="width:20%" class="bg-light">Total Biaya</th>
                                <td> {{ formatRp($bill->total_amount) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    @elseif($transaction->type == 'service')
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th style="width:20%" class="bg-light">Layanan</th>
                                <td> {{ $transaction->service_used_by_user }} m3</td>
                            </tr>
                            <tr>
                                <th style="width:20%" class="bg-light">Permasalahan Pelanggan</th>
                                <td> {!!nl2br(str_replace(" ", " &nbsp;", $transaction->issue_description))!!}</td>
                            </tr>
                            <tr>
                                <th style="width:20%" class="bg-light">Catatan Teknisi</th>
                                <td> {!!nl2br(str_replace(" ", " &nbsp;", $transaction->technition_note))!!}</td>
                            </tr>
                            <tr>
                                <th style="width:20%" class="bg-light">Total Biaya</th>
                                <td> {{ formatRp($transaction->amount) }}</td>
                            </tr>

                             @if($transaction->status == 'pending')
                                <tr>
                                    <td></td>
                                    <td>
                                        <div class="alert alert-info mt-2">
                                            <h6><b>INFO</b></h6>
                                            Silahkan tunggu teknisi kami tiba di lokasi anda, nominal pembayaran akan muncul setelah teknisi selesai melakukan layanan
                                        </div>
                                    </td>
                                </tr>

                            @elseif($transaction->status == 'waiting_payment')
                                <tr>
                                    <td></td>
                                    <td>
                                        <div class="alert alert-warning mt-2">
                                            <h6><b>INFO</b></h6>
                                            Harap segera lunasi pembayaran, klik tombol <b>Lakukan Pembayaran</b> yang ada pada pojok kanan atas halaman
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif  

    @if(Session::get('user')->role == 'user')
        @if($transaction->status == 'verify')
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-warning mt-4">
                        <h6><b>INFO</b></h6>
                        Silahkan tunggu verifikasi pembayaran melalui admin kami
                    </div>
                </div>
            </div>
        @endif
    @endif

    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded-border">
                <div class="modal-header rounded-border bg-light p-3">
                    <h5 class="modal-title" id="exampleModalLabel">Lakukan Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                </div>

                    <div class="modal-body pt-0">
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <div class="alert alert-primary">
                                    <h6><b>METODE PEMBAYARAN</b></h6>
                                    <small>Harap lakukan pembayaran pada nomor rekening dibawah ini :</small><br>
                                    <table>
                                        <tr>
                                            <th style="width:200px">Bank</th>
                                            <td>BCA (Bank Central Asia)</td>
                                        </tr>
                                        <tr>
                                            <th>Nomor Rekening</th>
                                            <td>2341155324</td>
                                        </tr>
                                        <tr>
                                            <th>a/n</th>
                                            <td>John Doe</td>
                                        </tr>
                                        <tr>
                                            <th>Nominal</th>
                                            <td>{{formatRp($transaction->amount)}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="/dashboard/transaction/{{ $transaction->id }}/upload_payment" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6>Kirim Bukti Transfer</h6>
                                    <input type="file" required name="payment_proof" class="btn btn-light">
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-primary rounded-pill mt-4">Kirim Bukti</button>
                                </div>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="paymentProof" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded-border">
                <div class="modal-header rounded-border bg-light p-3">
                    <h5 class="modal-title" id="exampleModalLabel">Bukti Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                </div>

                <div class="modal-body pt-0">
                    <div class="row">
                        <div class="col-md-12">
                            <img class="img-fluid" src="/assets/payment/{{$transaction->payment_proof}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection