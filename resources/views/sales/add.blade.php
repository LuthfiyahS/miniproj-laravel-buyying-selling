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
            <h3 class="page-title"> Sales</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item">Transaction</li>
                <li class="breadcrumb-item">Sales</li>
                <li class="breadcrumb-item active">Add</li>
            </ul>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{route('sales.store')}}" method="post" enctype="multipart/form-data">
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
                    <div class="col-lg-12">
                        <button type="submit"class="btn btn-submit me-2">Submit</button>
                        <a href="{{ route('sales.index') }}" class="btn btn-cancel">Cancel</a>
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
                                    <select class="form-control js-example-basic-single" name="produk_id[]">
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
    {{-- <script>
        $(document).ready(function() {
            //this calculates values automatically
            calculateSum();
            //calculateSumTotal();

            $(".harga").on("keyup keydown", function() {
                calculateSum();
            });
            // $(".jenis_pajak").on("change", function() {
            //     calculateSumTotal();
            // });
        });

        function calculateSum() {
            var sum = 0;
            //iterate through each textboxes and add the values
            $(".harga").each(function() {
                //add only if the value is number

                sum =0;
                var i =0;
                for (let index = 0; index < $(".kuantitas").length; index++) {
                    const element = array[index];
                    //if($(".kuantitas")[index].value == index){
                    if(i == index){

                    }
                    console.log(index) ;
                }

                if (!isNaN(this.value) && this.value.length != 0) {
                    sum =  parseInt(this.value)*parseInt($(".kuantitas").value);
                    $(this).css("background-color", "#FEFFB0");
                    //$("input#total_produk").val(sum);
                }
                else if (this.value.length != 0){
                    $(this).css("background-color", "red");
                }
                i++;

                $(".total_produk").each(function() {
                    $("input#total_produk").val(sum);
                });
            });

            //$("input#total_produk").val(sum.toFixed(2));
            $("input#total_produk").val(sum);

        }

    </script> --}}
@endsection

{{-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
</script>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script> --}}


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