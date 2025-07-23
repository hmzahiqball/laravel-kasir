@extends('layouts.template')

@section('content')
    <section class="row mt-2">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Data Barang

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
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Aksi</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
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
@include('barang.modal.createModal')
@include('barang.modal.updateModal')
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
    <script>
    $(document).ready(function () {
        loadKategoriOptions();
    });

    const renderBarcode = (kode, targetId) => {
        JsBarcode(targetId, kode, {
            format: "CODE128",
            lineColor: "#000",
            width: 2,
            height: 60,
            displayValue: true
        });
    };

    const printBarcode = (barcodeId) => {
        const svgElement = document.getElementById(barcodeId);
        const kodeProduk = svgElement.textContent || "KODE PRODUK";

        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <html>
                <head>
                    <title>Cetak Barcode</title>
                    <style>
                        body { text-align: center; font-family: sans-serif; margin-top: 40px; }
                        svg { width: 80%; max-width: 300px; height: auto; }
                    </style>
                </head>
                <body>
                    <h3>Barcode Produk</h3>
                    ${svgElement.outerHTML}
                    <script>
                        window.onload = function() {
                            window.print();
                            window.onafterprint = function () { window.close(); };
                        }
                    <\/script>
                </body>
            </html>
        `);
        printWindow.document.close();
    };

    const loadKategoriOptions = async () => {
        const res = await $.get("{{ route('kategori.all') }}");
        const kategori = res.kategori;
        const select = $('#formCreate select[name="kategori_id"], #formUpdate select[name="kategori_id"]');
        select.empty().append(`<option value="">Pilih Kategori</option>`);
        kategori.forEach(kat => {
            select.append(`<option value="${kat.id}" data-kode="${kat.kode}">${kat.name}</option>`);
        });
    };

    const reloadDT = () => {
        $('#table1').DataTable().ajax.reload();
    };

    const formSubmit = ($modal, $form, $submit, $href, $method, $addedAction = null) => {
        $form.off('submit');
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
                if ($addedAction) $addedAction();
            }).fail(error => {
                ajaxErrorHandling(error, $form);
            });
        });
    };

    const generateKode = (kodeKategori, namaProduk) => {
        const singkatan = namaProduk.replace(/\s+/g, '').substring(0, 3).toUpperCase();
        const random3 = Math.floor(100 + Math.random() * 900);
        return `${kodeKategori}${singkatan}${random3}`;
    };

    // ======== FORM CREATE ========
    $('#formCreate select[name="kategori_id"], #formCreate input[name="name"]').on('change keyup', function () {
        const select = $('#formCreate select[name="kategori_id"]');
        const kodeKategori = select.find(':selected').data('kode') || '';
        const namaProduk = $('#formCreate input[name="name"]').val().trim();
        if (kodeKategori && namaProduk) {
            const kode = generateKode(kodeKategori, namaProduk);
            $('#formCreate input[name="kode"]').val(kode);
            renderBarcode(kode, "#barcodePreviewCreate");
        }
    });

    $('#btnTambah').on('click', function() {
        $('#modalCreate').modal('show');
    });

    formSubmit(
        $('#modalCreate'),
        $('#formCreate'),
        $('#formCreate').find(`[type='submit']`),
        "{{ route('barang.store') }}",
        'POST'
    );

    // ======== FORM UPDATE ========
    let initialKategoriIdUpdate = null;
    let initialKodeProduk = '';
    let kategoriSudahDiubah = false;

    const openUpdateModal = (barang) => {
        kategoriSudahDiubah = false;
        initialKategoriIdUpdate = barang.kategori_id;
        initialKodeProduk = barang.kode;

        $('#formUpdate input[name="name"]').val(barang.name);
        $('#formUpdate input[name="price"]').val(barang.price);
        $('#formUpdate input[name="kode"]').val(barang.kode);
        $('#formUpdate input[name="stok"]').val(barang.stok);
        $('#formUpdate select[name="kategori_id"]').val(barang.kategori_id).trigger('change');
            renderBarcode(initialKodeProduk, "#barcodePreviewUpdate");
    };

    $('#formUpdate select[name="kategori_id"]').on('change', function () {
        const selectedKategoriId = $(this).val();
        const kodeBaruKategori = $(this).find(':selected').data('kode');

        if (selectedKategoriId != initialKategoriIdUpdate) {
            kategoriSudahDiubah = true;

            const inputNama = $('#formUpdate input[name="name"]').val().trim();
            const singkatanNama = inputNama.replace(/\s+/g, '').substring(0, 3).toUpperCase();
            const random3 = Math.floor(100 + Math.random() * 900);
            const finalKode = `${kodeBaruKategori}${singkatanNama}${random3}`;
            $('#formUpdate input[name="kode"]').val(finalKode);
            renderBarcode(finalKode, "#barcodePreviewUpdate");
        } else {
            kategoriSudahDiubah = false;
            $('#formUpdate input[name="kode"]').val(initialKodeProduk);
            renderBarcode(initialKodeProduk, "#barcodePreviewUpdate");
        }
    });

    $('#formUpdate input[name="name"]').on('input', function () {
        if (!kategoriSudahDiubah) return;

        const kodeKategori = $('#formUpdate select[name="kategori_id"]').find(':selected').data('kode') || '';
        const namaProduk = $(this).val().trim();

        if (namaProduk !== '') {
            const singkatanNama = namaProduk.replace(/\s+/g, '').substring(0, 3).toUpperCase();
            const random3 = Math.floor(100 + Math.random() * 900);
            const finalKode = `${kodeKategori}${singkatanNama}${random3}`;
            $('#formUpdate input[name="kode"]').val(finalKode);
            renderBarcode(finalKode, "#barcodePreviewUpdate");
        }
    });

    // ======== RENDERED EVENT (EDIT BUTTON) ========
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

        $('.edit').off('click').on('click', function() {
            ajaxSetup();
            const { getHref, updateHref } = $(this).data();

            $.get({
                url: getHref,
                dataType: 'json'
            }).done(async res => {
                const barang = res.barang;

                await loadKategoriOptions();

                $('#modalUpdate').modal('show');
                openUpdateModal(barang);

                formSubmit(
                    $('#modalUpdate'),
                    $('#formUpdate'),
                    $('#formUpdate').find(`[type="submit"]`),
                    updateHref,
                    'PUT'
                );
            }).fail(err => {
                console.log(err);
            });
        });
    };

    // ======== DATATABLE INIT ========
    $('#table1').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: {
            url: "{{ route('barang.index') }}"
        },
        columns: [
            { data: 'action', name: 'action' },
            { data: 'kode', name: 'kode' },
            { data: 'name', name: 'name' },
            { data: 'price', name: 'price' },
            { data: 'stok', name: 'stok' },
        ],
        drawCallback: settings => {
            renderedEvent();
        }
    });
</script>

@endsection
