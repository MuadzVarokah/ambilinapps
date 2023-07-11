@foreach ($data as $data_modal)
    <div class="modal modal-borderless fade" id="detailAmbilin{{ $data_modal->barkas_id }}" data-bs-backdrop="true"
        data-bs-keyboard="false" tabindex="-1" aria-labelledby="detailAmbilin{{ $data_modal->barkas_id }}Label"
        aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="detailAmbilin{{ $data_modal->barkas_id }}Label">Detail Ambilin - ID:
                        {{ $data_modal->barkas_id }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-body">
                        <div class="d-flex justify-content-center" style="padding-bottom:1rem">
                            @if(!empty($data_modal->foto) && file_exists('public/img/ambilin/sampah/' . $data_modal->foto))
                            <img src="{!! asset('public/img/ambilin/sampah/' . $data_modal->foto . '') !!}" class="img-fluid" alt="{{ $data_modal->foto }}"
                                style=" border-radius: 3%;object-fit: cover;max-width: 80%">
                            @else
                            <img src="https://ambilin.com/img/png/ambilin.png" class="img-fluid" alt="gambar tidak ditemukan"
                                style=" border-radius: 3%;object-fit: cover;max-width: 80%">
                            @endif
                        </div>
                        <table class="table table-striped table-responsive" id="table1" style="font-size: 90%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Barang</th>
                                    <th>Berat</th>
                                    @if ($active != 'ambilin tersedia' && $active != 'ambilin request' && $active != 'ambilin proses')
                                    <th>Harga Riil</th>
                                    <th>Berat Riil</th>
                                    <th>Harga Total</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                    $berat = [];
                                    $harga = [];
                                @endphp
                                @foreach ($sampah->where('id_ambilin', $data_modal->barkas_id) as $sampah_user)
                                    @php
                                        $i++;
                                        $berat[] = $sampah_user->berat_riil;
                                        $harga[] = $sampah_user->berat_riil*$sampah_user->harga_riil;
                                    @endphp
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $sampah_user->nama }}</td>
                                        <td>{{ $sampah_user->berat }} kg</td>
                                        @if ($active != 'ambilin tersedia' && $active != 'ambilin request' && $active != 'ambilin proses')
                                            @if (!empty($sampah_user->harga_riil))
                                                <td>Rp. {{ $sampah_user->harga_riil }}</td>
                                            @else
                                                <td>-</td>
                                            @endif
                                            
                                            @if (!empty($sampah_user->berat_riil))
                                                <td>{{ $sampah_user->berat_riil }} kg</td>
                                            @else
                                                <td>-</td>
                                            @endif

                                            @if (!empty($sampah_user->harga_riil) && !empty($sampah_user->berat_riil))
                                            <td>Rp. {{ $sampah_user->berat_riil*$sampah_user->harga_riil }}</td>
                                            @else
                                            <td>-</td>
                                            @endif
                                        @endif
                                    </tr>
                                @endforeach
                                @if ($active != 'ambilin tersedia' && $active != 'ambilin request' && $active != 'ambilin proses')
                                @php
                                    $total_berat = array_sum($berat);
                                    $total_harga = array_sum($harga);
                                @endphp
                                @if (!empty($sampah->where('id_ambilin', $data_modal->barkas_id)))
                                    <tr>
                                        <td colspan="4" class="text-center">Total : </td>
                                        <td>@if($total_berat != 0){{$total_berat}} kg @else - @endif</td>
                                        <td>@if($total_harga != 0)Rp. {{$total_harga}}@else - @endif</td>
                                    </tr>
                                @endif
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($active == 'ambilin request')
                    <div class="modal-footer">
                        <div class="row d-flex justify-content-between" style="width: 100%;">
                            <div class="col-auto" style="padding: 0">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                            <div class="col-auto" style="padding: 0">
                                <div class="row">
                                    <div class="col-auto">
                                        {{-- <form action="{{route('ambilin-verif')}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="jenis" value="ambilin">
                                            <input type="hidden" name="status" value="request">
                                            <input type="hidden" name="back" value="ambilin">
                                            <input type="hidden" name="verifikasi" value="ditolak"> --}}
                                            {{-- <button class="btn btn-danger" type="submit" onclick="return confirm('Apakah anda yakin ingin menolak request ambilin ini?')">Tolak</button> --}}
                                        {{-- </form> --}}
                                        <a class="btn btn-danger" href="{{route('ambilin-verif')}}?jenis=ditolak&back=ambilin&verif=ditolak&id={{$data_modal->barkas_id}}&id_user={{$data_modal->wp_id}}" onclick="return confirm('Apakah anda yakin ingin menolak verifikasi request ambilin ini?')">Tolak</a>
                                    </div>
                                    <div class="col-auto">
                                        <a class="btn btn-success" href="{{route('ambilin-verif')}}?jenis=tersedia&back=ambilin&verif=diterima&id={{$data_modal->barkas_id}}&id_user={{$data_modal->wp_id}}" onclick="return confirm('Apakah anda yakin ingin memverifikasi request ambilin ini?')">Verifikasi</a>
                                        {{-- <form action="{{route('ambilin-verif')}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="jenis" value="ambilin">
                                            <input type="hidden" name="status" value="request">
                                            <input type="hidden" name="back" value="ambilin">
                                            <input type="hidden" name="verifikasi" value="diterima"> --}}
                                            {{-- <button class="btn btn-success" type="submit" onclick="return confirm('Apakah anda yakin ingin memverifikasi request ambilin ini?')">Verifikasi</button> --}}
                                        {{-- </form> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endforeach
