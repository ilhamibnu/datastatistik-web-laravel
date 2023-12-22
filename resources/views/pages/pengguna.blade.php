@extends('layouts.main')

@section('title', 'Pengguna')


@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Pengguna</h4>

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
                <div class="table-responsive">
                    @if(Auth::user()->id_role == 2)
                    @else
                    <div class="align-right text-right mb-3">
                        <button class="btn btn-primary btn-sm mb-3" data-toggle="modal" data-target="#add"><i class="fas fa-plus"></i><span> Tambah</span></button>
                    </div>
                    @endif
                    <table class="table datatables table-hover responsive nowrap" style="width:100%" id="dataTable-1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Foto</th>
                                <th>Role</th>
                                @if(Auth::user()->id_role == 2)
                                @else
                                <th>Action</th>
                                @endif


                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no = 1;
                            @endphp
                            @foreach($pengguna as $data)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->email }}</td>
                                <td>

                                    <img src="{{ asset('foto-user/'.$data->foto) }}" alt="user" class="rounded-circle" width="40">
                                </td>
                                <td>{{ $data->role->name }}</td>
                                @if(Auth::user()->id_role == 2)
                                @else
                                <td>
                                    {{-- <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#detail{{ $data->id }}"><i class="fas fa-eye"></i></button> --}}
                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#edit{{ $data->id }}"><i class="fas fa-pencil-alt"></i></button>
                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete{{ $data->id }}"><i class="fas fa-trash"></i></button>
                                </td>
                                @endif

                            </tr>

                            <!-- Modal Delete -->

                            <div id="delete{{ $data->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">Delete</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        </div>
                                        <form action="/pengguna/{{ $data->id }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <div class="modal-body">

                                                <p>Anda yakin ingin menghapus data {{ $data->name }} ?</p>

                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Delete</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>


                            <!-- Modal Edit -->
                            <div id="edit{{ $data->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">Edit</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        </div>
                                        <form action="/pengguna/{{ $data->id }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('put')
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="recipient-name" class="control-label">Name</label>
                                                    <input name="name" value="{{ $data->name }}" type="text" class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label for="recipient-name" class="control-label">Email</label>
                                                    <input name="email" value="{{ $data->email }}" type="text" class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label for="recipient-name" class="control-label">Foto</label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Upload</span>
                                                        </div>
                                                        <div class="custom-file">
                                                            <input name="foto" type="file" class="custom-file-input" id="inputGroupFile01">
                                                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-4">
                                                    <label for="exampleFormControlSelect1">Role</label>
                                                    <select name="id_role" class="form-control" id="exampleFormControlSelect1">
                                                        <option selected value="{{ $data->role->id }}">{{ $data->role->name }}</option>
                                                        @foreach($role as $datarole)
                                                        <option value="{{ $datarole->id }}">{{ $datarole->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="recipient-name" class="control-label">Password</label>
                                                    <input name="password" value="" type="password" class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label for="recipient-name" class="control-label">Re Password</label>
                                                    <input name="repassword" value="" type="password" class="form-control">
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>



                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Modal Add -->
                <div id="add" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">Add</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <form action="/pengguna" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">Name</label>
                                        <input name="name" value="" type="text" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">Email</label>
                                        <input name="email" value="" type="text" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">Foto</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Upload</span>
                                            </div>
                                            <div class="custom-file">
                                                <input name="foto" type="file" class="custom-file-input" id="inputGroupFile01" required>
                                                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-4">
                                        <label for="exampleFormControlSelect1">Role</label>
                                        <select name="id_role" class="form-control" id="exampleFormControlSelect1" required>
                                            <option selected disabled value="">Pilih Role</option>
                                            @foreach($role as $datarole)
                                            <option value="{{ $datarole->id }}">{{ $datarole->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">Password</label>
                                        <input name="password" value="" type="password" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">Re Password</label>
                                        <input name="repassword" value="" type="password" class="form-control" required>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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
@if(Session::get('gagal'))
<script>
    Swal.fire({
        icon: 'error'
        , title: 'Oops..'
        , text: 'Data Masih Memiliki Relasi'
    , });

</script>
@endif
@endsection
