@extends('layouts.template')

@section('content')
    <section class="row mt-2">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Data Kategori

                        <div class="float-end">
                            <button id="btnTambah" class="btn btn-primary btn-sm" >Tambah</button>
                        </div>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table1">
                            <thead>
                                <tr>
                                    <th>Aksi</th>
                                    <th>Kode Kategori</th>
                                    <th>Nama Kategori</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Aksi</th>
                                    <th>Kode Kategori</th>
                                    <th>Nama Kategori</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@section('modal')
@include('kategori.modal.createModal')
@include('kategori.modal.updateModal')
@endsection

@section('script')
    <script>
        $('#formCreate input[name="name"]').on('input', function () {
            const nama = $(this).val();
            const kode = nama.replace(/[aiueoAIUEO]/g, '').toUpperCase();
            $('#formCreate input[name="kode"]').val(kode);
        });

        $('#formUpdate input[name="name"]').on('input', function () {
            const nama = $(this).val();
            const kode = nama.replace(/[aiueoAIUEO]/g, '').toUpperCase();
            $('#formUpdate input[name="kode"]').val(kode);
        });

        $('#table1').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: "{{ route('kategori.index') }}"
            },
            columns: [{
                    data: 'action',
                    name: 'action'
                },
                {
                    data: 'kode',
                    name: 'kode'
                },
                {
                    data: 'name',
                    mame: 'name'
                },
            ],
            drawCallback: settings => {
                renderedEvent()
            }
        })

        const reloadDT = () => {
            $('#table1').DataTable().ajax.reload()
        }

        const modalUpdate = $('#modalUpdate')
        const formUpdate = $('#formUpdate')

        const formSubmit = ($modal, $form, $submit, $href, $method, $addedAction = null) => {
            $form.off('submit')
            $form.on('submit', function(e) {
                e.preventDefault();
                clearInvalid();

                let formData = $(this).serialize();

                ajaxSetup();
                $.ajax({
                    url: $href,
                    method: $method,
                    data: formData,
                    dataType: 'json',
                }).done(response => {
                    let {
                        message
                    } = response;
                    successNotification(message);
                    reloadDT();
                    $modal.modal('hide')
                    clearFormCreate()
                    if (addedAction) {
                        addedAction();
                    }
                }).fail(error => {
                    ajaxErrorHandling(error, $form);
                })
            })
        }

        const renderedEvent = () => {
            $.each($('.delete'), (i, deleteBtn) => {
                $(deleteBtn).off('click')
                $(deleteBtn).on('click', function(e) {
                    let {
                        deleteMessage,
                        deleteHref
                    } = $(this).data();
                    confirmation(deleteMessage, function() {
                        ajaxSetup();
                        $.ajax({
                            url: deleteHref,
                            method: 'DELETE',
                            dataType: 'json'
                        }).done(response => {
                            let {
                                message
                            } = response;
                            successNotification(message);
                            reloadDT()
                        }).fail(error => {
                            ajaxErrorHandling(error);
                        })
                    })
                })
            })

            $.each($('.edit'), (i, editBtn) => {
                $(editBtn).off('click')
                $(editBtn).on('click', function() {
                    ajaxSetup()
                    let {
                        getHref,
                        updateHref
                    } = $(this).data()
                    $.get({
                        url: getHref,
                        dataType: 'json'
                    }).done(res => {
                        console.log(res);
                        let kategori = res.kategori

                        modalUpdate.modal('show');
                        formUpdate.find(`[name="name"]`).val(kategori.name);
                        formUpdate.find(`[name="kode"]`).val(kategori.kode);

                        formSubmit(
                            $('#modalUpdate'),
                            $('#formUpdate'),
                            $('#formUpdate').find(`[type="submit"]`),
                            updateHref,
                            'PUT'
                        )
                    }).fail(err => {
                        console.log(err);
                    })
                })
            })
        }

        $('#btnTambah').on('click', function() {
            $('#modalCreate').modal('show')
        })

        formSubmit(
            $('#modalCreate'),
            $('#formCreate'),
            $('#formCreate').find(`[type='submit']`),
            "{{ route('kategori.store') }}",
            'POST'
        )
    </script>
@endsection
