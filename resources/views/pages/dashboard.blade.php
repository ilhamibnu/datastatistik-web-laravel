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
            <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Good Morning {{ Auth::user()->name }}</h3>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a>
                        </li>
                    </ol>
                </nav>

            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
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
