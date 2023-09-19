@extends('layouts.app')
@section('title', 'Manajemen Prodi')
@section('page-title')
<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 w-100   ">
    <h1 class="page-heading d-flex text-dark fw-bold flex-column justify-content-center my-0">
        Manajemen Prodi Jurusan {{$jurusan->nama}}
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
                        <a href="" class="text-muted">Jurusan &nbsp;</a>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="" class="text-muted">Prodi &nbsp;</a>
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
    <div class="col-md-6">
        <div class="card card-flush">
            <div class="card-header">
                <div class="card-toolbar flex-row-fluid justify-content-start gap-5">
                    <button type="button" id="addButton" class="btn btn-active-primary btn-primary ms-2"
                        data-bs-toggle="modal" data-bs-target="#kt_modal_1">
                        <span class="svg-icon svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                    transform="rotate(-90 11.364 20.364)" fill="currentColor"></rect>
                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"></rect>
                            </svg></span>
                        Tambah
                    </button>
                </div>
            </div>
            <div class="card-body fs-6 text-gray-700">
                <table id="table" class="table align-middle table-row-dashed fs-6 gy-5">
                    <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th>ID</th>
                            <th>Nama Prodi</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold fs-7 text-gray-600">
                        @foreach ($prodi as $item)
                        <tr class="text-start">
                            <td>{{$item->id}}</td>
                            <td>{{$item->nama}}</td>
                            <td>
                                <div class="dropdown text-start">
                                    <button type="button"
                                        class="btn btn-secondary btn-sm btn-active-light-primary rotate opacity-50"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start">
                                        Actions
                                        <span class="svg-icon svg-icon-3 rotate-180 ms-3 me-0">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                        </span>
                                    </button>
                                    <!--begin::Menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-auto min-w-200 mw-300px"
                                        data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <button class="menu-link px-3 edit" data-id="{{$item->id}}"
                                                data-bs-toggle="modal" data-bs-target="#kt_modal_2">
                                                Edit Prodi
                                            </button>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu separator-->
                                        <div class="separator mb-3 opacity-75"></div>
                                        <!--end::Menu separator-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">
                                                Hapus
                                            </a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu-->
                                </div>
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
            <form action="{{route('prodi.store')}}" method="post">
                @csrf
                <div class="modal-header">
                    <h3 class="modal-title">Tambah Prodi</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <input type="hidden" name="jurusan_id" value="{{$jurusan->id}}">
                    <div class="mb-5">
                        <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Jenjang</Label>
                        <select name="jenjang" class="form-control" required>
                            <option value="">Pilih Jenjang</option>
                            <option value="D3">D3</option>
                            <option value="D4">D4</option>
                            <option value="S2">S2</option>
                        </select>
                    </div>
                    <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Nama Prodi</Label>
                    <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukkan nama prodi"
                        value="{{old('name')}}" required>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" id="kt_modal_2">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="#" class="update" method="post">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h3 class="modal-title">Edit Prodi</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <input type="hidden" name="jurusan_id" value="{{$jurusan->id}}">
                    <select name="jenjang" class="form-control" id="jenjang" required>
                        <option value="">Pilih Jenjang</option>
                        <option value="D3">D3</option>
                        <option value="D4">D4</option>
                        <option value="S2">S2</option>
                    </select>
                    <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Nama Prodi</Label>
                    <input type="text" class="form-control" name="edit_nama" id="edit_nama" placeholder="Masukkan nama prodi"
                        value="{{old('name')}}" required>
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

        $(".edit").on("click", function() {
            // Mendapatkan nilai data-id dari elemen yang diklik
            var dataId = $(this).data("id");
            var modal = $('#kt_modal_2');
            var form = modal.find("form");
            
            // Melakukan tindakan sesuai dengan nilai data-id
            var url = '{{route("prodi.edit", ":id")}}';
            var url_action = '{{route("prodi.update", ":id")}}';
            url = url.replace(":id", dataId);
            url_action = url_action.replace(":id", dataId);
            form.attr("action", url_action);

            $.getJSON(url, function(response) {
                $('#edit_nama').val(response.nama_prodi);
                $('#jenjang').val(response.jenjang);
            });
        });
</script>
@endpush