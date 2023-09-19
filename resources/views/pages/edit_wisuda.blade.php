@extends('layouts.app')
@section('title', 'Edit Data Wisuda')
@section('page-title')
<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 w-100   ">
    <h1 class="page-heading d-flex text-dark fw-bold flex-column justify-content-center my-0">
        Edit Data Wisuda
    </h1>
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap p-0">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-1">
            <!--begin::Page Heading-->
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item text-muted">
                        <a href="" class="text-muted">Kelola Data &nbsp;</a>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="" class="text-muted">Wisuda &nbsp;</a>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="" class="text-muted">Edit &nbsp;</a>
                    </li>
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page Heading-->
        </div>
        <!--end::Info-->
        <!--begin::Toolbar-->
    </div>
</div>
@endsection
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card card-flush">
            <form action="{{route('wisuda.update', $gelombang->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body fs-6 text-gray-700">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> Ada beberapa masalah dengan input Anda.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
        
                    <div class="mb-5">
                        <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Jenis Wisuda</Label>
                        <select name="jenis" id="jenis" class="form-control" required>
                            <option value="OFFLINE" @if($gelombang->jenis == 'OFFLINE') selected @endif>OFFLINE</option>
                            <option value="ONLINE" @if($gelombang->jenis == 'ONLINE') selected @endif>ONLINE</option>
                        </select>
                    </div>
        
                    <div class="mb-5">
                        <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Tanggal Wisuda</Label>
                        <input type="date" name="date" id="date" class="form-control" value="{{$gelombang->tanggal_wisuda}}" required>
                    </div>
        
                    <div class="mb-5">
                        <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Kuota Wisuda</Label>
                        <input type="number" name="kuota" id="kuota" class="form-control" value="{{$gelombang->kuota}}" required>
                    </div> 
        
                    <div class="footer d-flex justify-content-end py-10">
                        <div class="d-flex justify-content-end">
                            <a href="{{route('wisuda.index')}}" id="cancelButton" class="btn btn-light btn-active-light-primary me-3">Batalkan</a>
                            <button id="save-user" type="submit" class="btn btn-active-primary btn-primary"
                                data-kt-indicator="off">
                                <span class="indicator-label">
                                    Update
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection