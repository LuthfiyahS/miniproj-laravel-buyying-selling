<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cetak Laporan Biaya</title>
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
                <td><img src="{{ asset('theme') }}/assets/img/logo.png" width="140px" /></td>
                <td colspan="11">
                    <h3 style=" text-align: center; margin-top: 5px; font-family: Calibri, 'Trebuchet MS', sans-serif;">
                        BnS POS</h3>
                    <p
                        style=" text-align: center; margin-top: -30px; font-size: 14px; font-family: Calibri, 'Trebuchet MS', sans-serif;">
                        <br />
                        JL. Raya Kasih Sayang,
                        Purwakarta, Jawa Barat, 41151 <br />
                        Telp : (0264) 1234567, Fax : (0264) 1234567 <br />
                        Email: pt.pos@gmail.com
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="12">
                    <hr />
                </td>
            </tr>
            <tr>
                <td colspan="12">
                    <p style="text-align: center; margin: 1px; font-family: Calibri, 'Trebuchet MS', sans-serif;"">
                        <b>DATA INVENTORY</b>
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="12">
                    <hr />
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
                                <th>Price</th>
                                <th>Stock</th>
                            </tr>
                            @foreach ($data as $item)
                                <tr>
                                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                                    <td style="text-align: center;">{{ $item->name }}</td>
                                    <td style="text-align: center;">Rp {{ $item->price }}</td>
                                    <td style="text-align: center;">{{ $item->stock }}</td>
                                </tr>
                            @endforeach


                        </table>
                    </center>
                </td>
            </tr>
    </center>
    {{-- <script>
        window.print();
    </script> --}}
</body>
