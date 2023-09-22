
<!DOCTYPE html>
<html>
    <head>
        <style>
            table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
            }
        </style>
    </head>

    <body>
        <center>
            <p>LAPORAN DANA PENGUATAN MODAL</p>
            <p>BIDANG PERDAGANGAN TRADISIONAL DINAS PERINDUSTRIAN DAN PERDAGANGAN</p>
        </center>
        <br>
        @foreach ($result as $item) 
            <p>Tanggal Pencairan : {{ $item['disbursement_date'] }}</p>
            <p>Tanggal Jatuh Tempo : {{ $item['due_date'] }}</p>
            <table>
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">Kode penerima DPM</th>
                    <th rowspan="2">Nama</th>
                    <th rowspan="2">Alamat</th>
                    <th rowspan="2">Ketua</th>
                    <th colspan="3">Pinjaman</th>
                    <th colspan="3">Angsuran per bulan</th>
                    <th colspan="3">Pengembalian s.d bulan lalu</th>
                    <th colspan="3">Pengembalian bulan ini</th>
                    <th colspan="3">Pengembalian s.d bulan ini</th>
                    <th colspan="3">Target pengembalian</th>
                    <th colspan="3">Tunggakan</th>
                    <th colspan="3">Sisa pinjaman</th>
                    <th rowspan="2">Keterangan</th>
                </tr>

                <tr>
                    <th>Pokok</th>
                    <th>Kontribusi</th>
                    <th>Jumlah</th>

                    <th>Pokok</th>
                    <th>Kontribusi</th>
                    <th>Jumlah</th>

                    <th>Pokok</th>
                    <th>Kontribusi</th>
                    <th>Jumlah</th>

                    <th>Pokok</th>
                    <th>Kontribusi</th>
                    <th>Jumlah</th>

                    <th>Pokok</th>
                    <th>Kontribusi</th>
                    <th>Jumlah</th>

                    <th>Pokok</th>
                    <th>Kontribusi</th>
                    <th>Jumlah</th>

                    <th>Pokok</th>
                    <th>Kontribusi</th>
                    <th>Jumlah</th>

                    <th>Pokok</th>
                    <th>Kontribusi</th>
                    <th>Jumlah</th>
                </tr>

                @foreach ($item['data'] as $key => $data)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $data['kode_dpm'] }}</td>
                        <td>{{ $data['nama'] }}</td>
                        <td>{{ $data['alamat'] }}</td>
                        <td>{{ $data['ketua'] }}</td>
                        <td>{{ $data['pinj_pokok'] }}</td>
                        <td>{{ $data['pinj_kontr'] }}</td>
                        <td>{{ $data['pinj_jml'] }}</td>
                        <td>{{ $data['angs_pokok'] }}</td>
                        <td>{{ $data['angs_kontr'] }}</td>
                        <td>{{ $data['angs_jml'] }}</td>
                        <td>{{ $data['kmb_sd_bln_lalu_pokok'] }}</td>
                        <td>{{ $data['kmb_sd_bln_lalu_kontr'] }}</td>
                        <td>{{ $data['kmb_sd_bln_lalu_jml'] }}</td>
                        <td>{{ $data['kmb_bln_ini_pokok'] }}</td>
                        <td>{{ $data['kmb_bln_ini_kontr'] }}</td>
                        <td>{{ $data['kmb_bln_ini_jml'] }}</td>
                        <td>{{ $data['kmb_sd_bln_ini_pokok'] }}</td>
                        <td>{{ $data['kmb_sd_bln_ini_kontr'] }}</td>
                        <td>{{ $data['kmb_sd_bln_ini_jml'] }}</td>
                        <td>{{ $data['target_kmb_pokok'] }}</td>
                        <td>{{ $data['target_kmb_kontr'] }}</td>
                        <td>{{ $data['target_kmb_jml'] }}</td>
                        <td>{{ $data['tunggakan_pokok'] }}</td>
                        <td>{{ $data['tunggakan_kontr'] }}</td>
                        <td>{{ $data['tunggakan_jml'] }}</td>
                        <td>{{ $data['sisa_pinj_pokok'] }}</td>
                        <td>{{ $data['sisa_pinj_kontr'] }}</td>
                        <td>{{ $data['sisa_pinj_jml'] }}</td>
                        <td>{{ $data['keterangan'] }}</td>
                    </tr>
                @endforeach
            </table>
            <br>
        @endforeach
    </body>
</html>