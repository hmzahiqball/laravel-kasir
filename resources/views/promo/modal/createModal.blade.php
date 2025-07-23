<!-- Create Promo Modal -->
<div class="modal fade text-left" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel1">Tambah Promo</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form id="formCreate">
                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                    <div class="row">
                        <!-- Nama Promo -->
                        <div class="col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="name">Nama Promo</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan nama promo" required>
                            </div>
                        </div>

                        <!-- Kode Promo -->
                        <div class="col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="kode">Kode Promo</label>
                                <input type="text" name="kode" id="kode" class="form-control" placeholder="Contoh: PROMO123" required>
                            </div>
                        </div>

                        <!-- Tipe Diskon -->
                        <div class="col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="tipe">Tipe Diskon</label>
                                <select name="tipe" id="tipe" class="form-control" required>
                                    <option value="" disabled selected>Pilih tipe</option>
                                    <option value="persen">Persen</option>
                                    <option value="nominal">Nominal</option>
                                </select>
                            </div>
                        </div>

                        <!-- Nilai Diskon -->
                        <div class="col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="nilai">Nilai Diskon</label>
                                <input type="number" name="nilai" id="nilai" class="form-control" placeholder="Contoh: 10 atau 10000" required>
                            </div>
                        </div>

                        <!-- Kuota Promo -->
                        <div class="col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="kuota">Kuota</label>
                                <input type="number" name="kuota" id="kuota" class="form-control" placeholder="Contoh: 100" required>
                            </div>
                        </div>

                        <!-- Tanggal Mulai -->
                        <div class="col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="tanggal_mulai">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" required>
                            </div>
                        </div>

                        <!-- Tanggal Akhir -->
                        <div class="col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="tanggal_akhir">Tanggal Berakhir</label>
                                <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" required>
                            </div>
                        </div>

                        <!-- Minimum Belanja -->
                        <div class="col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="min_belanja">Minimal Belanja</label>
                                <input type="number" name="min_belanja" id="min_belanja" class="form-control" placeholder="Contoh: 50000" required>
                            </div>
                        </div>

                        <!-- Status Aktif -->
                        <div class="col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="is_active">Status Promo</label>
                                <select name="is_active" id="is_active" class="form-control" required>
                                    <option value="" disabled selected>Pilih status</option>
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
                        <span class="d-none d-sm-block">Tutup</span>
                    </button>
                    <button type="submit" class="btn btn-primary ms-1">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Simpan Promo</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
