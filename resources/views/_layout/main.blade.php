<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="POS - Bootstrap Admin Template">
    <meta name="keywords"
        content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern,  html5, responsive">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('theme')}}/assets/img/logo-small.png">

    <link rel="stylesheet" href="{{ asset('theme')}}/assets/css/bootstrap.min.css">

    <link rel="stylesheet" href="{{ asset('theme')}}/assets/plugins/select2/css/select2.min.css">

    <link rel="stylesheet" href="{{ asset('theme')}}/assets/css/animate.css">

    <link rel="stylesheet" href="{{ asset('theme')}}/assets/css/dataTables.bootstrap4.min.css">

    <link rel="stylesheet" href="{{ asset('theme')}}/assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="{{ asset('theme')}}/assets/plugins/fontawesome/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('theme')}}/assets/css/style.css">
</head>

<body>
    @include('sweetalert::alert')
    {{-- <div id="global-loader">
        <div class="whirly-loader"> </div>
    </div> --}}

    <div class="main-wrapper">

        <div class="header">

            <div class="header-left active">
                <a href="index.html" class="logo">
                    <img src="{{ asset('theme')}}/assets/img/logo.png" alt="">
                </a>
                <a href="index.html" class="logo-small">
                    <img src="{{ asset('theme')}}/assets/img/logo-small.png" alt="">
                </a>
                <a id="toggle_btn" href="javascript:void(0);">
                </a>
            </div>

            <a id="mobile_btn" class="mobile_btn" href="#sidebar">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>

            <ul class="nav user-menu">

                <li class="nav-item dropdown has-arrow main-drop">
                    <a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
                        @if (auth()->user()->gambar == null)
                            <span class="user-img"><img src="{{ asset('theme/assets/img/logo-small.png') }}"
                                    alt="">
                            @else
                                <span class="user-img"><img src="{{ url(auth()->user()->gambar) }}" alt="">
                        @endif
                        <span class="status online"></span></span>
                    </a>
                    <div class="dropdown-menu menu-drop-user">
                        <div class="profilename">
                            <div class="profileset">
                                @if (auth()->user()->gambar == null)
                                    <span class="user-img"><img
                                            src="{{ asset('theme/assets/img/logo-small.png') }}"
                                            alt="">
                                    @else
                                        <span class="user-img"><img src="{{ url(auth()->user()->gambar) }}"
                                                alt="">
                                @endif
                                <span class="status online"></span></span>
                                <div class="profilesets">
                                    <h6>{{ auth()->user()->name }}</h6>
                                    <h5>{{ auth()->user()->role }}</h5>
                                </div>
                            </div>
                            <hr class="m-0">
                            {{-- <a class="dropdown-item" href="{{ route('profile.index') }}"> <i class="me-2"
                                    data-feather="user"></i>
                                My Profile</a>
                            <a class="dropdown-item" href="generalsettings.html"><i class="me-2"
                                    data-feather="settings"></i>Settings</a>
                            <hr class="m-0"> --}}
                            <a class="dropdown-item logout pb-0" href="{{ route('logout') }}"><img
                                    src="{{ asset('theme/assets/img/icons/log-out.svg') }}" class="me-2"
                                    alt="img">Logout</a>
                        </div>
                    </div>
                </li>
            </ul>


            <div class="dropdown mobile-user-menu">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="profile.html">My Profile</a>
                    <a class="dropdown-item" href="generalsettings.html">Settings</a>
                    <a class="dropdown-item" href="signin.html">Logout</a>
                </div>
            </div>

        </div>


        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    @include('_layout.sidebar')
                </div>
            </div>
        </div>

        <div class="page-wrapper cardhead">
            <div class="content">

                {{-- <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Form Select2</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                <li class="breadcrumb-item active">Form Select2</li>
                            </ul>
                        </div>
                    </div>
                </div> --}}

                @yield('content')
                {{-- <div class="row">
                    <div class="col-md-6">

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Basic</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>Use select2() function on select element to convert it to Select 2.</p>
                                        <select class="js-example-basic-single select2">
                                            <option selected="selected">orange</option>
                                            <option>white</option>
                                            <option>purple</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Nested</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>Add options inside the optgroups to for group options.</p>
                                        <select class="form-control nested">
                                            <optgroup label="Group1">
                                                <option selected="selected">orange</option>
                                                <option>white</option>
                                                <option>purple</option>
                                            </optgroup>
                                            <optgroup label="Group2">
                                                <option>purple</option>
                                                <option>orange</option>
                                                <option>white</option>
                                            </optgroup>
                                            <optgroup label="Group3">
                                                <option>white</option>
                                                <option>purple</option>
                                                <option>orange</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Placeholder</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>Apply Placeholder by setting option placeholder option.</p>
                                        <select class="placeholder js-states form-control">
                                            <option>Choose...</option>
                                            <option value="one">First</option>
                                            <option value="two">Second</option>
                                            <option value="three">Third</option>
                                            <option value="four">Fourth</option>
                                            <option value="five">Fifth</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Tagging with multi-value select boxes</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>Set tags: true to convert select 2 in Tag mode.</p>
                                        <select class="form-control tagging" multiple="multiple">
                                            <option>orange</option>
                                            <option>white</option>
                                            <option>purple</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Small Select2</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>Use data('select2') function to get container of select2.</p>
                                        <select class="form-control form-small select">
                                            <option selected="selected">orange</option>
                                            <option>white</option>
                                            <option>purple</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Disabling options</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>Disable Select using disabled attribute.</p>
                                        <select class="form-control disabled-results">
                                            <option value="one">First</option>
                                            <option value="two" disabled="disabled">Second</option>
                                            <option value="three">Third</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Limiting the number of Tagging</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>Set maximumSelectionLength: 2 with tags: true to limit selectin in Tag mode.
                                        </p>
                                        <select class="form-control tagging" multiple="multiple">
                                            <option>orange</option>
                                            <option>white</option>
                                            <option>purple</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>


    <script src="{{ asset('theme')}}/assets/js/jquery-3.6.0.min.js"></script>

    <script src="{{ asset('theme')}}/assets/js/feather.min.js"></script>

    <script src="{{ asset('theme')}}/assets/js/jquery.slimscroll.min.js"></script>

    <script src="{{ asset('theme')}}/assets/plugins/select2/js/select2.min.js"></script>
    <script src="{{ asset('theme')}}/assets/plugins/select2/js/custom-select.js"></script>

    <script src="{{ asset('theme')}}/assets/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('theme')}}/assets/js/dataTables.bootstrap4.min.js"></script>

    <script src="{{ asset('theme')}}/assets/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('theme')}}/assets/js/script.js"></script>
</body>

</html>
