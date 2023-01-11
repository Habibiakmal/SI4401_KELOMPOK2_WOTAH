<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.108.0">
    <title>Wotah</title>

    
    <link href="/assets/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

    <body>

        <form method="POST" action="/auth/do_login">
            @csrf
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-primary text-center">
                                <div class="card-title">
                                    <h5 class="text-white">LOGIN</h5>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    @if (session('status'))
                                        <div class="col-md-12 mt-3">
                                            {!! session('status') !!}
                                        </div>
                                    @endif

                                    <div class="col-md-12 mt-3">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="text" class="form-control" placeholder="Email" autocomplete="off" required name="email">
                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" class="form-control" placeholder="" autocomplete="off" required name="password">
                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-4">
                                        <div class="d-grid gap-2">
                                          <button class="btn btn-outline-primary btn-block">Login</button>
                                          <div>Belum punya akun ? <a href="/register">Daftar disini</a></div>
                                        </div>
                                        
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </body>
    <script src="/assets/dist/js/bootstrap.bundle.min.js"></script>
</html>