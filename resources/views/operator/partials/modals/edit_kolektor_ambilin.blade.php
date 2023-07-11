<div class="modal modal-borderless fade" id="editKolektor{{ $data_ambilin->barkas_id }}" data-bs-backdrop="true"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="editKolektor{{ $data_ambilin->barkas_id }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editKolektor{{ $data_ambilin->barkas_id }}Label">Edit Kolektor Ambilin - ID:
                    {{ $data_ambilin->barkas_id }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="form form-vertical" action="{{route('ambilin_set-operator',['jenis'=>$jenis])}}" method="POST">
                @csrf
                @if ($active == 'ambilin proses')
                    @foreach ($kolektor->where('ambilin_id', $data_ambilin->barkas_id) as $data_kolektor3)
                        <input type="hidden" name="id" value="{{ $data_kolektor3->id }}">
                    @endforeach
                @else
                    <input type="hidden" name="id" value="new">
                @endif
                {{-- <input type="hidden" name="jenis" value="{{$jenis}}"> --}}
                    <input type="hidden" name="id_user" value="{{$data_ambilin->wp_id}}">
                <input type="hidden" name="id_ambilin" value="{{ $data_ambilin->barkas_id }}">
                <div class="modal-body">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group has-icon-left">
                                    <label for="id_kolektor">Kolektor</label>
                                    <div class="position-relative">
                                        <select class="{{--choices--}} form-select" name="id_kolektor">
                                            @foreach ($kolektor->where('ambilin_id', $data_ambilin->barkas_id) as $data_kolektor2)
                                                @php $kolek_id = $data_kolektor2->user_id; @endphp
                                            @endforeach
                                            @if ($active == 'ambilin proses')
                                                @foreach ($list_kolektor as $list_kolektor)
                                                    <option value="{{ $list_kolektor->id }}"
                                                        @if ($kolek_id == $list_kolektor->id) selected @endif>
                                                        {{ $list_kolektor->id }} - {{ $list_kolektor->username }} -
                                                        {{ $list_kolektor->nama }}</option>
                                                @endforeach
                                            @else
                                                @foreach ($list_kolektor as $list_kolektor)
                                                    <option value="{{ $list_kolektor->id }}">{{ $list_kolektor->id }} -
                                                        {{ $list_kolektor->username }} - {{ $list_kolektor->nama }}
                                                    </option>
                                                @endforeach
                                            @endif
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
