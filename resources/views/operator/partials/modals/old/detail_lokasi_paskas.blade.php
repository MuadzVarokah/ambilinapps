@foreach ($data as $data_modal2)
    <div class="modal modal-borderless fade" id="detailLokasi{{ $data_modal2->paskas_id }}" data-bs-backdrop="true"
        data-bs-keyboard="false" tabindex="-1" aria-labelledby="detailLokasi{{ $data_modal2->paskas_id }}Label"
        aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="detailLokasi{{ $data_modal2->paskas_id }}Label">Detail Lokasi - ID:
                        {{ $data_modal2->paskas_id }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="lokasi">Lokasi</label>
                                    <div class="position-relative">
                                        <textarea type="text" class="form-control form-control-plaintext" readonly placeholder="-" rows="2"
                                        >{{ $data_modal2->alamat_lokasi }}, {{ $data_modal2->kel }}, {{ $data_modal2->kec }}, {{ $data_modal2->kab }}, {{ $data_modal2->prov }}</textarea>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
