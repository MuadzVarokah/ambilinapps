<div class="modal modal-borderless fade" id="edit{{ $data_user->id }}" data-bs-backdrop="true" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="edit{{ $data_user->id }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="edit{{ $data_user->id }}Label">Edit Harga Sampah - ID:
                    {{ $data_user->id }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="form form-vertical" action="{{ route('harga_sampah_post-operator') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $data_user->id }}">
                @if ($active != 'harga sampah pelapak')
                    <input type="hidden" name="kat_user" value="{{ $data_user->kat_user }}">
                @endif
                <input type="hidden" name="foto" value="{{$data_user->foto}}">
                <input type="hidden" name="aktif" value="{{$data_user->aktif}}">
                <input type="hidden" name="old_down" value="{{$data_user->harga_down}}">
                <input type="hidden" name="old_top" value="{{$data_user->harga_top}}">
                <input type="hidden" name="mitra" value="{{$mitra}}">
                {{-- <input type="hidden" name="old_top" value="{{$data_user->harga_top}}"> --}}
                <div class="modal-body">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group has-icon-left">
                                    <label for="nama">Nama Sampah</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control" placeholder="-" name="nama"
                                            value="{{ $data_user->nama }}" required>
                                        <div class="form-control-icon">
                                            <i class="bi bi-people"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 col-md-6">
                                <div class="form-group has-icon-left">
                                    <label for="harga_down">Harga Bawah</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control" placeholder="-" name="harga_down"
                                            value="{{ $data_user->harga_down }}" required>
                                        <div class="form-control-icon">
                                            <i class="bi bi-people"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 col-md-6">
                                <div class="form-group has-icon-left">
                                    <label for="harga_top">Harga Atas</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control" placeholder="-" name="harga_top"
                                            value="{{ $data_user->harga_top }}" required>
                                        <div class="form-control-icon">
                                            <i class="bi bi-people"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-12">
                        <div class="form-group has-icon-left">
                            <label for="aktif">Status</label>
                            <div class="position-relative">
                                <select class="form-control form-select" name="aktif" required>
                                    <option value="1" @if ($data_user->aktif == '1') selected @endif>Aktif</option>
                                    <option value="0" @if ($data_user->aktif == '0') selected @endif>Mati</option>
                                </select>
                                <div class="form-control-icon">
                                    <i class="bi bi-people"></i>
                                </div>
                            </div>
                        </div>
                    </div> --}}
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
