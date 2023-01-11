@extends('layout/template')

@section('contents')
    <div class="row">
        <div class="col-12">
            <div class="card rounded-border" id="orderList">
                <div class="card-header border-0 rounded-border">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Ubah Servis</h5>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form method="GET">
                        <div class="row g-3">
                            <div class="col-xl-2 col-md-3 col-sm-4">
                                <a href="/admin/service" class="btn btn-secondary add-btn rounded-pill"><i class="ri-add-line align-bottom me-1"></i> Kembali</a>
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
                    <form method="POST" action="/admin/service/update/{{$service->id}}">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input value="{{$service->service_name}}" type="text" class="form-control" required name="service_name" autocomplete="off" placeholder="John Doe">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <button class="btn btn-warning">Ubah</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection