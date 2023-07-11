@foreach ($data as $data_modal_detail)
    <div class="modal modal-borderless fade" id="detailWPLokasi{{ $data_modal_detail->id }}" data-bs-backdrop="true"
        data-bs-keyboard="false" tabindex="-1" aria-labelledby="detailWPLokasi{{ $data_modal_detail->id }}Label"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="detailWPLokasi{{ $data_modal_detail->id }}Label">Detail WP Lokasi -
                        ID:
                        {{ $data_modal_detail->id }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-body">
                        <div class="row">
                            {{-- <div class="col-12">
                                <div class="form-group has-icon-left">
                                    <label>User</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control form-control-plaintext" readonly
                                            placeholder="-"
                                            value="{{ $data_modal_detail->wp_id }} - {{ $data_modal_detail->nama }}">
                                        <div class="form-control-icon">
                                            <i class="bi bi-people"></i>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="foto_lokasi">Foto Lokasi</label>
                                    <div class="position-relative">
                                        @php
                                            $foto_lokasi = 'public/img/logo-green.png';
                                            if (!empty($data_modal_detail->foto_lokasi) && file_exists('public/img/wp_lokasi/foto_lokasi/' . $data_modal_detail->foto_lokasi)) {
                                                $foto_lokasi = 'public/img/wp_lokasi/foto_lokasi/' . $data_modal_detail->foto_lokasi;
                                            }
                                        @endphp
                                        <img src="{{ asset($foto_lokasi) }}" loading="lazy" alt=""
                                            style="max-width: 100%; height: 100%;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 col-md-6">
                                <div class="form-group has-icon-left">
                                    <label>Nama Lokasi</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control form-control-plaintext" readonly
                                            placeholder="-"value="{{ $data_modal_detail->nama_lokasi }}">
                                        <div class="form-control-icon">
                                            <i class="bi bi-people"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 col-md-6">
                                <div class="form-group has-icon-left">
                                    <label>Nama Lokasi</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control form-control-plaintext" readonly
                                            placeholder="-"value="{{ $data_modal_detail->jenis_lokasi }}">
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
                                        >@if (!empty($data_modal_detail->alamat_lokasi)){{ $data_modal_detail->alamat_lokasi }}@if (!empty($data_modal_detail->idkel)), {{ $data_modal_detail->kel }}@if (!empty($data_modal_detail->idkec)), {{ $data_modal_detail->kec }}@if (!empty($data_modal_detail->idkab)), {{ $data_modal_detail->kab }}@if (!empty($data_modal_detail->idprov)), {{ $data_modal_detail->prov }}@endif @endif @endif @endif @endif</textarea>
                                        <div class="form-control-icon">
                                            <i class="bi bi-people"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 col-md-6">
                                <div class="form-group has-icon-left">
                                    <label>Kodepos</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control form-control-plaintext" readonly
                                            placeholder="-"value="{{ $data_modal_detail->kodepos }}">
                                        <div class="form-control-icon">
                                            <i class="bi bi-people"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>Status</label>
                                    <div class="position-relative d-flex align-items-center" style="height: 2.25rem">
                                        @if ($data_modal_detail->aktif == 'Y')
                                        <span class="badge bg-success">Aktif</span>
                                        @elseif ($data_modal_detail->aktif == 'N')
                                        <span class="badge bg-danger">Mati</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group has-icon-left">
                                    <label>Catatan</label>
                                    <div class="position-relative">
                                        <textarea type="text" class="form-control form-control-plaintext" readonly rows="2" placeholder="-">{{ $data_modal_detail->catatan }}</textarea>
                                        <div class="form-control-icon">
                                            <i class="bi bi-people"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 col-md-6">
                                <div class="form-group has-icon-left">
                                    <label>Lokasi X</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control form-control-plaintext" readonly
                                            placeholder="-"value="{{ $data_modal_detail->lokasi_x }}">
                                        <div class="form-control-icon">
                                            <i class="bi bi-people"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 col-md-6">
                                <div class="form-group has-icon-left">
                                    <label>Lokasi Y</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control form-control-plaintext" readonly
                                            placeholder="-"value="{{ $data_modal_detail->lokasi_y }}">
                                        <div class="form-control-icon">
                                            <i class="bi bi-people"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- @if (!empty($data_modal_detail->lokasi_x) && !empty($data_modal_detail->lokasi_y))
                            <div class="col-12">
                                <div class="form-group has-icon-left">
                                    <label>Denah Lokasi</label>
                                    <div class="position-relative">
                                        <div id="map" style="height: 20rem; width: 100%"></div>
                                        <script>
                                            async function initMap() {
                                                // const position = await new Promise((resolve, reject) => {
                                                //     navigator.geolocation.getCurrentPosition(resolve, reject);
                                                // });

                                                const myLocation = {
                                                    lat: parseFloat({{$data_modal_detail->lokasi_x}}),
                                                    lng: parseFloat({{$data_modal_detail->lokasi_y}}),
                                                };

                                                const map = new google.maps.Map(document.getElementById("map"), {
                                                    zoom: 12,
                                                    center: myLocation,
                                                });

                                                const marker = new google.maps.Marker({
                                                    position: myLocation,
                                                    map,
                                                    title: "Lokasi Waste Producer",
                                                });

                                                // const infoWindow = new google.maps.InfoWindow({
                                                //     content: `Latitude: ${myLocation.lat}, Longitude: ${myLocation.lng}`,
                                                //     position: myLocation,
                                                // }).open(map);
                                            }
                                        </script>
                                    </div>
                                </div>
                            </div>
                            @endif --}}
                            @if ($active == 'wp lokasi hapus')
                                @foreach ($alasan_hapus->where('id_lokasi', $data_modal_detail->id) as $hapus)
                                <div class="col-12">
                                    <div class="form-group has-icon-left">
                                        <label>Alasan Hapus</label>
                                        <div class="position-relative">
                                            <textarea type="text" class="form-control form-control-plaintext" readonly rows="2" placeholder="-">{{ $hapus->alasan }}</textarea>
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
                        @if (!empty($data_modal_detail->lokasi_x) && !empty($data_modal_detail->lokasi_y))
                        @php
                            $lokasi = 'https://www.google.co.id/maps/@'.$data_modal_detail->lokasi_x.','.$data_modal_detail->lokasi_y.',20z'
                        @endphp
                        <div class="col-auto" style="padding: 0">
                            <a role="button" href="{{$lokasi}}" class="btn btn-primary" target="_blank">Lihat Lokasi</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
