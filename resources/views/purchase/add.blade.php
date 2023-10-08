@extends('_layout.main')

@section('title')
    BnS App
@endsection

@push('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    span.select2.select2-container.select2-container--classic{
        width: 100% !important;
    }
</style>
@endpush

{{-- //konten setiap menu --}}
@section('content')

    <div class="page-header">
        <div class="page-title">
            <h3 class="page-title"> Purchase</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item">Transaction</li>
                <li class="breadcrumb-item">Purchase</li>
                <li class="breadcrumb-item active">Add</li>
            </ul>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{route('purchase.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="after-add-more">
                                <tr>
                                    <td>
                                        <select class="js-example-basic-single" name="produk_id[]">
                                            <option>Choose</option>
                                            @foreach ($inventory as $item)
                                                <option value="{{ $item->id }}"> {{ $item->name }} </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="number" id="kuantitas" class="kuantitas form-control"
                                            name="kuantitas[]" value="1"></td>
                                    
                                    <td>
                                        <a class="delete-set"><img src="{{ asset('theme/assets/img/icons/delete.svg') }}"
                                                alt="svg"></a>
                                        <a class="add-more"><img src="{{ asset('theme/assets/img/icons/plus.svg') }}"
                                                alt="svg"></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
                <div class="row">
                    {{-- <div class="col-lg-12 float-md-right">
                        <div class="total-order">
                            <ul>
                                <li>
                                    <h4>Total Barang</h4>
                                    <h5><input type="text" class="form-control text-end" name="bayar"></h5>
                                </li>
                                <li>
                                    <h4>Quanti</h4>
                                    <h5><input type="text" class="form-control text-end" name="bayar"></h5>
                                </li>
                                <li>
                                    <h4>Total Bayar</h4>
                                    <h5><input type="text" class="form-control text-end" name="bayar"></h5>
                                </li>
                            </ul>
                        </div>
                    </div> --}}
                    <div class="col-lg-12">
                        <button type="submit"class="btn btn-submit me-2">Submit</button>
                        <a href="{{ route('purchase.index') }}" class="btn btn-cancel">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script style="text/javascript">
        $(document).ready(function() {
            $(".add-more").click(function(e) {
                e.preventDefault();
                $(".after-add-more").append(`
                <tr>
                                <td>
                                    <select class="js-example-basic-single2" name="produk_id[]">
                                        <option>Choose</option>
                                        @foreach ($inventory as $item)
                                            <option value="{{ $item->id }}"> {{ $item->name }} </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="number" id="jumlah" class="kuantitas form-control" name="kuantitas[]" value="1"></td>
                                <td>
                                    <a class="delete-set"><img src="{{ asset('theme/assets/img/icons/delete.svg') }}"
                                            alt="svg"></a>
                                    <a class="add-more"><img src="{{ asset('theme/assets/img/icons/plus.svg') }}"
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

        function valueChanged() {
            if ($('#biaya').is(":checked")) {
                $("#tempo").show();
                $("#metode").hide();
            } else {
                $("#tempo").hide();
                $("#metode").show();
            }
        }
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
                var harga = $("#harga").val();
                var kuantitas = $("#kuantitas").val();
                // var pajak  = $("#pajak").val();

                var total = parseInt(harga) * parseFloat(kuantitas);
                $("#total").val(total);
            });
        });
    </script>
@endsection


<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
</script>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function(){
    $('.js-example-basic-single').select2();
});
</script>

