@extends('layouts.main')

@section('title', 'Isian')


@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Isian</h4>

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
                                <th>Tanggal</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th>Kegiatan</th>
                                <th>Progres</th>
                                <th>Data Dukung</th>
                                <th>File Dukung</th>

                                <th>Action</th>

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
                                <td>
                                    <?php
                                    $tanggal = $data->tanggal;
                                    $tanggal = date('d-m-Y', strtotime($tanggal));
                                    echo $tanggal;
                                    ?>
                                </td>
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


                                @if(Auth::user()->id_role == 1 || Auth::user()->id_role == 3)
                                <td>
                                    <a href="/isian/detail/{{ $data->id }}" target="_blank"><button class="btn btn-warning btn-sm"><i class="fas fa-eye"></i></button></a>
                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#edit{{ $data->id }}"><i class="fas fa-pencil-alt"></i></button>
                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete{{ $data->id }}"><i class="fas fa-trash"></i></button>
                                </td>
                                @else
                                <td>
                                    <a href="/isian/detail/{{ $data->id }}" target="_blank"><button class="btn btn-warning btn-sm"><i class="fas fa-eye"></i></button></a>
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
                                        <form action="/isian/{{ $data->id }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <div class="modal-body">

                                                <p>Anda yakin ingin menghapus data {{ $data->user->name }} ?</p>

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
                                        <form action="/isian/{{ $data->id }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('put')
                                            <div class="modal-body">
                                                <div hidden class="form-group">
                                                    <label for="recipient-name" class="control-label">Id User</label>
                                                    <input name="id_user" value="{{ Auth::user()->id }}" type="text" class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label for="recipient-name" class="control-label">Tanggal</label>
                                                    <input name="tanggal" type="date" class="form-control" value="{{ $data->tanggal }}">
                                                </div>

                                                <div class="form-group">
                                                    <label for="recipient-name" class="control-label">Jam Mulai</label>
                                                    <input name="jam_mulai" type="time" class="form-control" value="{{ $data->jam_mulai }}">
                                                </div>

                                                <div class="form-group">
                                                    <label for="recipient-name" class="control-label">Jam Selesai</label>
                                                    <input name="jam_selesai" type="time" class="form-control" value="{{ $data->jam_selesai }}">
                                                </div>


                                                <div class="form-group">
                                                    <label for="recipient-name" class="control-label">Kegiatan</label>
                                                    <textarea name="kegiatan" class="form-control" rows="2">{{ $data->kegiatan }}</textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label for="recipient-name" class="control-label">Progres</label>
                                                    <select name="progres" class="form-control" id="">
                                                        <option value="" disabled selected>Pilih Progres</option>
                                                        <option value="Selesai" @if($data->progres == 'Selesai') selected @endif>Selesai</option>
                                                        <option value="Sedang Berjalan" @if($data->progres == 'Sedang Berjalan') selected @endif>Sedang Berjalan</option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="recipient-name" class="control-label">Data Dukung</label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Upload</span>
                                                        </div>
                                                        <div class="custom-file">
                                                            <input name="data_dukung" type="file" class="custom-file-input" id="inputGroupFile01">
                                                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="recipient-name" class="control-label">File Dukung</label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Upload</span>
                                                        </div>
                                                        <div class="custom-file">
                                                            <input name="link_foto" type="file" class="custom-file-input" id="inputGroupFile01">
                                                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                                        </div>
                                                    </div>
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
                            <form action="/isian" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div hidden class="form-group">
                                        <label for="recipient-name" class="control-label">Id User</label>
                                        <input name="id_user" value="{{ Auth::user()->id }}" type="text" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">Tanggal</label>
                                        <input name="tanggal" type="date" class="form-control" value="" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">Jam Mulai</label>
                                        <input name="jam_mulai" type="time" class="form-control" value="" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">Jam Selesai</label>
                                        <input name="jam_selesai" type="time" class="form-control" value="" required>
                                    </div>


                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">Kegiatan</label>
                                        <textarea name="kegiatan" class="form-control" rows="2" required></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">Progres</label>
                                        <select name="progres" class="form-control" id="" required>
                                            <option value="" disabled selected>Pilih Progres</option>
                                            <option value="Selesai">Selesai</option>
                                            <option value="Sedang Berjalan">Sedang Berjalan</option>
                                        </select>
                                    </div>



                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">Data Dukung</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Upload</span>
                                            </div>
                                            <div class="custom-file">
                                                <input name="data_dukung" type="file" class="custom-file-input" id="inputGroupFile01">
                                                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">File Dukung</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Upload</span>
                                            </div>
                                            <div class="custom-file">
                                                <input name="link_foto" type="file" class="custom-file-input" id="inputGroupFile01">
                                                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                            </div>
                                        </div>
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
@endsection
