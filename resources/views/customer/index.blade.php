@extends('layouts.template')

@section('content')
    <section class="row mt-2">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Data Customer
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table1">
                            <thead>
                                <tr>
                                    <th>Aksi</th>
                                    <th>Kode Customer</th>
                                    <th>Nama Customer</th>
                                    <th>Telepon</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Aksi</th>
                                    <th>Kode Customer</th>
                                    <th>Nama Customer</th>
                                    <th>Telepon</th>
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
@include('customer.modal.updateModal')
@endsection

@section('script')
    <script>
        $('#table1').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: "{{ route('customer.index') }}"
            },
            columns: [{
                    data: 'action',
                    name: 'action'
                },
                {
                    data: 'code',
                    name: 'code'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'telepon',
                    name: 'telepon'
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
            $modal.modal('show')
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
                        let customer = res.customer

                        modalUpdate.modal('show');
                        formUpdate.find(`[name="name"]`).val(customer.name);
                        formUpdate.find(`[name="telepon"]`).val(customer.telepon);
                        formUpdate.find(`[name="code"]`).val(customer.code);

                        formSubmit(
                            $('#modalUpdate'),
                            $('#formUpdate'),
                            $('#formUpdate').find(`[type="submit"]`),
                            updateHref,
                            'PUT'
                        )
                    }).fail(err => {
                        warningNotification('Silahkan Ulangi Kembali')
                    })
                })
            })
        }
    </script>
@endsection
