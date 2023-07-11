<div class="modal fade" id="delAmbilinModal" tabindex="-1" aria-labelledby="delAmbilinModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row align-items-center" style="width: 100%">
                    <div class="col-11">
                        <h5 align="center" class="modal-title" id="delAmbilinModalLabel"
                            style="padding-left: 15%;">
                            Konfirmasi</h5>
                    </div>
                    <div class="col-1">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <div class="modal-body">

                <form action="{{ route('ambilin_hapus', ['id' => $id]) }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <!-- Alamat -->
                        <label class="form-label" for="alasan" style="padding-top: 10px">Alasan <font color='#ff0000'>*</font></label>
                        <textarea name="alasan" aria-label="alasan" name="alasan" class="form-control" rows="3" placeholder="Alasan..."
                            required></textarea>
                    </div>
                    <div class="mt-3 mb-3">
                        <p style="font-size: 80%; color: #ff0000;">Kolom dengan tanda bintang (*) wajib diisi</p>
                      </div>
                    <center>
                        <button type="submit" class="btn btn-danger"
                        style="width: 100%; text-transform: capitalize; font-size: 90%; font-weight: 600; padding: 0.5rem 0;"
                        onclick="return confirm('Apakah anda yakin ingin menghapus data ini?');">
                        <i class="fa-solid fa-trash text-white"></i>&nbsp;&nbsp;Hapus</button>
                    </center>
                </form>
            </div>
        </div>
    </div>
</div>