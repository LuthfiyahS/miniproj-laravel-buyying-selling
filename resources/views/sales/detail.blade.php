@extends('_layout.main')

@section('title')
    BnS App
@endsection



{{-- //konten setiap menu --}}
@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Detail Sales</h4>
            <h6>View Detail Sales</h6>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="card-sales-split">
                <h5>Sales Detail #{{$data->number}} </h5>
                <form action="{{route('sales.destroy',$data->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <ul>
                        <li>
                            @if (auth()->user()->role != "Manager")
                            <a href="{{route('sales.edit',$data->id)}}" class="btn bg-transparant"><img src="{{ asset('../theme/assets/img/icons/edit.svg') }}" alt="img"></a>
                            <button type="submit" class="btn bg-transparant"><img src="{{ asset('../theme/assets/img/icons/delete-2.svg') }}" alt="img"></button>
                            @endif
                            <a class="btn bg-transparant" href="/sales-invoice/{{ $data->id }}" target="_blank"><img src="{{ asset('theme/assets/img/icons/pdf.svg') }}" alt="img"></a>
                        </li>
                    </ul>
                </form>
                
            </div>
            <div class="invoice-box table-height"
                style="max-width: 1600px;width:100%;overflow: auto;margin:15px auto;padding: 0;font-size: 14px;line-height: 24px;color: #555;">
                <table cellpadding="0" cellspacing="0" style="width: 100%;line-height: inherit;text-align: left;">
                    <tbody>
                        <tr class="top">
                            <td colspan="6" style="padding: 5px;vertical-align: top;">
                                <table style="width: 100%;line-height: inherit;text-align: left;">
                                    <tbody>
                                        <tr>
                                            <td style="padding:5px;vertical-align:top;text-align:left;padding-bottom:20px">
                                                {{-- <font style="vertical-align: inherit;font-size:18px;color:#7367F0;font-weight:500;line-height: 35px; ">
                                                        Di Bayar Dari</font><br>
                                                        <font style="vertical-align: inherit;" class="text-black"><h6>{{$data->akun->nama_akun}}</h6></font><br> --}}
                                                <font
                                                    style="vertical-align: inherit;font-size:18px;color:#7367F0;font-weight:500;line-height: 35px; ">
                                                        Employee Job</font><br>
                                                        <font style="vertical-align: inherit;">{{$data->user->name}}</font>
                                                {{-- <font
                                                    style="vertical-align: inherit;font-size:14px;color:#7367F0;font-weight:500;line-height: 35px; ">
                                                        Nomor </font><br> --}}
                                            </td>
                                            <td style="padding:5px;vertical-align:top;text-align:left;">
                                                <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 500;">Date</font><br>
                                                <font style="vertical-align: inherit;font-size: 16px;color:#000;font-weight: 400;">{{ date('d/m/Y', strtotime($data->date)) }}</font><br>

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr class="heading " style="background: #F3F2F7;">
                            <td
                                style="padding: 5px;vertical-align: middle;font-weight: 600;color: #5E5873;font-size: 14px;padding: 10px; ">
                                Produk
                            </td>
                            <td
                                style="padding: 5px;vertical-align: middle;font-weight: 600;color: #5E5873;font-size: 14px;padding: 10px; ">
                                Harga
                            </td>
                            <td
                                style="padding: 5px;vertical-align: middle;font-weight: 600;color: #5E5873;font-size: 14px;padding: 10px; ">
                                Kuantitas
                            </td>
                            <td
                                style="padding: 5px;vertical-align: middle;font-weight: 600;color: #5E5873;font-size: 14px;padding: 10px; ">
                                Total
                            </td>
                        </tr>
                        @foreach ($datadetail as $item)
                            <tr class="details" style="border-bottom:1px solid #E9ECEF ;">
                                <td style="padding: 10px;vertical-align: top; align-items: center;">
                                    <p class="mb-0" style="font-weight: 600;">{{ $item->inventory->name }}  </p>
                                </td>
                                <td style="padding: 10px;vertical-align: top; ">
                                    Rp. {{ number_format($item->price, 0, ',', '.') }}
                                </td>
                                <td style="padding: 10px;vertical-align: top; ">
                                    {{ $item->qty}}
                                </td>
                                <td style="padding: 10px;vertical-align: top; ">
                                    Rp. {{ number_format(($item->price*$item->qty), 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row">
                
                <div class="row">
                        <div class="col-lg-6" >
                            
                        </div>
                        <div class="col-lg-6">
                            <div class="total-order w-100 max-widthauto m-auto mb-4">
                                <ul>
                                    <li>
                                        <h4>Total Inventory</h4>
                                        <h5> {{ number_format($totalqty, 0, ',', '.') }}</h5>
                                    </li>
                                    
                                    <hr>
                                    <li>
                                        <h4>Total</h4>
                                        <h5 style="font-size: 18pt">Rp. {{ number_format($totaltag, 0, ',', '.') }}</h5>
                                    </li>
                                </ul>
                            </div>
                        </div>
                </div>
                
            </div>
        </div>
    </div>
    

    
@endsection
