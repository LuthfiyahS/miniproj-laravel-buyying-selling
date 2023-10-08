@extends('_layout.main')

@section('title')
    BnS App
@endsection


{{-- //konten setiap menu --}}
@section('content')
    <div class="row">
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="dash-widget">
                <div class="dash-widgetimg">
                    <span><img src="{{ 'theme/assets/img/icons/dash1.svg' }}" alt="img"></span>
                </div>
                <div class="dash-widgetcontent">
                    {{-- <h5>Rp. <span class="counters" data-count="{{ number_format($totalpembelian, 0, ',', '.') }}">{{ number_format($totalpembelian, 0, ',', '.') }}</span></h5> --}}
                    <h5>Rp. <span class="counters" data-count="{{$totalpenjualan}}">{{$totalpenjualan}}</span></h5>
                    <h6>Total Sales</h6>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="dash-widget dash1">
                <div class="dash-widgetimg">
                    <span><img src="{{ 'theme/assets/img/icons/dash2.svg' }}" alt="img"></span>
                </div>
                <div class="dash-widgetcontent">
                    {{-- <h5>Rp. <span class="counters">{{ number_format($totalpenjualan, 0, ',', '.') }}</span></h5> --}}
                    <h5>Rp. <span class="counters" >{{$totalpembelian}}</span></h5>
                    <h6>Total Purchase</h6>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="dash-widget dash2">
                <div class="dash-widgetimg">
                    <span><img src="{{ 'theme/assets/img/icons/dash3.svg' }}" alt="img"></span>
                </div>
                <div class="dash-widgetcontent">
                    <h5><span class="counters">1</span></h5>
                    <h6>Qty Sales</h6>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="dash-widget dash3">
                <div class="dash-widgetimg">
                    <span><img src="{{ 'theme/assets/img/icons/dash4.svg' }}" alt="img"></span>
                </div>
                <div class="dash-widgetcontent">
                    <h5><span class="counters" data-count="100">273</span></h5>
                    <h6>Qty Purchase </h6>
                </div>
            </div>
        </div>
        {{-- <div class="col-lg-3 col-sm-6 col-12 d-flex">
            <div class="dash-count">
                <div class="dash-counts">
                    <h4>{{ $kontak }}</h4>
                    <h5>Customers</h5>
                </div>
                <div class="dash-imgs">
                    <i data-feather="user"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12 d-flex">
            <div class="dash-count das1">
                <div class="dash-counts">
                    <h4>{{ $kontak }}</h4>
                    <h5>Suppliers</h5>
                </div>
                <div class="dash-imgs">
                    <i data-feather="user-check"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12 d-flex">
            <div class="dash-count das2">
                <div class="dash-counts">
                    <h4>{{ $pembelian }}</h4>
                    <h5>Pembelian Invoice</h5>
                </div>
                <div class="dash-imgs">
                    <i data-feather="file-text"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12 d-flex">
            <div class="dash-count das3">
                <div class="dash-counts">
                    <h4>{{ $penjualan }}</h4>
                    <h5>Penjualan Invoice</h5>
                </div>
                <div class="dash-imgs">
                    <i data-feather="file"></i>
                </div>
            </div>
        </div> --}}
    </div>

    <div class="row">
        <div class="col-lg-7 col-sm-12 col-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Purchase & Sales</h5>
                </div>
                <div class="card-body">
                    {{-- <div id="salesnuryeni_charts"></div> --}}
                    {!! $chart->container() !!}
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-sm-12 col-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">New Inventory</h4>
                    <div class="dropdown">
                        <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false" class="dropset">
                            <i class="fa fa-ellipsis-v"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                                <a href="/inventories" class="dropdown-item">List Inventory</a>
                            </li>
                            <li>
                                <a href="/inventories" class="dropdown-item">Add Inventory</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive dataview">
                        <table class="table datatable ">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Inventory</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barang as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="productimgname">
                                            <a href="barang" class="product-img">
                                                @if ($item->gambar != null)
                                                    <img src="{{ url($item->gambar) }}" alt="product" />
                                                @else
                                                    <img src="{{ 'theme/assets/img/customer/customer1.jpg' }}"
                                                        alt="product" />
                                                @endif
                                            </a>
                                            <a href="barang">{{ $item->name }}</a>
                                        </td>
                                        <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        "use strict";
        $(document).ready(function() {
            if ($("#salesnuryeni_charts").length > 0) {
                //pembelian
                let pembelian = {{ Js::from($pembelian_chart) }};
                let bulan_pembelian = [];
                let jumlah_pembelian = [];
                let data_pembelian = [];
                let status = false;
                let tahun = new Date().getFullYear();
                console.log(tahun)
                for (let i = 0; i < pembelian.length; i++) {
                    let element = pembelian[i]['month'];
                    let tahun2 = pembelian[i]['year'];
                    if (tahun2 == tahun) {
                        bulan_pembelian.push(pembelian[i]['month']);
                        jumlah_pembelian.push(pembelian[i]['data']);
                    }
                }
                for (let index = 0; index < 12; index++) {
                    for (let i = 0; i < bulan_pembelian.length; i++) {
                        if (bulan_pembelian[i] == index+1) {
                            data_pembelian.push(jumlah_pembelian[i]);
                            status = true;
                        }
                    }
                    if (status == false) {
                        data_pembelian.push(0);
                    }
                    status = false;
                }

                //penjualan
                let penjualan = {{ Js::from($penjualan_chart) }};
                let bulan_penjualan = [];
                let jumlah_penjualan = [];
                let data_penjualan = [];
                let statuspenjualan = false;
                for (let i = 0; i < penjualan.length; i++) {
                    let element2 = penjualan[i]['month'];
                    let tahun22 = penjualan[i]['year'];
                    if (tahun22 == tahun) {
                        bulan_penjualan.push(penjualan[i]['month']);
                        jumlah_penjualan.push(penjualan[i]['data']);
                    }
                }
                for (let index = 0; index < 12; index++) {
                    for (let i = 0; i < bulan_penjualan.length; i++) {
                        if (bulan_penjualan[i] == index+1) {
                            data_penjualan.push(jumlah_penjualan[i]);
                            statuspenjualan = true;
                        }
                    }
                    if (statuspenjualan == false) {
                        data_penjualan.push(0);
                    }
                    statuspenjualan = false;
                }
                console.log(data_penjualan);
                var options = {
                    series: [{
                            name: "Penjualan",
                            data: data_penjualan
                        },
                        {
                            name: "Pembelian",
                            data: data_pembelian
                        },
                    ],
                    colors: ["#28C76F", "#EA5455"],
                    chart: {
                        type: "bar",
                        height: 300,
                        stacked: true,
                        zoom: {
                            enabled: true
                        },
                    },
                    responsive: [{
                        breakpoint: 280,
                        options: {
                            legend: {
                                position: "bottom",
                                offsetY: 0
                            }
                        },
                    }, ],
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: "20%",
                            //endingShape: "rounded",
                        },
                    },
                    xaxis: {
                        categories: [
                            "Jan ",
                            "Feb",
                            "Maret",
                            "April",
                            "Mei",
                            "Juni",
                            "Juli",
                            "Augustus",
                            "September",
                            "Oktober",
                            "November",
                            "Desember",
                        ],
                    },
                    legend: {
                        position: "right",
                        offsetY: 40
                    },
                    fill: {
                        opacity: 1
                    },
                };
                var chart = new ApexCharts(
                    document.querySelector("#salesnuryeni_charts"),
                    options
                );
                chart.render();
            }
        });
    </script>
    <script src="{{ $chart->cdn() }}"></script>
    {{ $chart->script() }}
@endsection
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
</script>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
