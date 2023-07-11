<div class="modal modal-borderless fade" id="editNotif{{ $data_notif->id }}" data-bs-backdrop="true" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="editNotif{{ $data_notif->id }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editNotif{{ $data_notif->id }}Label">Edit Notifikasi - ID:
                    {{ $data_notif->id }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="form form-vertical" action="{{route('post_notifikasi-operator')}}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $data_notif->id }}">
                <div class="modal-body">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-12 col-lg-6 col-md-6">
                                <div class="form-group has-icon-left">
                                    <label for="judul">Judul <font style="color:red">*</font></label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control" placeholder="-" name="judul" value="{{ $data_notif->judul }}" required>
                                        <div class="form-control-icon">
                                            <i class="bi bi-star"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 col-md-6">
                                <div class="form-group has-icon-left">
                                    <label for="theme">Tema <font style="color:red">*</font></label>
                                    <div class="position-relative">
                                        <select class="form-control form-select" aria-label="Theme" name="theme" required>
                                            <option class="text-primary" value="primary" style="text-transform: capitalize" @if($data_notif->theme == 'primary') selected @endif>primary</option>
                                            <option class="text-secondary" value="secondary" style="text-transform: capitalize" @if($data_notif->theme == 'secondary') selected @endif>secondary</option>
                                            <option class="text-success" value="success" style="text-transform: capitalize" @if($data_notif->theme == 'success') selected @endif>success</option>
                                            <option class="text-danger" value="danger" style="text-transform: capitalize" @if($data_notif->theme == 'danger') selected @endif>danger</option>
                                            <option class="text-warning" value="warning" style="text-transform: capitalize" @if($data_notif->theme == 'warning') selected @endif>warning</option>
                                            <option class="text-info" value="info" style="text-transform: capitalize" @if($data_notif->theme == 'info') selected @endif>info</option>
                                        </select>
                                        <div class="form-control-icon">
                                            <i class="bi bi-shop-window"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group has-icon-left">
                                    <label for="isi">Isi <font style="color:red">*</font></label>
                                    <div class="position-relative">
                                        <textarea class="form-control" name="isi" rows="2" placeholder="-">{{ $data_notif->isi }}</textarea>
                                        {{-- <input type="text" class="form-control" placeholder="-" name="isi" value="{{ $data_notif->isi }}"> --}}
                                        <div class="form-control-icon">
                                            <i class="bi bi-text-paragraph"></i>
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
                            <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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
