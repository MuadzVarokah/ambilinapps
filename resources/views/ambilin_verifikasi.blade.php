@extends('layouts.default')

@section('content')
    <!-- Navbar -->
    @include('partials.navbar_umum')
    <!-- Navbar -->
    <div class="container">
        <section>
            <div class="py-4">
                <div class="row d-flex align-items-center justify-content-center">
                    <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                        <form action="{{ route('ambilin_verifikasi_post', ['id_ambilin' => $id_ambilin, 'id_booking' => $id_booking]) }}" method="POST">
                            @csrf
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="form-label" style="margin: 0;">Konfirmasi Berat dan Harga</h5>
                                    <p class="text-danger"><small>gunakan tanda titik ('.') untuk desimal</small></p>
                                    <hr>

                                    <!-- berat_riil input -->
                                    {{-- <div class="form-outline mb-4">
                                        <input type="text" name="berat_riil" id="berat_riil" class="form-control form-control-lg" onkeypress="return hanyaAngka(event)" style="background-color:white;"/>
                                        <label class="form-label" for="berat_riil">Total Berat Asli</label>
                                    </div> --}}
                                    <table class="table table-sm table-borderless" style="margin: 0;">
                                        <tr>
                                            <td style="width:55%;"><label class="form-label" for="jenis_sampah" style="margin: 0; font-size: 80%;">Jenis Sampah</label></td>
                                            <td style="width:20%; text-align: center;"><label class="form-label" for="berat" style="margin: 0; font-size: 80%; white-space: nowrap;">Berat (kg)</label></td>
                                            <td style="width:25%; text-align: center;"><label class="form-label" for="berat" style="margin: 0; font-size: 80%; white-space: nowrap;">Harga (Rp.)</label></td>
                                        </tr>
                                        {{-- {{dd($barang)}} --}}
                                        <?php $a = -1; ?>
                                        @foreach ($barang as $brg)
                                        <?php $a++; ?>
                                        {{-- {{dd($brg->id)}} --}}
                                            <tr>
                                                <input type="hidden" name="barang[{{$a}}][id_berat]" value="{{ $brg->id }}">
                                                <td class="align-middle input-group-sm"><input type="text" class="form-control" value="{{ $brg->nama }}" style="font-size: 80%;" disabled></td>
                                                <td class="align-middle input-group-sm">
                                                    <input type="number" name="barang[{{$a}}][berat_riil]" id="barang[{{$a}}][berat_riil]" class="form-control"
                                                        style="font-size: 80%; text-align: center; background-color: white;" value="{{ $brg->berat }}"
                                                        data-decimals="2" min="0" max="1000" step="0.1"
                                                        pattern="/^d+\.?\d*$/" onKeyPress="if(this.value.length==4) return false;"
                                                        maxlength="4" placeholder="berat" required />
                                                </td>
                                                <td class="align-middle input-group-sm">
                                                    <input type="number" name="barang[{{$a}}][harga_riil]" id="barang[{{$a}}][harga_riil]" class="form-control"
                                                        style="font-size: 80%; text-align: center; background-color: white;"
                                                        pattern="/^d+\.?\d*$/" onKeyPress="if(this.value.length==6) return false;"
                                                        maxlength="6" placeholder="Harga" required min="100" max="100000"/>
                                                </td>
                                                <script>
                                                    // $("input[type='number']").inputSpinner();
                                                </script>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>

                            <br>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row d-flex justify-content-between">
                                        <div class="col-auto">
                                            <h5 class="form-label" style="margin: 0;">Tambah Sampah Lain</h5>
                                        </div>
                                        <div class="col-auto">
                                            <a data-bs-toggle="collapse" href="#collapseTambahSampah" role="button" aria-expanded="false" aria-controls="collapseTambahSampah" onclick="changeIcon(this)">
                                                <i class="fa-solid fa-plus text-secondary" style="font-size: 140%;"></i>
                                            </a>
                                        </div>
                                        <script>
                                            function changeIcon(anchor) {
                                                var icon = anchor.querySelector("i");
                                                icon.classList.toggle('fa-plus');
                                                icon.classList.toggle('fa-minus');
                                            }
                                        </script>
                                    </div>
                                    <div class="collapse" id="collapseTambahSampah">
                                        <hr>
                                        <div class="alert alert-warning" role="alert" style="margin: 0; margin-bottom: 1rem;">
                                            <p style="font-size: 80%; margin: 0; font-weight: 600;">Abaikan kolom ini jika tidak ingin menambahkan sampah</p>
                                        </div>

                                        <div style="padding-bottom: 0.5rem">
                                            <button type="button" class="btn btn-primary" name="add" id="add"
                                            style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.5rem 1rem;">
                                            <i class="fa-solid fa-plus"></i>&nbsp;Tambah Kolom</button>
                                        </div>

                                        <table class="table table-borderless table-sm" id="dynamicTable" style="margin: 0;">
                                            <tr>
                                                <td style="width:50%;"><label class="form-label" for="jenis_sampah" style="margin: 0; font-size: 80%;">Jenis Sampah</label></td>
                                                <td style="width:20%; text-align: center;"><label class="form-label" for="berat" style="margin: 0; font-size: 80%; white-space: nowrap;">Berat (kg)</label></td>
                                                <td style="width:25%; text-align: center;"><label class="form-label" for="berat" style="margin: 0; font-size: 80%; white-space: nowrap;">Harga (Rp.)</label></td>
                                                <td class="text-center" style="width:5%;">
                                                    <label class="form-label" for="berat" style="margin: 0; font-size: 80%;">Aksi</label>
                                                </td>
                                            </tr>
                                            {{-- <tr>
                                                <td class="align-middle input-group">
                                                    <select class="form-select" name="tambah[0][id_sampah]" style="font-size: 80%; height: 100%;">
                                                    <option value="" style="font-size: 80%;"> Pilih Sampah </option>
                                                        @foreach($jenis as $jns)
                                                        <option value="{{$jns->id}}" {{ ((null !== old('tambah[0][id_sampah]')) && old('tambah[0][id_sampah]') == $jns->id) ? "selected=\"selected\"" : "" }} style="font-size: 80%">{{$jns->nama}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="align-middle input-group-sm">
                                                    <input type="number" name="tambah[0][berat]" class="form-control"
                                                        minlength="1" maxlength="6" data-decimals="2" min="1" max="1000" step="0.1"
                                                        pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==4) return false;"
                                                        style="background-color:white; text-align: center; font-size: 80%;" value="{{ old('tambah[0][berat]') }}" placeholder="berat"/>
                                                </td>
                                                <td class="align-middle input-group-sm">
                                                    <input type="number" name="tambah[0][harga_riil]" id="tambah[0][harga_riil]" class="form-control"
                                                        style="font-size: 80%; text-align: center; background-color: white;"
                                                        pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==6) return false;"
                                                        maxlength="6" placeholder="Harga" min="100" max="100000"/>
                                                </td>
                                                <td class="align-middle text-center input-group-sm">
                                                    <button type="button" class="btn btn-primary" name="add" id="add" style="font-size: 80%"><i class="fa-solid fa-plus"></i></button>
                                                </td>
                                            </tr> --}}
                                            {{-- <tr class="d-flex justify-content-center">
                                                <td class="d-flex justify-content-center align-middle input-group-sm">
                                                    <div class="row d-flex justify-content-center">
                                                        <div class="col-11 align-middle input-group-sm" style="padding: 10px 0 0 0;">
                                                            <select class="form-select" name="tambah[0][id_sampah]" style="font-size: 80%; height: 100%;">
                                                                <option value="" style="font-size: 80%"> Pilih jenis sampah </option>
                                                                    @foreach($jenis as $jns)
                                                                    <option value="{{$jns->id}}" {{ ((null !== old('id_sampah')) && old('id_sampah') == $jns->id) ? "selected=\"selected\"" : "" }} style="font-size: 80%">{{$jns->nama}}</option>
                                                                    @endforeach
                                                                </select>
                                                        </div>
                                                        <div class="col-5 align-middle input-group-sm" style="padding: 10px 5px 0 0;">
                                                            <input type="text" min="1" name="tambah[0][berat]" class="form-control"
                                                            minlength="1" maxlength="6" onkeypress="return hanyaAngka(event)"
                                                            style="background-color:white; text-align: center; font-size: 80%;" value="{{ old('berat') }}" placeholder="berat..."/>
                                                        </div>
                                                        <div class="col-6 align-middle input-group-sm" style="padding: 10px 0 5px 0;">
                                                            <input type="number" name="tambah[0][harga_riil]" id="tambah[0][harga_riil]" class="form-control"
                                                            style="font-size: 80%; text-align: center; background-color: white;"
                                                            pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==6) return false;"
                                                            maxlength="6" placeholder="Harga" required min="100" max="100000"/>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="row d-flex justify-content-center align-items-center">
                                                        <div class="col-1 align-middle input-group-sm" style="padding: 0;">
                                                            <button type="button" class="btn btn-primary" name="add" id="add" style="font-size: 80%"><i class="fa-solid fa-plus"></i></button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr> --}}
                                        </table>
                                        <script type="text/javascript">
   
                                            var i = -1;
                                               
                                            $("#add").click(function(){
                                           
                                                ++i;
                                           
                                                $("#dynamicTable").append("<tr><td class='align-middle input-group'><select class='form-select' name='tambah["+i+"][id_sampah]' style='font-size: 80%; height: 100%;' required><option value='' style='font-size: 80%;''> Pilih Sampah </option>@foreach($jenis as $jns)<option value='{{$jns->id}}' {{{ ((null !== old('tambah["+i+"][id_sampah]')) && old('tambah["+i+"][id_sampah]') == $jns->id) ? 'selected=\'selected\'' : '' }}} style='font-size: 80%''>{{$jns->nama}}</option>@endforeach</select></td><td class='align-middle input-group-sm'><input type='number' min='0.1' name='tambah["+i+"][berat]' class='form-control'minlength='1' maxlength='6' data-decimals='2' max='1000' step='0.1'pattern='/^-?\d+\.?\d*$/'' onKeyPress='if(this.value.length==4) return false;'style='background-color:white; text-align: center; font-size: 80%;' value='{{ old('tambah["+i+"][berat]') }}'' placeholder='berat' required /></td><td class='align-middle input-group-sm'><input type='number' name='tambah["+i+"][harga_riil]' id='tambah["+i+"][harga_riil]'' class='form-control' style='font-size: 80%; text-align: center; background-color: white;' pattern='/^-?\d+\.?\d*$/'' onKeyPress='if(this.value.length==6) return false;' maxlength='6' placeholder='Harga' min='100' max='100000' required /></td><td class='align-middle text-center input-group-sm'><button type='button' class='btn btn-danger remove-tr' name='remove-tr' id='remove-tr' style='font-size: 80%'><i class='fa-solid fa-xmark'></i></button></td></tr>");
                                                // $("#dynamicTable").append("<tr><td><select class='form-select' name='tambah["+i+"][id_sampah]' style='font-size: 80%'><option value='' style='font-size: 80%'> Pilih jenis sampah </option><?php foreach($jenis as $jns){?><option value='{{$jns->id}}' {{ ((null !== old('id_sampah')) && old('id_sampah') == $jns->id) ? 'selected=\'selected\'' : '' }} style='font-size: 80%'>{{$jns->nama}}</option><?php } ?></select></td><td><input type='text' min='1' name='tambah["+i+"][berat]' class='form-control' minlength='1' maxlength='6' onkeypress='return hanyaAngka(event)' style='background-color:white; text-align: center; font-size: 80%' value='{{ old("berat") }}' placeholder='berat...' /></td><td class='align-middle text-center'><button type='button' class='btn btn-danger remove-tr' name='remove-tr' id='remove-tr' style='font-size: 80%'><i class='fa-solid fa-xmark'></i></button></td></tr>");
                                            });
                                           
                                            $(document).on('click', '.remove-tr', function(){  
                                                 $(this).parents('tr').remove();
                                            });  
                                           
                                        </script>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row d-flex justify-content-between">
                                        <div class="col-auto">
                                            <h5 class="form-label" style="margin: 0;">Sampah Dengan EPR</h5>
                                        </div>
                                        <div class="col-auto">
                                            <a data-bs-toggle="collapse" href="#collapseSampahEPR" role="button" aria-expanded="false" aria-controls="collapseSampahEPR" onclick="changeIcon2(this)">
                                                <i class="fa-solid fa-plus text-secondary" style="font-size: 140%;"></i>
                                            </a>
                                        </div>
                                        <script>
                                            function changeIcon2(anchor) {
                                                var icon = anchor.querySelector("i");
                                                icon.classList.toggle('fa-plus');
                                                icon.classList.toggle('fa-minus');
                                            }
                                        </script>
                                    </div>
                                    <div class="collapse" id="collapseSampahEPR">
                                        <hr>
                                        <div class="alert alert-warning" role="alert" style="margin: 0; margin-bottom: 1rem;">
                                            <p style="font-size: 80%; margin: 0; font-weight: 600;">Abaikan kolom ini jika tidak ingin menambahkan sampah dengan EPR</p>
                                        </div>

                                        <div style="padding-bottom: 0.5rem">
                                            <button type="button" class="btn btn-primary" name="add_epr" id="add_epr"
                                            style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.5rem 1rem;">
                                            <i class="fa-solid fa-plus"></i>&nbsp;Tambah Kolom</button>
                                        </div>

                                        <table class="table table-borderless table-sm" id="dynamicTable_epr" style="margin: 0;">
                                            <tr>
                                                <td class="col-8"><label class="form-label" for="jenis_sampah" style="margin: 0; font-size: 80%;">Sampah ber-EPR</label></td>
                                                <td class="col-3" style="text-align: center;"><label class="form-label" for="berat" style="margin: 0; font-size: 80%;">Berat (kg)</label></td>
                                                <td class="text-center col-1"><label class="form-label" for="berat" style="margin: 0; font-size: 80%;">Aksi</label></td>
                                            </tr>
                                            {{-- <tr>
                                                <td class="align-middle input-group">
                                                    <select class="form-select" name="epr[0][sampah-merk_id]" style="font-size: 80%; height: 100%;">
                                                    <option value="" style="font-size: 80%"> Pilih sampah </option>
                                                        @foreach($epr as $e)
                                                        @php
                                                            if (strtolower($e->merek) == 'semua merek') {
                                                                $e->merek = $e->induk;
                                                            }
                                                        @endphp
                                                        <option value="{{$e->id}}" {{{ ((null !== old('epr[0][sampah-merk_id]')) && old('epr[0][sampah-merk_id]') == $e->id) ? "selected=\"selected\"" : "" }}} style="font-size: 80%">{{$e->jenis}}&nbsp;{{$e->merek}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="align-middle input-group-sm">
                                                    <input type="number" name="epr[0][jumlah]" class="form-control"
                                                    minlength="1" maxlength="6" data-decimals="2" min="0" max="1000" step="0.1"
                                                    pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==4) return false;"
                                                    style="background-color:white; text-align: center; font-size: 80%;" value="{{ old('epr[0][jumlah]') }}" placeholder="berat" />
                                                </td>
                                                <td class="align-middle text-center input-group-sm">
                                                    <button type="button" class="btn btn-primary" name="add_epr" id="add_epr" style="font-size: 80%"><i class="fa-solid fa-plus"></i></button>
                                                </td>
                                            </tr> --}}
                                        </table>
                                        <script type="text/javascript">
   
                                            var j = -1;
                                               
                                            $("#add_epr").click(function(){
                                           
                                                ++j;
                                           
                                                $("#dynamicTable_epr").append("<tr><td class='align-middle input-group'><select class='form-select' name='epr["+j+"][sampah-merk_id]' style='font-size: 80%' required ><option value='' style='font-size: 80%' > Pilih sampah </option><?php foreach($epr as $e){?><option value='{{$e->id}}' {{{ ((null !== old('epr["+j+"][sampah-merk_id]')) && old('epr["+j+"][sampah-merk_id]') == $e->id) ? 'selected=\'selected\'' : '' }}} style='font-size: 80%'>{{$e->merek}}&nbsp;{{$e->jenis}}</option><?php } ?></select></td><td class='align-middle input-group-sm'><input type='number' name='epr["+j+"][jumlah]' class='form-control' minlength='1' maxlength='6' data-decimals='2' min='0.1' max='1000' step='0.1'pattern='/^-?\d+\.?\d*$/' onKeyPress='if(this.value.length==4) return false;' style='background-color:white; text-align: center; font-size: 80%' value='{{ old("'epr['+j+'][sampah-merk_id]'") }}' placeholder='berat' required /></td><td class='align-middle text-center input-group-sm'><button type='button' class='btn btn-danger remove-tr-epr' name='remove-tr-epr' id='remove-tr-epr' style='font-size: 80%'><i class='fa-solid fa-xmark'></i></button></td></tr>");
                                            });
                                           
                                            $(document).on('click', '.remove-tr-epr', function(){  
                                                 $(this).parents('tr').remove();
                                            });  
                                           
                                        </script>
                                    </div>
                                </div>
                            </div>

                            @if ($errors->any())
                                <div class="form-outline mt-4">
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif

                            {{-- <div class="mt-3 mb-3">
                                <p style="font-size: 80%; color: #ff0000;">Kolom dengan tanda bintang (*) wajib diisi</p>
                            </div> --}}

                            <!-- Submit button -->
                            <br>
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <a href="{{route($back,$backslug) }}" type="button" class="btn btn-danger btn-lg btn-block"
                                            style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.5rem 0;">
                                            Batal</a>
                                    </div>
                                    <div class="col">
                                        <button type="submit" class="btn btn-success btn-lg btn-block"
                                            style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.5rem 0;">
                                            Konfirmasi</button>
                                    </div>
                                </div>
                            </div>

                            <script>
                                function hanyaAngka(evt) {
                                    var charCode = (evt.which) ? evt.which : event.keyCode
                                    if (charCode > 31 && (charCode < 48 || charCode > 57))
                                        return false;
                                    return true;
                                }
                                // change ',' to '.'
                                // document.getElementById('only_float').addEventListener('keypress', function(e){
                                //     function only_float(){
                                //         this.addEventListener('keypress', function(e){
                                //     if (e.key === ','){
                                //         // get old value
                                //         var start = e.target.selectionStart;
                                //         var end = e.target.selectionEnd;
                                //         var length = e.target.length;
                                //         var oldValue = e.target.value;

                                //         // replace point and change input value
                                //         var newValue = oldValue.slice(0, start) + '.' + oldValue.slice(end)
                                //         // var newValue = oldValue.slice(-0, -1) + '.'
                                //         e.target.value = newValue;

                                //         // replace cursor
                                //         e.target.selectionStart = e.target.selectionEnd = start + 1;

                                //         e.preventDefault();
                                //     }
                                //     })
                                // }
                                // })
                            </script>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
