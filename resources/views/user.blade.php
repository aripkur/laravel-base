@extends('layout.app')
@section('title', "Users")

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-0 border">
                <div class="card-header">Form</div>
                <div class="card-body">
                    <form id="formulir">
                        <input type="hidden" name="username" id="username">
                        <div class="form-group">
                            <label for="">Fullname</label>
                            <input type="text" class="form-control form-control-sm" id="fullname" name="fullname">
                        </div>
                        <div class="form-group">
                            <label for="">Role</label>
                            <select class="form-control select2 form-control-sm" id="role" name="role">
                                <option value=""></option>
                                <option value="ADMIN">ADMIN</option>
                                <option value="USER">USER</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-default btn-xs" id="reset_btn">Batal</button>
                        <button class="btn btn-danger btn-xs" id="save_btn">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card shadow-0 border">
                <div class="card-header">
                    <h3 class="card-title">Data</h3>
                </div>
                <div class="card-body">
                    <div class="form-group row mb-1">
                        <div class="col-md-12">
                            <input type="text" class="form-control form-control-sm" id="pencarian" placeholder="Pencarian ..." autocomplete="off">
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered text-nowrap datatables w-100" id="table">
                            <thead>
                                <tr>
                                    <th>Fullname</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('javascript')
<script type="text/javascript">
    let DATATABLE = ""
    $(document).ready(function() {
    })

    var form = (function($) {
        $("#save_btn").click( e =>{
            let form =  $("#formulir").serialize();

            $.ajax({
                method: 'POST',
                dataType: 'JSON',
                data: form,
                url: window.origin + '/api/users-save',
                beforeSend(xhr) {
                    window.isLoading(true, 'tunggu, proses simpan data...')
                },
                success: function (result) {
                    window.isLoading(false)
                    Swal.fire({
                        icon: 'success',
                        width: 600,
                        html: `<h6>${result.metadata.message}</h6>`,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        timer: 1500
                    }).then( s => {
                        DATATABLE.ajax.reload()
                        setForm(null)
                    })
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    window.isLoading(false)
                    Swal.fire({
                        icon: 'error',
                        width: 600,
                        html: `<h6>${jqXHR.responseJSON?.metadata?.message || jqXHR.statusText}</h6>`,
                        showConfirmButton: false,
                    })
                },
            });
        })
        $("#reset_btn").click( e => {
            setForm(null)
        })
        function edit(username){
            $.ajax({
                method: 'GET',
                dataType: 'JSON',
                url: `${window.origin}/api/users/${username}`,
                beforeSend(xhr) {
                    window.isLoading(true, 'tunggu, proses simpan data...')
                },
                success: function (result) {
                    window.isLoading(false)
                    Swal.fire({
                        icon: 'success',
                        width: 600,
                        html: `<h6>${result.metadata.message}</h6>`,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        timer: 1500
                    }).then( s => {
                        setForm(result.data)
                    })
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    window.isLoading(false)
                    Swal.fire({
                        icon: 'error',
                        width: 600,
                        html: `<h6>${jqXHR.responseJSON?.metadata?.message || jqXHR.statusText}</h6>`,
                        showConfirmButton: false,
                    })
                },
            });
        }
        function hapus(username){
            Swal.fire({
                html: `<h6>Yakin ingin menghapus ?</h6>`,
                icon: 'warning',
                showCancelButton: true,
                allowEscapeKey: false,
                allowOutsideClick: false,
                confirmButtonColor: 'red',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Tidak',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: 'DELETE',
                        dataType: 'JSON',
                        data: {username},
                        url: `${window.origin}/api/users/delete`,
                        beforeSend(xhr) {
                            window.isLoading(true, 'tunggu, proses hapus data...')
                        },
                        success: function (result) {
                            window.isLoading(false)
                            Swal.fire({
                                icon: 'success',
                                title: result.metadata.message,
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                timer: 1500
                            }).then(() => {
                                DATATABLE.ajax.reload()
                            })
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            window.isLoading(false)
                            Swal.fire({
                                icon: 'error',
                                width: 600,
                                html: `<h6>${jqXHR.responseJSON?.metadata?.message || jqXHR.statusText}</h6>`,
                                showConfirmButton: false,
                            })
                        },
                    });
                }
            })
        }
        function resetPassword(username){
            Swal.fire({
                html: `<h6>Yakin ingin reset password ?</h6>`,
                icon: 'warning',
                showCancelButton: true,
                allowEscapeKey: false,
                allowOutsideClick: false,
                confirmButtonColor: 'red',
                confirmButtonText: 'Ya, Reset!',
                cancelButtonText: 'Tidak',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: 'POST',
                        dataType: 'JSON',
                        data: {username},
                        url: `${window.origin}/api/users-reset-password`,
                        beforeSend(xhr) {
                            window.isLoading(true, 'tunggu, proses reset data...')
                        },
                        success: function (result) {
                            window.isLoading(false)
                            Swal.fire({
                                icon: 'success',
                                title: result.metadata.message,
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                timer: 1500
                            }).then(() => {
                                DATATABLE.ajax.reload()
                            })
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            window.isLoading(false)
                            Swal.fire({
                                icon: 'error',
                                width: 600,
                                html: `<h6>${jqXHR.responseJSON?.metadata?.message || jqXHR.statusText}</h6>`,
                                showConfirmButton: false,
                            })
                        },
                    });
                }
            })
        }
        function setForm(value = null){
            $("#username").val(value?.username || "").trigger('change')
            $("#fullname").val(value?.fullname || "").trigger('change')
            $("#role").val(value?.role || "").trigger('change')
        }

        return {
            edit,
            hapus,
            resetPassword
        }
    })(jQuery)

    var table = (function($) {
        $('#pencarian').keyup( window.setDelay(function (e) {
            DATATABLE.ajax.reload()
        }, 500))
        if ( !$.fn.DataTable.isDataTable( '#table' ) ) {
            DATATABLE = $('#table').DataTable({
                processing: true,
                serverSide: true,
                stateSave: true,
                ajax: {
                        url:`${window.origin}/api/users`,
                        type: "POST",
                        data: function (data) {
                            data.pencarian = $('#pencarian').val()
                        }
                    },
                paging: false,
                scrollY: '45vh',
                scrollX: true,
                bLengthChange: false,
                ordering: false,
                bFilter: false,
                searching: false,
                columns: [
                    {
                        data: 'fullname',
                        name: 'fullname',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'username',
                        name: 'username',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'role',
                        name: 'role',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                }
            });
        }


        return {
        }
    })(jQuery)
</script>
@endsection
