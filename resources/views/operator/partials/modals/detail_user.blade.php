<div class="modal modal-borderless fade" id="detail{{$data_user->id}}" data-bs-backdrop="true" data-bs-keyboard="false" tabindex="-1" aria-labelledby="detail{{$data_user->id}}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="detail{{$data_user->id}}Label">Detail User - ID: {{$data_user->id}}</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        {{-- <form class="form form-vertical" action="" method="POST"> --}}
        <div class="modal-body">
                <div class="form-body">
                    <div class="row">
                        <div class="col-12 col-lg-6 col-md-6">
                            <div class="form-group has-icon-left">
                                <label for="nama">Nama</label>
                                <div class="position-relative">
                                    <input type="text" class="form-control form-control-plaintext" readonly placeholder="-" name="nama" value="{{$data_user->nama}}">
                                    <div class="form-control-icon">
                                        <i class="bi bi-people"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 col-md-6">
                            <div class="form-group has-icon-left">
                                <label for="nama_lengkap">Nama Lengkap</label>
                                <div class="position-relative">
                                    <input type="text" class="form-control form-control-plaintext" readonly placeholder="-" name="nama_lengkap" value="{{$data_user->nama_lengkap}}">
                                    <div class="form-control-icon">
                                        <i class="bi bi-people"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 col-md-6">
                            <div class="form-group has-icon-left">
                                <label for="username">Username</label>
                                <div class="position-relative">
                                    <input type="text" class="form-control form-control-plaintext" readonly placeholder="-" name="username" value="{{$data_user->username}}">
                                    <div class="form-control-icon">
                                        <i class="bi bi-people"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 col-md-6">
                            <div class="form-group has-icon-left">
                                <label for="no_wa">Nomor WA</label>
                                <div class="position-relative">
                                    <input type="text" class="form-control form-control-plaintext" readonly placeholder="-" name="no_wa" value="{{$data_user->no_wa}}">
                                    <div class="form-control-icon">
                                        <i class="bi bi-people"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group has-icon-left">
                                <label for="email">Email</label>
                                <div class="position-relative">
                                    <input type="text" class="form-control form-control-plaintext" readonly placeholder="-" name="username" value="{{$data_user->email}}">
                                    <div class="form-control-icon">
                                        <i class="bi bi-people"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 col-md-6">
                            <div class="form-group has-icon-left">
                                <label for="tgl_lahir">Tanggal Lahir</label>
                                <div class="position-relative">
                                    <input type="text" class="form-control form-control-plaintext" readonly placeholder="-" name="tgl_lahir" value="{{$data_user->tgl_lahir}}">
                                    <div class="form-control-icon">
                                        <i class="bi bi-people"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 col-md-6">
                            <div class="form-group has-icon-left">
                                <label for="sex">Jenis Kelamin</label>
                                <div class="position-relative">
                                    <input type="text" class="form-control form-control-plaintext" readonly placeholder="-" name="sex" value="{{$data_user->sex}}">
                                    <div class="form-control-icon">
                                        <i class="bi bi-people"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 col-md-6">
                            <div class="form-group has-icon-left">
                                <label for="pekerjaan">Pekerjaan</label>
                                <div class="position-relative">
                                    <input type="text" class="form-control form-control-plaintext" readonly placeholder="-" name="pekerjaan" value="{{$data_user->pekerjaan}}">
                                    <div class="form-control-icon">
                                        <i class="bi bi-people"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 col-md-6">
                            <div class="form-group has-icon-left">
                                <label for="pendidikan">Pendidikan</label>
                                <div class="position-relative">
                                    <input type="text" class="form-control form-control-plaintext" readonly placeholder="-" name="pendidikan" value="{{$data_user->pendidikan}}">
                                    <div class="form-control-icon">
                                        <i class="bi bi-people"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group has-icon-left">
                                <label for="alamat">Alamat</label>
                                <div class="position-relative">
                                    <textarea name="alamat" type="text" class="form-control form-control-plaintext" readonly rows="2" placeholder="-"
                                    >@if (!empty($data_user->alamat_lokasi)){{ $data_user->alamat_lokasi }}@if (!empty($data_user->idkel)), {{ $data_user->kel }}@if (!empty($data_user->idkec)), {{ $data_user->kec }}@if (!empty($data_user->idkab)), {{ $data_user->kab }}@if (!empty($data_user->idprov)), {{ $data_user->prov }}@endif @endif @endif @endif @endif</textarea>
                                    <div class="form-control-icon">
                                        <i class="bi bi-people"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group has-icon-left">
                                <label for="kodepos">Kode Pos</label>
                                <div class="position-relative">
                                    <input type="text" class="form-control form-control-plaintext" readonly placeholder="-" name="kodepos" value="{{$data_user->kodepos}}">
                                    <div class="form-control-icon">
                                        <i class="bi bi-people"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group has-icon-left">
                                <label for="no_ktp">NIK</label>
                                <div class="position-relative">
                                    <input type="text" class="form-control form-control-plaintext" readonly placeholder="-" name="no_ktp" value="{{$data_user->no_ktp}}">
                                    <div class="form-control-icon">
                                        <i class="bi bi-people"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($data_user->kat_user != 2)
                            <div class="col-12 col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label for="foto_diri">Foto Diri</label>
                                    <div class="position-relative">
                                        @php
                                            $foto_diri = 'public/img/logo-green.png';
                                            if (!empty($data_user->foto_diri) && file_exists('public/img/foto/'.$data_user->foto_diri)) {
                                                $foto_diri = 'public/img/foto/'.$data_user->foto_diri;
                                            }
                                        @endphp
                                        <img src="{{ asset($foto_diri) }}" loading="lazy" alt="" style="max-width: 100%; height: 100%;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label for="foto_ktp">Foto KTP</label>
                                    <div class="position-relative">
                                        @php
                                            $foto_diri = 'public/img/logo-green.png';
                                            if (!empty($data_user->ktp) && file_exists('public/img/ktp/'.$data_user->ktp)) {
                                                $foto_diri = 'public/img/ktp/'.$data_user->ktp;
                                            }
                                        @endphp
                                        <img src="{{ asset($foto_diri) }}" loading="lazy" alt="" style="max-width: 100%; height: 100%;">
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="col-12 col-lg-4 col-md-4">
                                <div class="form-group">
                                    <label for="foto_diri">Foto Diri</label>
                                    <div class="position-relative">
                                        @php
                                            $foto_diri = 'public/img/logo-green.png';
                                            if (!empty($data_user->foto_diri) && file_exists('public/img/foto/'.$data_user->foto_diri)) {
                                                $foto_diri = 'public/img/foto/'.$data_user->foto_diri;
                                            }
                                        @endphp
                                        <img src="{{ asset($foto_diri) }}" loading="lazy" alt="" style="max-width: 100%; height: 100%;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4 col-md-4">
                                <div class="form-group">
                                    <label for="foto_ktp">Foto KTP</label>
                                    <div class="position-relative">
                                        @php
                                            $foto_diri = 'public/img/logo-green.png';
                                            if (!empty($data_user->ktp) && file_exists('public/img/ktp/'.$data_user->ktp)) {
                                                $foto_diri = 'public/img/ktp/'.$data_user->ktp;
                                            }
                                        @endphp
                                        <img src="{{ asset($foto_diri) }}" loading="lazy" alt="" style="max-width: 100%; height: 100%;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4 col-md-4">
                                <div class="form-group">
                                    <label for="foto_kta">Foto KTA</label>
                                    <div class="position-relative">
                                        @php
                                            $foto_diri = 'public/img/logo-green.png';
                                            if (!empty($data_user->kta) && file_exists('public/img/kta/'.$data_user->kta)) {
                                                $foto_diri = 'public/img/kta/'.$data_user->kta;
                                            }
                                        @endphp
                                        <img src="{{ asset($foto_diri) }}" loading="lazy" alt="" style="max-width: 100%; height: 100%;">
                                    </div>
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
                @if (!empty($jenis))
                    @if (($jenis == 'rumah_tangga') || ($jenis == 'bank_sampah') || ($jenis == 'kolektor'))
                    <div class="col-auto" style="padding: 0">
                        @if ($data_user->verified == 1)
                            <a class="btn btn-danger" href="{{route('mitra_verif-operator',['id' => $data_user->id])}}?verifikasi=3&jenis={{$jenis}}" onclick="return confirm('apakah anda yakin?')">Tolak</a>&nbsp;&nbsp;
                            <a class="btn btn-success" href="{{route('mitra_verif-operator',['id' => $data_user->id])}}?verifikasi=2&jenis={{$jenis}}" onclick="return confirm('apakah anda yakin?')">Verifikasi</a>                        
                        {{-- @elseif ($data_user->verified == 2)
                            <button type="button" class="btn btn-warning">Ubah</button>  --}}
                        @endif
                    </div>
                    @endif
                @endif
            </div>
        </div>
        {{-- </form> --}}
        </div>
    </div>
</div>