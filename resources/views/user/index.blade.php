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
                        <h5 class="card-title mb-0 flex-grow-1">Daftar User</h5>
                        <div class="flex-shrink-0">
                            
                            <button type="button" class="btn btn-primary add-btn rounded-pill" data-bs-toggle="modal" id="create-btn" data-bs-target="#addModal"><i class="ri-add-line align-bottom me-1"></i> Tambah User</button>
                        
                        </div>
                    </div>
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
                                        <th style="width:20%">Nama Lengkap</th>
                                        <th>Email</th>
                                        <th>Alamat Lengkap</th>
                                        <th>Nomor Handphone</th>
                                        <th style="width:20%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($list as $row)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $row->fullname }}</td>
                                            <td>{{ $row->email }}</td>
                                            <td>{{ $row->full_address }}</td>
                                            <td>{{ $row->phone }}</td>
                                            <td class="text-end">
                                                <a href="/admin/user/edit/{{ $row->id }}" class="btn btn-outline-warning rounded-pill btn-sm">Ubah</a> &nbsp;
                                                <a onclick="return confirm('Apakah anda yakin menghapus data ini ?')" class="btn btn-outline-danger rounded-pill btn-sm" href="/admin/user/delete/{{ $row->id }}">Hapus</a>
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
                    <h5 class="modal-title" id="exampleModalLabel">Tambah User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                </div>

                <form method="POST" action="/admin/user/insert">
                    @csrf

                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" class="form-control" required name="fullname" autocomplete="off" placeholder="John Doe">
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" placeholder="johndoe@gmail.com" autocomplete="off" required name="email">
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label>Nomor Handphone</label>
                                <input type="number" class="form-control" placeholder="085315922225" autocomplete="off" required name="phone">
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" placeholder="" autocomplete="off" required name="password">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary rounded-pill" id="add-btn">Tambah</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection