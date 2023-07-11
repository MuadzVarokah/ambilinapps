<div class="modal modal-borderless fade" id="editTglLayanan{{ $data_tgl_layanan->id }}" data-bs-backdrop="true"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="editTglLayanan{{ $data_tgl_layanan->id }}Label"
    aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editTglLayanan{{ $data_tgl_layanan->id }}Label">Edit Tanggal Layanan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('post_layanan-operator')}}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{$data_tgl_layanan->id}}">
                <input type="hidden" name="aktif" value="{{$data_tgl_layanan->aktif}}">
                <input type="hidden" name="jenis" value="tgl">
                <div class="modal-body">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="tgl">Tanggal Layanan</label>
                                    <div class="position-relative">
                                        <input type="date" class="form-control" placeholder="Tanggal Layanan" name="tgl" value="{{ $data_tgl_layanan->tgl }}">
                                        {{-- <div class="form-control-icon">
                                            <i class="bi bi-calendar"></i>
                                        </div> --}}
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
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>