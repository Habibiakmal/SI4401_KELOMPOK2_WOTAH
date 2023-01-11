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
                        <div class="flex-shrink-0">
                            
                            <button type="button" class="btn btn-primary add-btn rounded-pill" data-bs-toggle="modal" id="create-btn" data-bs-target="#addModal"><i class="ri-add-line align-bottom me-1"></i> Pesan Layanan</button>
                        
                        </div>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form method="GET">
                        <div class="row g-3">
                            <div class="col-xl-2 col-md-3 col-sm-4">
                                <div>
                                    <select class="form-control" data-choices data-choices-sorting-false data-choices-search-false name="status">
                                        <option value="">Pilih Status</option>
                                        <option value="all">Semua</option>
                                        <option value="active">Aktif</option>
                                        <option value="nonactive">Nonaktif</option>
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
                                            <td>{{ $row->transaction_code }}</td>
                                            <td>{{ transactionType($row->type) }}</td>
                                            <td>{{ indonesianDate($row->created_at, true) }}</td>
                                            <td class="text-center">{!! transactionStatus($row->status) !!}</td>
                                            <td class="text-end">{{ formatRp($row->amount) }}</td>
                                            <td class="text-end">
                                                <a class="btn btn-outline-secondary rounded-pill" href="/dashboard/transaction/{{ $row->id }}">Lihat</a>
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

    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded-border">
                <div class="modal-header rounded-border bg-light p-3">
                    <h5 class="modal-title" id="exampleModalLabel">Pesan Layanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                </div>
                <form method="POST" action="/dashboard/transaction/order_service">
                    @csrf

                    <div class="modal-body">
                        @if(Session::get('user')->full_address != '')
                            <div class="row mt-1">
                                <div class="col-md-12">
                                    <label>Pilih Layanan</label>
                                    <select name="service_id" required class="form-control">
                                        <option value="">Pilih</option>
                                        @foreach($service as $row)
                                            <option value="{{$row->id}}">{{$row->service_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                               
                               <div class="col-md-12 mt-3">
                                   <label>Deskripsikan Permasalahan Anda</label>
                                   <textarea class="form-control" required name="issue_description"></textarea>
                               </div>

                               <div class="col-md-12 mt-4">
                                   <div class="alert alert-info">
                                       <h6><b>INFO</b></h6>
                                       Perlu diingat, nominal pembayaran akan ditentukan dan diberikan saat layanan sudah selesai dilakukan oleh teknisi kami
                                   </div>
                               </div>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-danger">
                                        <h6><b>INFO</b></h6>
                                        Harap isi <b>alamat lengkap</b> anda pada halaman profile<br>
                                        data tersebut diperlukan agar teknisi kami dapat mengetahui lokasi anda
                                    </div>
                                </div>
                            </div>
                        @endif
                         
                    </div>

                    @if(Session::get('user')->full_address != '')
                        <div class="modal-footer">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary rounded-pill" id="add-btn">Pesan Sekarang</button>
                            </div>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection