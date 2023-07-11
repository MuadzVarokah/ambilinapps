@foreach ($data as $data_modal1)
    <div class="modal modal-borderless fade" id="detailPaskas{{ $data_modal1->paskas_id }}" data-bs-backdrop="true"
        data-bs-keyboard="false" tabindex="-1" aria-labelledby="detailPaskas{{ $data_modal1->paskas_id }}Label"
        aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="detailPaskas{{ $data_modal1->paskas_id }}Label">Detail Paskas - ID:
                        {{ $data_modal1->paskas_id }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group has-icon-left">
                                    <label for="Foto">Foto</label>
                                    <div class="position-relative">
                                        <img src="{{ asset('public/img/paskas/'.$data_modal1->foto) }}" alt="{{$data_modal1->foto}}" style="width: 100%">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 col-md-6">
                                <div class="form-group has-icon-left">
                                    <label for="pemilik">Pemilik</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control form-control-plaintext" readonly placeholder="-"
                                            value="{{ $data_modal1->wp_id }} - {{ $data_modal1->user_nama }}">
                                        <div class="form-control-icon">
                                            <i class="bi bi-people"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 col-md-6">
                                <div class="form-group has-icon-left">
                                    <label for="judul">Judul</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control form-control-plaintext" readonly placeholder="-"
                                            value="{{ $data_modal1->judul }}">
                                        <div class="form-control-icon">
                                            <i class="bi bi-people"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group has-icon-left">
                                    <label for="deskripsi">Deskripsi</label>
                                    <div class="position-relative">
                                        <textarea type="text" class="form-control form-control-plaintext" readonly placeholder="-" rows="2"
                                        >{{ $data_modal1->deskripsi }}</textarea>
                                        <div class="form-control-icon">
                                            <i class="bi bi-people"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 col-md-6">
                                <div class="form-group has-icon-left">
                                    <label for="kondisi">Kondisi</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control form-control-plaintext" readonly placeholder="-"
                                            value="{{ $data_modal1->kondisi }}">
                                        <div class="form-control-icon">
                                            <i class="bi bi-people"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 col-md-6">
                                <div class="form-group has-icon-left">
                                    <label for="jenis">Jenis</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control form-control-plaintext" readonly placeholder="-"
                                            value="{{ $data_modal1->jenis }}">
                                        <div class="form-control-icon">
                                            <i class="bi bi-people"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 col-md-6">
                                <div class="form-group has-icon-left">
                                    <label for="harga">Harga</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control form-control-plaintext" readonly placeholder="-"
                                            value="Rp. {{ $data_modal1->harga }}">
                                        <div class="form-control-icon">
                                            <i class="bi bi-people"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 col-md-6">
                                <div class="form-group has-icon-left">
                                    <label for="status">Status</label>
                                    <div class="position-relative d-flex align-items-center" style="height: 2rem;">
                                        @if ($data_modal1->aktif == 1)
                                        <span class="badge bg-success">Aktif</span>
                                        @else
                                        <span class="badge bg-danger">Mati</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group has-icon-left">
                                    <label for="lokasi">Lokasi</label>
                                    <div class="position-relative">
                                        <textarea type="text" class="form-control form-control-plaintext" readonly placeholder="-" rows="2"
                                        >{{ $data_modal1->alamat_lokasi }}, {{ $data_modal1->kel }}, {{ $data_modal1->kec }}, {{ $data_modal1->kab }}, {{ $data_modal1->prov }}</textarea>
                                        <div class="form-control-icon">
                                            <i class="bi bi-people"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if ($active == 'paskas hapus')
                                @foreach ($alasan_hapus->where('paskas_id', $data_modal1->paskas_id) as $hapus)
                                <div class="col-12">
                                    <div class="form-group has-icon-left">
                                        <label for="alasan_hapus">Alasan Hapus</label>
                                        <div class="position-relative">
                                            <textarea type="text" class="form-control form-control-plaintext" readonly placeholder="-" rows="2"
                                            >{{ $hapus->alasan }}</textarea>
                                            <div class="form-control-icon">
                                                <i class="bi bi-people"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row d-flex justify-content-between" style="width: 100%;">
                        <div class="col-auto" style="padding: 0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                        <div class="col-auto" style="padding: 0">
                            @if ($data_modal1->status_publikasi == 1)
                                <a class="btn btn-danger" href="javascript:void(0)" onclick="return confirm('apakah anda yakin?')">Tolak</a>&nbsp;&nbsp;
                                <a class="btn btn-success" href="javascript:void(0)" onclick="return confirm('apakah anda yakin?')">Verifikasi</a>                        
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
