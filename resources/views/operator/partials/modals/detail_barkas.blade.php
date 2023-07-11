@foreach ($data as $data_modal1)
    <div class="modal modal-borderless fade" id="detailBarkas{{ $data_modal1->barkas_id }}" aria-labelledby="detailBarkas{{ $data_modal1->barkas_id }}Label" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="detailBarkas{{ $data_modal1->barkas_id }}Label">Detail {{ucfirst($jenis)}} - ID:
                        {{ $data_modal1->barkas_id }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group has-icon-left">
                                    <label for="Foto">Foto</label>
                                    <div class="position-relative">
                                        <img src="{{ asset('public/img/'.$jenis.'/'.$data_modal1->foto) }}" alt="{{$data_modal1->foto}}" style="width: 100%">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 col-md-6">
                                <div class="form-group has-icon-left">
                                    <label for="pemilik">Pemilik</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control form-control-plaintext" readonly placeholder="-"
                                            value="{{ $data_modal1->wp_id }} - {{ $data_modal1->nama }}">
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
                            @if ($jenis != 'sebar')
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
                            @endif
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
                            @if ($active == $jenis.' hapus')
                                @foreach ($alasan_hapus->where($jenis.'_id', $data_modal1->barkas_id) as $hapus)
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
                            @if ($active == $jenis.' pengajuan ulang')
                                <div class="col-12">
                                    <div class="form-group has-icon-left">
                                        <label for="alasan_hapus">Alasan Ditolak</label>
                                        <ol class="list-group list-group-numbered">
                                            @foreach ($alasan_ditolak->where($jenis.'_id', $data_modal1->barkas_id) as $alasan_tolak)
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                              <div class="ms-2 me-auto">
                                                <div>{{ $alasan_tolak->alasan }}</div>
                                                <div class="text-secondary" style="font-size: 60%">{{ $alasan_tolak->waktu_catat }}</div>
                                              </div>
                                            </li>
                                            @endforeach
                                        </ol>
                                    </div>
                                </div>
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
                                <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#tolakModal{{ $data_modal1->barkas_id }}">Tolak</button>&nbsp;&nbsp;
                                {{-- <a class="btn btn-danger" href="{{route('ambilin-verif')}}?id={{$data_modal1->barkas_id}}&back={{$jenis}}&jenis={{$jenis}}&status={{$status}}&verif=3&id_user={{$data_modal1->wp_id}}" onclick="return confirm('apakah anda yakin?')">Tolak</a>&nbsp;&nbsp; --}}
                                <a class="btn btn-success" href="{{route('ambilin-verif')}}?id={{$data_modal1->barkas_id}}&back={{$jenis}}&jenis={{$jenis}}&status={{$status}}&verif=2&id_user={{$data_modal1->wp_id}}" onclick="return confirm('apakah anda yakin?')">Verifikasi</a>                        
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal modal-borderless fade" id="tolakModal{{ $data_modal1->barkas_id }}" aria-labelledby="tolakModal{{ $data_modal1->barkas_id }}Label" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h1 class="modal-title fs-5 text-white" id="tolakModal{{ $data_modal1->barkas_id }}Label">Tolak Verifikasi</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('tolak-barkas') }}" method="post">
                    @csrf
                    <input type="hidden" name="fitur" value="{{ $jenis }}">
                    <input type="hidden" name="id" value="{{ $data_modal1->barkas_id }}">
                    <input type="hidden" name="id_user" value="{{ $data_modal1->wp_id }}">
                    <input type="hidden" name="status" value="{{ $status }}">
                    <div class="modal-body">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <label for="alasan_tolak" style="font-weight: 600; padding-bottom: 0.5rem;">Alasan Tolak</label>
                                    <div class="position-relative">
                                        <textarea type="text" class="form-control" name="alasan_tolak" placeholder="Judul dan gambar tidak sesuai, Gambar dan deskripsi tidak sesuai, dsb" rows="6" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
