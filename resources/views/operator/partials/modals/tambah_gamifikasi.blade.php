<div class="modal modal-borderless fade" id="tambahGamifikasi" data-bs-backdrop="true" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="tambahGamifikasiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="tambahGamifikasiLabel">Tambah Gamifikasi</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="form form-vertical" action="{{route('post_gamifikasi-operator')}}" method="POST">
                @csrf
                <input type="hidden" name="id" value="new">
                <div class="modal-body">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-12 col-lg-6 col-md-6">
                                <div class="form-group has-icon-left">
                                    <label for="pangkat">Pangkat</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control" placeholder="Pangkat" name="pangkat" required>
                                        <div class="form-control-icon">
                                            <i class="bi bi-people"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 col-md-6">
                                <div class="form-group has-icon-left">
                                    <label for="pangkat_pendek">Sebutan</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control" placeholder="Sebutan" name="pangkat_pendek" required>
                                        <div class="form-control-icon">
                                            <i class="bi bi-people"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group has-icon-left">
                                    <label for="jumlah">Jumlah Ambilin</label>
                                    <div class="position-relative">
                                        <input type="number" class="form-control" placeholder="Jumlah Ambilin" name="jumlah">
                                        <div class="form-control-icon">
                                            <i class="bi bi-people"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row d-flex justify-content-between" style="width: 100%;">
                        <div class="col-auto" style="padding: 0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                        <div class="col-auto" style="padding: 0">
                            <button class="btn btn-success" type="submit"
                                onclick="return confirm('apakah anda yakin?')">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
