<div class="modal modal-borderless fade" id="editWaktu{{ $data_ambilin->barkas_id }}" data-bs-backdrop="true"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="editWaktu{{ $data_ambilin->barkas_id }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editWaktu{{ $data_ambilin->barkas_id }}Label">Edit Waktu Ambilin - ID:
                    {{ $data_ambilin->barkas_id }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="form form-vertical" action="{{route('ambilin_edit-operator',['jenis'=>$jenis])}}" method="POST">
                @csrf
                <input type="hidden" name="id_ambilin" value="{{ $data_ambilin->barkas_id }}">
                <div class="modal-body">
                    <div class="form-body">
                        <input type="hidden" name="id" value="{{$data_ambilin->id}}">
                        {{-- <input type="hidden" name=""> --}}
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group has-icon-left">
                                    <label for="tgl">Tanggal Ambil</label>
                                    <div class="position-relative">
                                        <select class="{{--choices--}} form-select" name="tgl">
                                            @foreach ($tgl as $tgl_ambil)
                                                <option value="{{$tgl_ambil->id}}" @if($data_ambilin->tgl_ambil == $tgl_ambil->id) selected @endif>{{$tgl_ambil->tgl}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group has-icon-left">
                                    <label for="waktu">Waktu Ambil</label>
                                    <div class="position-relative">
                                        <select class="{{--choices--}} form-select" name="waktu">
                                            @foreach ($waktu as $waktu_ambil)
                                                <option value="{{$waktu_ambil->id}}" @if($data_ambilin->waktu_ambil == $waktu_ambil->id) selected @endif>{{$waktu_ambil->waktu}}</option>
                                            @endforeach
                                        </select>
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
