<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Report Penjualan</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
        }
    </style>
</head>

<body>
    <center>
        <table width="670px" cellspacing="0" cellpadding="0">
            <tr>
                <td><img src="{{ asset('theme')}}/assets/img/logo.png" width="140px" /></td>
                <td colspan="11">
                  <h3 style=" text-align: center; margin-top: 5px; font-family: Calibri, 'Trebuchet MS', sans-serif;">
                      BnS POS</h3>
                  <p
                      style=" text-align: center; margin-top: -35px; font-size: 14px; font-family: Calibri, 'Trebuchet MS', sans-serif;">
                      <br />
                      JL. Raya Kasih Sayang,
                      Purwakarta, Jawa Barat, 41151 <br />
                      Telp : (0264) 1234567, Fax : (0264) 1234567 <br />
                      Email: pt.pos@gmail.com
                  </p>
              </td>
            </tr>
            {{-- <tr>
                <td colspan="12">
                    <hr />
                </td>
            </tr> --}}
            <tr>
                <td colspan="12">
                    <p style="text-align: center; margin-bottom: -5px;"><b>INVOICE</b></p>
                </td>
            </tr>
            <tr>
                <td colspan="12">
                    <b><hr /></b>
                </td>
            </tr>
            <tr>
                <td width="90px">
                    <p
                        style="font-size: 14px; margin-top: -20px; margin-left: 05px; font-family: Calibri, 'Trebuchet MS', sans-serif;">
                        No Invoice <br />Customer <br />Tanggal
                    </p>
                </td>
                <td width="190px">
                    <p style="font-size: 14px; margin-top: -20px; font-family: Calibri, 'Trebuchet MS', sans-serif;">:
                        {{ $cetak->number }}<br />: {{ $cetak->user->name }} <br />:
                        {{ date('d / m / Y', strtotime($cetak->date)) }}
                    </p>
                </td>
                <td colspan="9">
                    <p
                        style="text-align: right; font-size: 14px; margin-right: 10px; font-family: Calibri, 'Trebuchet MS', sans-serif;">
                        No Faktur Pajak <br />Jatuh Tempo <br />Periode<br />No Kontrak<br />Keterangan
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="12"><br /></td>
            </tr>
            <tr>
                <td colspan="12">
                    <center>
                        <table border="1px" width="660px" cellspacing="0" cellpadding="0"
                            style="font-family: calibri;">
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th>Jumlah</th>
                            </tr>
                            @php
                                $ppnpph = 0;
                                $pphpph = 0;
                            @endphp
                            @foreach ($data as $item)
                                <tr style="text-align: center;">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->inventory->name }}</td>
                                    <td>Rp.{{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td>{{ $item->qty }}</td>
                                    <td style="text-align: right;">
                                        Rp.{{ number_format($item->price * $item->qty, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="5"></td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align: right;"> <b>Sub Total</b> </td>
                                <td rowspan="3"></td>
                                <td style="text-align: right;"><b>Rp.
                                        {{ number_format($harga*$kuantitas, 0, ',', '.') }}</b></td>
                            </tr>
                            
                        </table>
                    </center>
                </td>
            </tr>
            <tr>
                <td colspan="12"><br></td>
            </tr>
            <tr>
                <td colspan="12">
                    <p
                        style="text-align: right; margin: 9px; font-size: 14px; font-family: Calibri, 'Trebuchet MS', sans-serif;">
                        Purwakarta, {{ Carbon\Carbon::now()->isoFormat('D - MM - Y') }}
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="12"><br></td>
            </tr>
            <tr>
                <td colspan="12"><br></td>
            </tr>
            <tr>
                <td colspan="12"></td>
            </tr>
            <td colspan="12">
                <p
                    style="text-align: right; margin: 9px; font-size: 14px; font-family: Calibri, 'Trebuchet MS', sans-serif;">
                    <u>
                        {{auth()->user()->name}}</u><br>{{auth()->user()->role}}
                </p>
            </td>
        </table>
    </center>
    {{-- <script>
        window.print();
    </script> --}}
</body>

