@extends('_layout.main')

@section('title')
    BnS App
@endsection

{{-- //konten setiap menu --}}
@section('content')
    <div class="page-header">
        <div class="page-title">
            <h3 class="page-title">Purchase</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">Transaction</li>
                <li class="breadcrumb-item active">Purchase</li>
                <li class="breadcrumb-item active">Edit</li>
            </ul>
        </div>
    </div>

    <div class="card">
        <form action="{{route('purchase.update',$data->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
        <div class="card-body">
            <div class="row">
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label>Employee Job</label>
                        <select class="form-control js-example-basic-single" name="user_id">
                            <option value="{{$data->user_id}}">{{$data->user->name}}</option>
                            @foreach ($user as $item)
                                <option value="{{ $item->id }}"> {{ $item->name }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label>Tanggal Transaksi</label>
                        <input type="date" class="form-control" name="tgl_transaksi" required value="{{$data->date}}" readonly>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Qty</th>
                            </tr>
                        </thead>
                        <tbody class="after-add-more">
                            @foreach ($datadetail as $x)
                            <tr>
                                <td>
                                    <select class="form-control js-example-basic-single" name="produk_id[]">
                                        <option value="{{$x->inventory_id}}">{{$x->inventory->name}}</option>
                                        @foreach ($barang as $item)
                                            <option value="{{ $item->id }}"> {{ $item->name }} </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="text" id="jumlah" class="kuantitas form-control" name="kuantitas[]" value="{{$x->qty}}"></td>
                                <td>
                                    {{-- <a class="delete-set"><img src="{{ asset('theme/assets/img/icons/delete.svg') }}"
                                            alt="svg"></a> --}}
                                    <a class="add-more"><img src="{{ asset('theme/assets/img/icons/plus.svg') }}"
                                            alt="svg"></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-lg-12 float-md-right">
                    <div class="total-order">
                        <ul>
                            <li>
                                <h4>Total Product</h4>
                                {{-- <h5>Rp. 1.000</h5> --}}
                                <h5>{{ number_format($totalqty, 0, ',', '.') }}</h5>
                            </li>
                            <li class="total">
                                <h4>Total Tagihan</h4>
                                {{-- <h5>Rp. 11.000</h5> --}}
                                <h5 style="font-size: 18pt">Rp. {{ number_format($totaltag, 0, ',', '.') }}</h5>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-12">
                    <button type="submit" class="btn btn-submit me-2">Submit</button>
                    <a href="{{route('purchase.index')}}" class="btn btn-cancel">Cancel</a>
                </div>
            </div>
        </div>
    </form>
    </div>
    <script style="text/javascript">
        $(document).ready(function() {
            $(".add-more").click(function(e) {
                e.preventDefault();
                $(".after-add-more").append(`
                <tr>
                                <td>
                                    <select class="form-control" name="produk_id[]">
                                        <option>Choose</option>
                                        @foreach ($barang as $item)
                                            <option value="{{ $item->id }}"> {{ $item->name }} </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="text" id="jumlah" class="kuantitas form-control" name="kuantitas[]" value="1"></td>
                                <td>
                                    <a class="delete-set"><img src="{{ asset('theme/assets/img/icons/delete.svg') }}"
                                            alt="svg"></a>
                                </td>
                            </tr>
            `)
            });
            // saat tombol remove dklik control group akan dihapus
            $(document).on("click", ".remove", function(e) {
                e.preventDefault();
                let remove = $(this).parent().parent();
                $(remove).remove();
            });
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
    {{-- merubah inputan --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $("#jumlah, #harga").keyup(function() {
                var harga  = $("#harga").val();
                var jumlah = $("#jumlah").val();
                // var pajak  = $("#pajak").val();

                var total = parseInt(harga) * parseFloat(jumlah);
                $("#total").val(total);
            });
        });
    </script>
@endsection
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
</script>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
