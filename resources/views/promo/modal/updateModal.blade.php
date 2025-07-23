<!-- Update Promo Modal -->
<div class="modal fade text-left" id="modalUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel2">Update Promo</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form id="formUpdate">
                <input type="hidden" name="id" id="promo_id"> <!-- Buat simpan ID promonya -->
                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                    <div class="row">
                        <!-- Nama Promo -->
                        <div class="col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="edit_name">Nama Promo</label>
                                <input type="text" name="name" id="edit_name" class="form-control" required>
                            </div>
                        </div>

                        <!-- Kode Promo -->
                        <div class="col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="edit_kode">Kode Promo</label>
                                <input type="text" name="kode" id="edit_kode" class="form-control" required>
                            </div>
                        </div>

                        <!-- Tipe Diskon -->
                        <div class="col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="edit_tipe">Tipe Diskon</label>
                                <select name="tipe" id="edit_tipe" class="form-control" required>
                                    <option value="persen">Persen</option>
                                    <option value="nominal">Nominal</option>
                                </select>
                            </div>
                        </div>

                        <!-- Nilai Diskon -->
                        <div class="col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="edit_nilai">Nilai Diskon</label>
                                <input type="number" name="nilai" id="edit_nilai" class="form-control" required>
                            </div>
                        </div>

                        <!-- Kuota Promo -->
                        <div class="col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="edit_kuota">Kuota</label>
                                <input type="number" name="kuota" id="edit_kuota" class="form-control" required>
                            </div>
                        </div>

                        <!-- Tanggal Mulai -->
                        <div class="col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="edit_tanggal_mulai">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" id="edit_tanggal_mulai" class="form-control" required>
                            </div>
                        </div>

                        <!-- Tanggal Akhir -->
                        <div class="col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="edit_tanggal_akhir">Tanggal Berakhir</label>
                                <input type="date" name="tanggal_akhir" id="edit_tanggal_akhir" class="form-control" required>
                            </div>
                        </div>

                        <!-- Minimum Belanja -->
                        <div class="col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="edit_min_belanja">Minimal Belanja</label>
                                <input type="number" name="min_belanja" id="edit_min_belanja" class="form-control" required>
                            </div>
                        </div>

                        <!-- Status Aktif -->
                        <div class="col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="edit_is_active">Status Promo</label>
                                <select name="is_active" id="edit_is_active" class="form-control" required>
                                    <option value="aktif">Aktif</option>
                                    <option value="nonaktif">Nonaktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Batal</span>
                    </button>
                    <button type="submit" class="btn btn-warning ms-1">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Update Promo</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
