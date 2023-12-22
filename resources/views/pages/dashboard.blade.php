@extends('layouts.main')

@section('title', 'Dashboard')

@section('breadcrumb')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mt-2">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>


                <?php

                                    $nomer = 1;

                                    ?>

                @foreach($errors->all() as $error)
                <li>{{ $nomer++ }}. {{ $error }}</li>
                @endforeach
            </div>
            @endif
            <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Dashboard</h3>
            <div class="d-flex align-items-center">
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="card">
    <form action="/dashboard" method="post">
        @csrf
        <div class="card-body">
            <div class="form-body">
                <div class="form-group">
                    <div class="row align-items-center text-center justify-content-center">
                        <div class="col-md-3">
                            <h4 class="card-title">Pilih Tanggal</h4>
                            <div class="form-group">
                                <input name="date1" value="{{ Session::get('date1') }}" type="date" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <h4 class="card-title">Pilih Tanggal</h4>

                            <div class="form-group">
                                <input name="date2" value="{{ Session::get('date2') }}" type="date" class="form-control">
                            </div>
                        </div>


                        <div class="col-md-3">
                            <h4 class="card-title">Pilih User</h4>
                            <div class="form-group">
                                <select name="id_user" class="form-control" id="exampleFormControlSelect1">
                                    @if (Session::get('id_user') != null)
                                    <option selected value="{{ Session::get('id_user') }}">
                                        <?php
                                        $userr = DB::table('tb_user')->where('id', Session::get('id_user'))->first();
                                        echo $userr->name;
                                        ?>

                                    </option>
                                    @else
                                    <option selected value="0">-- Pilih --</option>
                                    @endif

                                    @foreach ($user as $datauser)
                                    <option value="{{ $datauser->id }}">{{ $datauser->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 align-items-center text-center row justify-content-center">
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </div>


                    </div>
                </div>
            </div>

        </div>

    </form>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table datatables table-hover responsive nowrap" style="width:100%" id="dataTable-1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Tanggal</th>
                        <th>Jam Mulai</th>
                        <th>Jam Selesai</th>

                        <th>Kegiatan</th>
                        <th>Progres</th>

                        <th>Data Dukung</th>
                        <th>Link Foto</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $no = 1;
                    @endphp
                    @foreach($isian as $data)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $data->user->name }}</td>
                        <td>{{ $data->tanggal }}</td>
                        <td>{{ $data->jam_mulai }}</td>
                        <td>{{ $data->jam_selesai }}</td>

                        <td>{{ $data->kegiatan }}</td>
                        <td>{{ $data->progres }}</td>


                        <td>
                            <a href="{{ asset('data_dukung/'.$data->data_dukung) }}" target="_blank">{{ $data->data_dukung }}</a>
                        </td>
                        <td>
                            <a href="{{ $data->link_foto }}" target="_blank">{{ $data->link_foto }}</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('script')
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

            // 'pageLength', 'colvis',
            // 'copy', 'csv', 'excel', 'print'

        ]
    , });

</script>
@if(Session::get('success'))
<script>
    Swal.fire({
        icon: 'success'
        , title: 'Good'
        , text: 'Login Berhasil'
    , });

</script>
@endif
@if(Session::get('profilupdate'))
<script>
    Swal.fire({
        icon: 'success'
        , title: 'Good'
        , text: 'Profil Berhasil Diubah'
    , });

</script>
@endif
@if(Session::get('sudahlogin'))
<script>
    Swal.fire({
        icon: 'success'
        , title: 'Good'
        , text: 'Anda Sudah Login'
    , });

</script>
@endif
@if(Session::get('error'))
<script>
    Swal.fire({
        icon: 'error'
        , title: 'Oops...'
        , text: 'Anda tidak memiliki akses'
    , });

</script>
@endif
@endsection
