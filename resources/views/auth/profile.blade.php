@extends('layout/template')

@section('contents')
  <div class="card">
  	<div class="card-header">
  		<b>Ubah Profile</b>
  	</div>
  	<div class="card-body">
  		<div class="row">
  			<div class="col-md-4"></div>
  			<div class="col-md-4">
  				<form method="POST" action="/dashboard/profile/update_profile">
		  			@csrf
					@if (session('status'))
                        <div class="col-md-12 mt-3">
                            {!! session('status') !!}
                        </div>
                    @endif

			  		<div class="row mt-3">
			  			<div class="col-md-12">
			  				<label>Nama</label>
			  				<input type="text" class="form-control" value="{{Session::get('user')->fullname}}" autocomplete="off" name="fullname">
			  			</div>
			  		</div>

			  		<div class="row">
			  			<div class="col-md-12 mt-3">
			  				<label>Email</label>
			  				<input type="email" class="form-control" value="{{Session::get('user')->email}}" autocomplete="off" name="email">
			  			</div>
			  		</div>

			  		<div class="row">
			  			<div class="col-md-12 mt-3">
			  				<label>Nomor Handphone</label>
			  				<input type="text" class="form-control" value="{{Session::get('user')->phone}}" autocomplete="off" name="phone">
			  			</div>
			  		</div>

			  		<div class="row">
			  			<div class="col-md-12 mt-3">
			  				<label>Password</label>
			  				<input type="password" class="form-control" autocomplete="off" name="password">
			  				<small class="text-muted">*Isi password jika ingin melakukan ubah password</small>
			  			</div>
			  		</div>

			  		<div class="row">
			  			<div class="col-md-12 mt-3">
			  				<label>Alamat Lengkap</label>
			  				<textarea type="password" class="form-control" autocomplete="off" name="full_address" required>{{ Session::get('user')->full_address }}</textarea>
			  			</div>
			  		</div>

			  		<div class="row">
			  			<div class="col-md-12 mt-3">
			  				<button class="btn btn-primary">Ubah Profile</button>
			  			</div>
			  		</div>
			  	</form>
  			</div>
  		</div>
  	</div>
  </div>
@endsection