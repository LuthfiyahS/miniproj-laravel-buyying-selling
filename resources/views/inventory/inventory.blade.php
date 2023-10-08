@extends('_layout.main')

@section('title')
    BnS App
@endsection


{{-- //konten setiap menu --}}
@section('content')
    <div class="page-header">
        <div class="page-title">
            <h3 class="page-title">Inventory</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item">Master Data</li>
                <li class="breadcrumb-item active">Inventory</li>
            </ul>
        </div>
        <div class="page-btn">
            <div class="wordset">
                <ul>
                    
                    <li>
                        <a href="#" class="btn btn-added " data-bs-toggle="modal" data-bs-target="#create"><img
                                src="{{ asset('theme/assets/img/icons/plus.svg') }}" alt="img"
                                class="me-2" />Add Inventory</a>
                    </li>
                </ul>
            </div>


        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="dash-widget">
                                <div class="dash-widgetimg">
                                    <span><img src="{{ 'theme/assets/img/icons/dash1.svg' }}" alt="img"></span>
                                </div>
                                <div class="dash-widgetcontent">
                                    <h5><span class="counters" data-count="{{$jmlstok}}">{{$jmlstok}}</span></h5>
                                    <h6>Total Stok Inventory</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="dash-widget dash1">
                                <div class="dash-widgetimg">
                                    <span><img src="{{ 'theme/assets/img/icons/dash2.svg' }}" alt="img"></span>
                                </div>
                                <div class="dash-widgetcontent">
                                    <h5><span class="counters" data-count="{{($inv)}}">{{ number_format($inv, 0, ',', '.') }}</span></h5>
                                    <h6>Total Inventory</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-top">
                        <div class="search-set">
                            <div class="search-input">
                                <a class="btn btn-searchset">
                                    <img src="{{ 'theme/assets/img/icons/search-white.svg' }}" alt="img" />
                                </a>
                            </div>
                        </div>
                        <div class="wordset">
                            <ul>
                                <li>
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf" href="/inventories-pdf"><img
                                            src="{{ 'theme/assets/img/icons/pdf.svg' }}" alt="img" /></a>
                                </li>
                                <li>
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel" href="/inventories-export/excel"><img
                                            src="{{ 'theme/assets/img/icons/excel.svg' }}" alt="img" /></a>
                                </li>
                                {{-- <li>
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img
                                            src="{{ 'theme/assets/img/icons/printer.svg' }}" alt="img" /></a>
                                </li> --}}
                            </ul>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table datanew">
                            <thead>
                                <tr>
                                    <th>No </th>
                                    <th>Name </th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $x)
                                    <tr>
                                        <td class="productimgname">
                                            <a href="javascript:void(0);" class="product-img">
                                                @if ($x->gambar != null)
                                                    <img src="{{ url($x->gambar) }}" alt="product" />
                                                @else
                                                    <img src="{{ 'theme/assets/img/customer/customer1.jpg' }}"
                                                        alt="product" />
                                                @endif
                                            </a>
                                        </td>
                                        <td>
                                            <h6 class="text-black"><b>{{ $x->name }}</b></h6>
                                        </td>
                                        <td>
                                            @if ($x->price != null)
                                                Rp {{ number_format($x->price, 0, ',', '.') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $x->stock }}</td>
                                        <td>
                                            <a class="confirm-text" href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#edit{{ $x->id }}">
                                                <img src="{{ asset('theme/assets/img/icons/edit.svg') }}"
                                                    alt="img" />
                                            </a>
                                            <a class="me-3 confirm-text edit" href="javascript:void(0);"
                                                data-bs-toggle="modal" data-bs-target="#delete{{ $x->id }}">
                                                <img src="{{ asset('theme/assets/img/icons/delete.svg') }}"
                                                    alt="img" />
                                            </a>
                                        </td>
                                    </tr>
                                    {{-- modal edit --}}
                                    <div class="modal fade" id="edit{{ $x->id }}" tabindex="-1"
                                        aria-labelledby="edit" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Data</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('inventories.update',$x->id )}}" method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="row">
                                                            
                                                            <div class="col-lg-6 col-sm-12 col-12">
                                                                <div class="form-group">
                                                                    <label>Name Produk</label>
                                                                    <input type="text" class="form-control"
                                                                        name="name" required
                                                                        value="{{ $x->name }}" />
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-sm-12 col-12">
                                                                <div class="form-group">
                                                                    <label>Foto Produk <small style="font-size: 10px">*<i>input jika ada</i></small></label>
                                                                    <input type="file" name="gambar" id="" class="form-control" accept="image/png, image/jpeg">
                                                                    <input type="hidden" name="pathGambar" value="{{ $x->gambar }}">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-6 col-sm-12 col-12">
                                                                    <div class="form-group">
                                                                        <label>Price</label>
                                                                        <input type="text" name="price"
                                                                            type-currency="IDR" placeholder="Rp" value="{{ $x->price }}" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 col-sm-12 col-12">
                                                                    <div class="form-group">
                                                                        <label>Stock</label>
                                                                        <input type="text" class="form-control"
                                                                            name="stock" id="inputnumber" required
                                                                            value="{{ $x->stock }}" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <button type="submit"class="btn btn-submit me-2"
                                                                id="btnSubmit1">Submit</button>
                                                            <a class="btn btn-cancel" data-bs-dismiss="modal">Cancel</a>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- end modal --}}
                                @endforeach
                            </tbody>
                        </table>
                        {{-- modal create --}}
                        <div class="modal fade" id="create" tabindex="-1" aria-labelledby="create"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Tambah Inventory</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('inventories.store' )}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                
                                                <div class="col-lg-6 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label>Name Produk</label>
                                                        <input type="text" class="form-control" name="name"
                                                            value="" required />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label>Foto Produk <small style="font-size: 10px">*<i>input jika ada</i></small></label>
                                                        <input type="file" name="gambar" id="" class="form-control" accept="image/png, image/jpeg">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6 col-6">
                                                        <div class="form-group">
                                                            <label>Satuan</label>
                                                            <input type="text" name="price"
                                                                type-currency="IDR" placeholder="Rp" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-6">
                                                        <div class="form-group">
                                                            <label>Stock</label>
                                                            <input type="text" class="form-control" name="stock"
                                                                id="inputnumber" required value="" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <input type="submit" class="btn btn-submit me-2" id="btnSubmit"
                                                    value="Submit" />
                                                <a class="btn btn-cancel" data-bs-dismiss="modal">Cancel</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- end modal --}}

                        @foreach ($data as $x)
                        {{-- modal delete Inventory--}}
                        <div class="modal fade" id="delete{{ $x->id }}" tabindex="-1"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Hapus Data</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="delete-order">
                                            <img src="{{ asset('theme/assets/img/icons/close-circle1.svg') }}"
                                                alt="img" />
                                        </div>
                                        <div class="para-set text-center">
                                            <p>
                                                Data saat ini akan dihapus <br /> anda tidak dapat
                                                mengembalikannya.
                                            </p>
                                        </div>
                                        <div class="col-lg-12 text-center">
                                            <form action="{{ route('inventories.destroy',$x->id )}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" type="submit" >Ya, Hapus</button>
                                                <a class="btn btn-cancel" data-bs-dismiss="modal">Batalkan</a>
                                            </form>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- end modal delete Inventory--}}

                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script type='text/javascript'>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(function() {

                $('#jual').on('change', function() {
                    var cbChecked = $("#jual").is(":checked");
                    var cb2Checked = $("#beli").is(":checked");
                    if ($('#jual').is(":checked")) {
                        $("#notif").hide();
                        $("#btnSubmit").prop("disabled", false)
                    } else {
                        if ($('#beli').is(":checked")) {
                            $("#notif").hide();
                            $("#btnSubmit").prop("disabled", false)
                        } else {
                            $("#notif").show();
                            // var cbChecked = $("#jual").is(":checked")==false;
                            // var cb2Checked = $("#beli").is(":checked")==false;
                            $("#btnSubmit").prop("disabled", !cbChecked || !cb2Checked)
                        }
                    }
                });
                $('#beli').on('change', function() {
                    var cbChecked = $("#jual").is(":checked");
                    var cb2Checked = $("#beli").is(":checked");
                    if ($('#beli').is(":checked")) {
                        $("#notif").hide();
                        $("#btnSubmit").prop("disabled", false)
                    } else {
                        if ($('#jual').is(":checked")) {
                            $("#notif").hide();
                            $("#btnSubmit").prop("disabled", false)
                        } else {
                            $("#notif").show();
                            // var cbChecked = $("#jual").is(":checked")==false;
                            // var cb2Checked = $("#beli").is(":checked")==false;
                            $("#btnSubmit").prop("disabled", !cbChecked || !cb2Checked)
                        }
                    }
                });
                $('#kategori').on('change', function() {
                    let id = $('#kategori').val();
                    console.log(id);

                    $.ajax({
                        type: 'POST',
                        url: 'getNoAkun/' + id,
                        data: {
                            id: id
                        },
                        cache: false,

                        success: function(msg) {
                            $("#before").hide();
                            $('#no_akun').html(msg);
                        },
                        error: function(data) {
                            console.log('error', data);
                        }
                    })
                });

                $('#detail').on('change', function() {
                    let id = $('#kategori').val();
                    let tipe = $('#detail').val();
                    if (tipe == 'sub') {
                        $("#detail_akunlabel").show();
                        $("#detail_akunlabel2").hide();
                        $.ajax({
                            type: 'POST',
                            url: 'getSubAkun/' + id,
                            data: {
                                id: id
                            },
                            cache: false,

                            success: function(msg) {
                                $('#detail_akunlabel').html(msg);
                                console.log(id);
                            },
                            error: function(data) {
                                console.log('error', data);
                            }
                        })
                    } else if (tipe == 'header') {
                        $("#detail_akunlabel2").show();
                        $("#detail_akunlabel").hide();
                        $.ajax({
                            type: 'POST',
                            url: 'getHeaderAkun/' + id,
                            data: {
                                id: id
                            },
                            cache: false,

                            success: function(msg) {
                                $('#detail_akunlabel2').html(msg);
                                console.log(msg);
                            },
                            error: function(data) {
                                console.log('error', data);
                            }
                        })
                    } else {
                        $("#detail_akunlabel").hide();
                        $("#header").hide();
                    }
                });
            })
        });
    </script>
    <!-- Input Numbers -------------------------------->
    <script>
        $('#inputnumber').keyup(function() {
            // value is either the inputed numbers or 0 if none
            $(this).val(parseFloat($(this).val()) || 0);
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('input[type-currency="IDR"]').forEach((element) => {
                element.addEventListener('keyup', function(e) {
                    let cursorPostion = this.selectionStart;
                    let value = parseInt(this.value.replace(/[^,\d]/g, ''));
                    let originalLenght = this.value.length;
                    if (isNaN(value)) {
                        this.value = "";
                    } else {
                        this.value = value.toLocaleString('id-ID', {
                            currency: 'IDR',
                            style: 'currency',
                            minimumFractionDigits: 0
                        });
                        cursorPostion = this.value.length - originalLenght + cursorPostion;
                        this.setSelectionRange(cursorPostion, cursorPostion);
                    }
                });
            });
        });
    </script>

    <script type="text/javascript">
        function valueChanged1() {
            if ($('#jual').is(":checked"))
                $("#fieldjual").show();
            else
                $("#fieldjual").hide();
        }

        function valueChanged2() {
            if ($('#beli').is(":checked"))
                $("#fieldbeli").show();
            else
                $("#fieldbeli").hide();
        }


        //edit
        function valueChanged11(id) {
            if ($(`#jual1${id}`).is(":checked")) {
                $(`#fieldjual1${id}`).show();
            } else {
                $(`#fieldjual1${id}`).hide();
            }

            $(`#jual1${id}`).on('change', function() {
                var cbChecked = $(`#jual1${id}`).is(":checked");
                var cb2Checked = $(`#beli1${id}`).is(":checked");
                if ($(`#jual1${id}`).is(":checked")) {
                    $(`#notif1${id}`).hide();
                    $(`#btnSubmit1${id}`).prop("disabled", false)
                } else {
                    if ($(`#beli1${id}`).is(":checked")) {
                        $(`#notif1${id}`).hide();
                        $(`#btnSubmit1${id}`).prop("disabled", false)
                    } else {
                        $(`#notif1${id}`).show();
                        // var cbChecked = $("#jual").is(":checked")==false;
                        // var cb2Checked = $("#beli").is(":checked")==false;
                        $(`#btnSubmit1${id}`).prop("disabled", !cbChecked || !cb2Checked)
                    }
                }
            });
        }

        function valueChanged21(id) {
            if ($(`#beli1${id}`).is(":checked")) {
                $(`#fieldbeli1${id}`).show();
            } else {
                $(`#fieldbeli1${id}`).hide();
            }
            $(`#beli1${id}`).on('change', function() {
                var cbChecked = $(`#jual1${id}`).is(":checked");
                var cb2Checked = $(`#beli1${id}`).is(":checked");
                if ($(`#beli1${id}`).is(":checked")) {
                    $(`#notif1${id}`).hide();
                    $(`#btnSubmit1${id}`).prop("disabled", false)
                } else {
                    if ($(`#jual1${id}`).is(":checked")) {
                        $(`#notif1${id}`).hide();
                        $(`#btnSubmit1${id}`).prop("disabled", false)
                    } else {
                        $(`#notif1${id}`).show();
                        // var cbChecked = $("#jual").is(":checked")==false;
                        // var cb2Checked = $("#beli").is(":checked")==false;
                        $(`#btnSubmit1${id}`).prop("disabled", !cbChecked || !cb2Checked)
                    }
                }
            });
        }
    </script>
@endsection
