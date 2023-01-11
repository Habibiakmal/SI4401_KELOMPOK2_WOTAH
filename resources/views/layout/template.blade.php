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

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="/assets/carousel.css" rel="stylesheet">
    <link href="/assets/headers.css" rel="stylesheet">
  </head>
  <body>
    
<div class="container">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 border-bottom">
      <a href="/" class="d-flex align-items-center col-md-3 mb-md-0 text-dark text-decoration-none">
        <img src="/assets/brand/logo.png" style="width:100px">
      </a>

      <!--<ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
        <li><a href="#" class="nav-link px-2 link-secondary">Home</a></li>
        <li><a href="#" class="nav-link px-2 link-dark">Features</a></li>
        <li><a href="#" class="nav-link px-2 link-dark">Pricing</a></li>
        <li><a href="#" class="nav-link px-2 link-dark">FAQs</a></li>
        <li><a href="#" class="nav-link px-2 link-dark">About</a></li>
      </ul>-->

      <div class="col-md-3 text-end">
        <a href="/auth/do_logout" class="btn btn-danger">Logout</a>
      </div>
    </header>
  </div>


<main>

  <div class="container mt-5 mb-5">
      @if(is_user())
        <div class="row">
            <div class="col-md-3">
                <a href="/dashboard" style="text-decoration:none">
                    <div class="card">
                        <div class="card-body">
                            <h6>Dashboard</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="/dashboard/bill" style="text-decoration:none">
                    <div class="card">
                        <div class="card-body">
                            <h6>Tagihan</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="/dashboard/transaction" style="text-decoration:none">
                    <div class="card">
                        <div class="card-body">
                            <h6>Transaksi</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="/dashboard/profile" style="text-decoration:none">
                    <div class="card">
                        <div class="card-body">
                            <h6>Profile</h6>
                        </div>
                    </div>
                </a>
            </div>
        </div>

      @elseif(is_admin())
        <div class="row">
            <div class="col-md-2">
                <a href="/admin" style="text-decoration:none">
                    <div class="card">
                        <div class="card-body">
                            <h6>Dashboard</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-2">
                <a href="/admin/user" style="text-decoration:none">
                    <div class="card">
                        <div class="card-body">
                            <h6>User</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-2">
                <a href="/admin/service" style="text-decoration:none">
                    <div class="card">
                        <div class="card-body">
                            <h6>Servis</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-2">
                <a href="/admin/bill" style="text-decoration:none">
                    <div class="card">
                        <div class="card-body">
                            <h6>Tagihan</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-2">
                <a href="/admin/transaction" style="text-decoration:none">
                    <div class="card">
                        <div class="card-body">
                            <h6>Transaksi</h6>
                        </div>
                    </div>
                </a>
            </div>
        </div>
      @endif()

      <div class="col-md-12 mt-4">
          @yield('contents')
      </div>
  </div>


  <!-- FOOTER -->
  <footer class="container">
    <p class="float-end"><a href="#">Back to top</a></p>
    <p>&copy; 2017–2022 Company, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
  </footer>
</main>


    <script src="/assets/dist/js/bootstrap.bundle.min.js"></script>
      
  </body>
</html>