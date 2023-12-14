@extends('layouts.main')

@section('title', 'Detail Isian')


@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Detail Isian</h4>

                <div class="table-responsive">
                    <button id="btnPrint" class="btn btn-primary">Print Table</button>
                    {{-- btn print --}}
                    <table class="table datatables table-hover responsive nowrap" style="width:100%" id="dataTable-1">
                        <tr>
                            <th>Nama</th>
                            <td>{{ $isian->user->name }}</td>
                        </tr>

                        <tr>
                            <th>Tanggal</th>
                            <td>{{ $isian->tanggal }}</td>
                        </tr>
                        <tr>
                            <th>Jam Mulai</th>
                            <td>{{ $isian->jam_mulai }}</td>
                        </tr>
                        <tr>
                            <th>Jam Selesai</th>
                            <td>{{ $isian->jam_selesai }}</td>

                        </tr>

                        <tr>
                            <th>Kegiatan</th>
                            <td>{{ $isian->kegiatan }}</td>
                        </tr>
                        <tr>
                            <th>Progres</th>
                            <td>{{ $isian->progres }}</td>
                        </tr>

                        <tr>
                            <th>Data Dukung</th>
                            <td><a href="{{ asset('data_dukung/'.$isian->data_dukung) }}" target="_blank">{{ $isian->data_dukung }}</a></td>
                        </tr>
                        <tr>
                            <th>Link Foto</th>
                            <td><a href="{{ $isian->link_foto }}" target="_blank">{{ $isian->link_foto }}</a></td>
                        </tr>


                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    // Function untuk mencetak tabel
    function printTable() {
        var printWindow = window.open('', '_blank');
        printWindow.document.write('<html><head><title>Print Table</title>');
        // Tambahkan tautan ke Bootstrap CSS
        printWindow.document.write('<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">');
        printWindow.document.write('</head><body>');
        printWindow.document.write('<div class="container mt-3">');
        printWindow.document.write('<h2>Detail Isian</h2>');
        printWindow.document.write(document.getElementById('dataTable-1').outerHTML);
        printWindow.document.write('</div></body></html>');
        printWindow.document.close();

        // Jalankan fungsi print() setelah window dibuka
        printWindow.onload = function() {
            printWindow.print();
        }

    }

    // Event listener untuk tombol Print
    document.getElementById('btnPrint').addEventListener('click', function() {
        printTable();
    });

</script>
<script>
    $('#dataTable-1').DataTable({
        autoWidth: true,
        // "lengthMenu": [
        //     [16, 32, 64, -1],
        //     [16, 32, 64, "All"]
        // ]
        dom: 'Bfrtip',


        lengthMenu: [
            [10, 25, 50, -1]
            , ['10 rows', '25 rows', '50 rows', 'Show all']
        ],

        buttons: [{
                extend: 'colvis'
                , className: 'btn btn-primary btn-sm'
                , text: 'Column Visibility',
                // columns: ':gt(0)'


            },

            {

                extend: 'pageLength'
                , className: 'btn btn-primary btn-sm'
                , text: 'Page Length',
                // columns: ':gt(0)'
            },


            // 'colvis', 'pageLength',

            {
                extend: 'excel'
                , className: 'btn btn-primary btn-sm'
                , exportOptions: {
                    columns: [0, ':visible']
                }
            },

            // {
            //     extend: 'csv',
            //     className: 'btn btn-primary btn-sm',
            //     exportOptions: {
            //         columns: [0, ':visible']
            //     }
            // },
            {
                extend: 'pdf'
                , className: 'btn btn-primary btn-sm'
                , exportOptions: {
                    columns: [0, ':visible']
                }
            },

            {
                extend: 'print'
                , className: 'btn btn-primary btn-sm'
                , exportOptions: {
                    columns: [0, ':visible']
                }
            },

            // converto word document

            {
                extend: 'word'
                , className: 'btn btn-primary btn-sm'
                , exportOptions: {
                    columns: [0, ':visible']
                }
            },


            // 'pageLength', 'colvis',
            // 'copy', 'csv', 'excel', 'print'

        ]
    , });

</script>
@if(Session::get('store'))
<script>
    Swal.fire({
        icon: 'success'
        , title: 'Good'
        , text: 'Data Berhasil Ditambahkan'
    , });

</script>
@endif
@if(Session::get('update'))
<script>
    Swal.fire({
        icon: 'success'
        , title: 'Good'
        , text: 'Data Berhasil Diubah'
    , });

</script>
@endif
@if(Session::get('delete'))
<script>
    Swal.fire({
        icon: 'success'
        , title: 'Good'
        , text: 'Data Berhasil Dihapus'
    , });

</script>
@endif
@endsection
