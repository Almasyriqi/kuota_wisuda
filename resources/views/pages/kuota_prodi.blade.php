@extends('layouts.app')
@section('title', 'Kuota Prodi')
@section('page-title')
<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 w-100   ">
    <h1 class="page-heading d-flex text-dark fw-bold flex-column justify-content-center my-0">
        Kuota Prodi Wisuda Ke-{{$gelombang->id}}
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
                        <a href="" class="text-muted">Kuota Prodi &nbsp;</a>
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
<hr class="mt-0">
<div class="row justify-content-center mt-5">
    <div class="col-md-10">
        <div class="card card-flush">
            <div class="card-body fs-6 text-gray-700">
                <h3>Kuota Gelombang : {{$gelombang->kuota}}</h3>
                <h3>Kuota Saat Ini : {{$gelombang->current_kuota}}</h3>
                <table id="table" class="table align-middle table-row-dashed fs-6 gy-5">
                    <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th>ID</th>
                            <th>Nama Prodi</th>
                            <th>Nama Jurusan</th>
                            <th>Kuota</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold fs-7 text-gray-600">
                        @foreach ($prodi as $item)
                        <tr class="text-start">
                            <td>{{$item->id}}</td>
                            <td>{{$item->nama}}</td>
                            <td>{{$item->jurusan->nama}}</td>
                            <td>{{$item->kuota}}</td>
                            <td>
                                <button type="button" class="btn btn-active-primary btn-primary ms-2 setButton"
                                    data-bs-toggle="modal" data-bs-target="#kt_modal_1" data-id="{{$item->id}}"
                                    data-name="{{$item->nama}}" data-kuota="{{$item->kuota}}">
                                    Set Kuota
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" id="kt_modal_1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{route('kuota_prodi.store')}}" method="post">
                @csrf
                <div class="modal-header">
                    <h3 class="modal-title" id="title">Set Kuota Prodi</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <h3>Kuota Gelombang : {{$gelombang->kuota}}</h3>
                    <h3>Kuota Saat Ini : {{$gelombang->current_kuota}}</h3>
                    <hr>
                    <input type="hidden" name="gelombang_id" id="gelombang_id" value="{{$gelombang->id}}">
                    <input type="hidden" name="prodi_id" id="prodi_id">
                    <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Kuota</Label>
                    <input type="number" class="form-control" name="kuota" id="kuota" placeholder="Masukkan nama kuota"
                        value="{{old('kuota')}}" required>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    // datatable
    $("#table").DataTable({
        "searching": true,
        "ordering": true,
        "info": false,
        "autoWidth": false,
        "responsive": true,
    });

        $(".setButton").on("click", function() {
            // Mendapatkan nilai data-id dari elemen yang diklik
            var dataId = $(this).data("id");
            var dataNama = $(this).data("name");
            var dataKuota = $(this).data("kuota");
            $('#title').text(`Set Kuota Prodi ${dataNama}`);
            $('#prodi_id').val(dataId);
            $('#kuota').val(dataKuota);
        });
</script>
@endpush