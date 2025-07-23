<!--Update Modal -->
<div class="modal fade text-left" id="modalUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel1">Update Barang</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form id="formUpdate">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="">Kode</label>
                                <input type="text" name="kode" class="form-control"
                                    placeholder="Kode Barang Otomatis Generate" readonly>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="">Pilih Kategori</label>
                                <select name="kategori_id" id="kategoriSelect" class="form-control" required>
                                    <option value="">Pilih Kategori</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="">Nama</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Masukan Nama Barang">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="">Price</label>
                                <input type="number" name="price" id="price" class="form-control"
                                    placeholder="Masukan Harga Barang">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="">Stok</label>
                                <input type="number" name="stok" id="stok" class="form-control"
                                    placeholder="Masukan Stok Barang">
                            </div>
                        </div>
                        <div class="col-lg-12 text-center">
                            <label>Preview Barcode</label>
                            <div>
                                <svg id="barcodePreviewUpdate"></svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" onclick="printBarcode('barcodePreviewUpdate')">
                        Cetak Barcode
                    </button>
                    <button type="button" class="btn" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>