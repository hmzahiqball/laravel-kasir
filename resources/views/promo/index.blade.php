@extends('layouts.template')

@section('content')
<section class="row mt-2">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    Kelola Promo & Pajak

                    <div class="float-end">
                        <button id="btnTambah" class="btn btn-primary btn-sm">Tambah Promo</button>
                    </div>
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <label for="taxInput">Pajak (%):</label>
                    <input type="number" id="taxInput" class="form-control w-25" placeholder="Contoh: 12">
                    <button id="btnSimpanPajak" class="btn btn-success btn-sm mt-2">Simpan Pajak</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="table1">
                        <thead>
                            <tr>
                                <th>Aksi</th>
                                <th>Kode Promo</th>
                                <th>Nama Promo</th>
                                <th>Tipe</th>
                                <th>Nilai</th>
                                <th>Kuota</th>
                                <th>Min Belanja</th>
                                <th>Mulai</th>
                                <th>Berakhir</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Aksi</th>
                                <th>Kode Promo</th>
                                <th>Nama Promo</th>
                                <th>Tipe</th>
                                <th>Nilai</th>
                                <th>Kuota</th>
                                <th>Min Belanja</th>
                                <th>Mulai</th>
                                <th>Berakhir</th>
                                <th>Status</th>
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
@include('promo.modal.createModal')
@include('promo.modal.updateModal')
@endsection

@section('script')
<script>

    fetch('/promo/setting/gettax')
        .then(res => res.json())
        .then(res => {
            console.log(res.tax);
            if (res.success) {
                document.getElementById('taxInput').value = res.tax;
            }
        });

    const promoTable = $('#table1').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('promo.index') }}",
        columns: [
            { data: 'action', name: 'action' },
            { data: 'kode', name: 'kode' },
            { data: 'name', name: 'name' },
            { data: 'tipe', name: 'tipe' },
            { data: 'nilai', name: 'nilai' },
            { data: 'kuota', name: 'kuota' },
            { data: 'min_belanja', name: 'min_belanja' },
            { data: 'tanggal_mulai', name: 'tanggal_mulai' },
            { data: 'tanggal_akhir', name: 'tanggal_akhir' },
            { data: 'is_active', name: 'is_active' },
        ],
        drawCallback: function () {
            renderedEvent();
        }
    });

    const reloadDT = () => promoTable.ajax.reload();

    $('#btnTambah').on('click', function() {
        $('#modalCreate').modal('show');
    });

    $('#btnSimpanPajak').on('click', function () {
        const tax = $('#taxInput').val();
        ajaxSetup();
        $.ajax({
            url: '{{ route('setting.tax') }}',
            method: 'POST',
            data: { tax_percentage: tax },
            success: function (res) {
                successNotification('Pajak berhasil disimpan');
            },
            error: function (err) {
                ajaxErrorHandling(err);
            }
        });
    });

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
                successNotification(response.message);
                reloadDT();
                $modal.modal('hide');
                clearFormCreate();
                if (addedAction) {
                    addedAction();
                }
            }).fail(error => {
                ajaxErrorHandling(error, $form);
            });
        });
    }

    const renderedEvent = () => {
        $('.edit').on('click', function () {
            let getHref = $(this).data('get-href');
            let updateHref = $(this).data('update-href');

            $.get(getHref, function (res) {
                const promo = res.promo;
                $('#modalUpdate input[name="name"]').val(promo.name);
                $('#modalUpdate input[name="kode"]').val(promo.kode);
                $('#modalUpdate select[name="tipe"]').val(promo.tipe);
                $('#modalUpdate input[name="nilai"]').val(promo.nilai);
                $('#modalUpdate input[name="kuota"]').val(promo.kuota);
                $('#modalUpdate input[name="min_belanja"]').val(promo.min_belanja);
                $('#modalUpdate input[name="tanggal_mulai"]').val(promo.tanggal_mulai);
                $('#modalUpdate input[name="tanggal_akhir"]').val(promo.tanggal_akhir);
                $('#modalUpdate select[name="is_active"]').val(promo.is_active);

                formSubmit(
                    $('#modalUpdate'),
                    $('#formUpdate'),
                    $('#formUpdate').find(`[type='submit']`),
                    updateHref,
                    'PUT'
                );

                $('#modalUpdate').modal('show');
            });
        });

        $('.delete').on('click', function () {
            let deleteHref = $(this).data('delete-href');
            let deleteMessage = $(this).data('delete-message');

            confirmation(deleteMessage, function () {
                ajaxSetup();
                $.ajax({
                    url: deleteHref,
                    method: 'DELETE',
                    success: function (res) {
                        successNotification(res.message);
                        reloadDT();
                    },
                    error: function (err) {
                        ajaxErrorHandling(err);
                    }
                });
            });
        });
    }

    // ⬇️ FORM CREATE PROMO (POST)
    formSubmit(
        $('#modalCreate'),
        $('#formCreate'),
        $('#formCreate').find(`[type='submit']`),
        "{{ route('promo.store') }}",
        'POST'
    );

</script>
@endsection
