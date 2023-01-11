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
                        <h5 class="card-title mb-0 flex-grow-1">Daftar Tagihan</h5>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form method="GET">
                        <div class="row g-3">
                            <div class="col-xl-2 col-md-3 col-sm-4">
                                <div>
                                    <select class="form-control" data-choices data-choices-sorting-false data-choices-search-false name="user_id">
                                        @foreach($user as $row)
                                            <option value="{{$row->id}}">{{$row->fullname}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-3 col-sm-4">
                                <div>
                                    <select class="form-control" data-choices data-choices-sorting-false data-choices-search-false name="year">
                                        <?php for ($i=2023; $i <=date('Y') ; $i++) { ?>
                                            <option value="{{$i}}">{{$i}}</option>
                                        <?php } ?>
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
                                        <th style="width:30%">Bulan</th>
                                        <th class="text-center" style="width: 20%;">Status</th>
                                        <th>Penggunaan Air</th>
                                        <th>Total Biaya</th>
                                        <th style="width:15%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($list as $row)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{ getMonthName($row['month']) }}</td>

                                            <?php if(isset($row['bill']->id)){ ?>
                                                <td class="text-center">
                                                    <?php if($row['bill']->status != 'completed'){ ?>
                                                        <div class="badge bg-danger">Belum Dibayar</div>
                                                    <?php }else{ ?>
                                                        <div class="badge bg-success">Lunas</div>
                                                    <?php } ?>    
                                                </td>

                                                <td>{{$row['bill']->usage}} m3</td>
                                                <td class="text-end">{{formatRp($row['bill']->total_amount)}}</td>
                                                <td class="text-end">
                                                    <a class="btn btn-outline-secondary btn-sm rounded-pill" href="/admin/transaction/{{$row['bill']->transaction_id}}">Lihat Tagihan</a>
                                                </td>

                                            <?php }else{ ?>
                                                <td colspan="4" class="text-end text-danger">
                                                    <a href="/admin/bill/create/{{app('request')->input('user_id')}}/{{app('request')->input('year')}}/{{$row['month']}}">Buat Tagihan</a>
                                                </td>
                                            <?php } ?>
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