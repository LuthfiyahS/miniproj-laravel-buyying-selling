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
                <li class="breadcrumb-item">Transaction</li>
                <li class="breadcrumb-item active">Purchase</li>
            </ul>
        </div>
        <div class="page-btn">
            @if (auth()->user()->role != "Manager")
            <a href="{{ route('purchase.create') }}" class="btn btn-added "><img
                src="{{ 'theme/assets/img/icons/plus.svg' }}" alt="img" class="me-2" />Add Purchase</a>    
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-sm-6 col-12">
            <div class="dash-widget">
                <div class="dash-widgetimg">
                    <span><img src="{{ 'theme/assets/img/icons/dash1.svg' }}" alt="img"></span>
                </div>
                <div class="dash-widgetcontent">
                    <h5> <span class="counters" data-count="{{$jmltransaksi}}">{{$jmltransaksi}}</span></h5>
                    <h6>Total Transaction</h6>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6 col-12">
            <div class="dash-widget dash1">
                <div class="dash-widgetimg">
                    <span><img src="{{ 'theme/assets/img/icons/dash2.svg' }}" alt="img"></span>
                </div>
                <div class="dash-widgetcontent">
                    <h5>Rp. <span class="counters" data-count="{{$totaltransaksi}}">{{ number_format($totaltransaksi, 0, ',', '.') }}</span></h5>
                    <h6>Total Sales</h6>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6 col-12">
            <div class="dash-widget dash2">
                <div class="dash-widgetimg">
                    <span><img src="{{ 'theme/assets/img/icons/dash3.svg' }}" alt="img"></span>
                </div>
                <div class="dash-widgetcontent">
                    <h5> <span class="counters" data-count="{{$totalqty}}">{{ number_format($totalqty, 0, ',', '.') }}</span></h5>
                    <h6>Qty</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-top">
                <div class="search-set">
                    <input type="date" class="form-control" style="margin-left: 10px" name="start" id="start">
                    <input type="date" class="form-control" style="margin-left: 10px;" name="end"
                        id="end"> &nbsp;&nbsp;&nbsp;
                    <div class="search-input">
                        <a class="btn btn-searchset"><img src="{{ asset('theme/assets/img/icons/search-white.svg') }}"
                                alt="img"></a>
                    </div>
                </div>
                <div class="wordset">
                    <ul>
                        {{-- <li>
                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img
                                    src="{{ asset('theme/assets/img/icons/pdf.svg') }}" alt="img"></a>
                        </li> --}}
                        <li>
                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel" href="/purchase-export/excel"><img
                                    src="{{ asset('theme/assets/img/icons/excel.svg') }}" alt="img"></a>
                        </li>
                        <li>
                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="print"  onClick="this.href='/purchase-laporan/'+ document.getElementById('start').value + '/' + document.getElementById('end').value" target="_blank"><img src="{{ asset('theme/assets/img/icons/pdf.svg') }}" alt="img"></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table  datanew">
                    <thead>
                        <tr>
                            <th class="text-center">Transaction Number</th>
                            <th class="text-center">Employee</th>
                            <th class="text-center">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $x)
                        <tr>
                            <td class="text-center">
                                <a href="{{route('purchase.show',$x->id)}}" class="text-primary">
                                    {{ $x->number }}</a>
                            </td>
                            <td class="text-center">{{ $x->user->name }}</td>
                            <td class="text-center">{{ date('d m Y', strtotime($x->date)) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
