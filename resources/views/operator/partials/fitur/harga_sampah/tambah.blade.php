<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">
<link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
@include('operator.partials.toast')
<div id="main-content">
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3 class="title">Tambah Harga Sampah</h3>
                    <p class="text-subtitle text-muted">Menambahkan Harga Sampah pada Ambilin</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index-operator') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah Harga Sampah</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="page-content">
        <div class="card">
            {{-- <div class="card-header" style="padding-bottom: 0;"> --}}
                {{-- <h4 class="card-title">Vertical Form with Icons</h4> --}}
                {{-- <p class="card-text text-danger" style="text-align: justify;"><b>ID UKM Tani akan diperoleh setelah Petani berhasil mendaftarkan diri!</b></p> --}}
            {{-- </div> --}}
            <div class="card-content">
                <div class="card-body">
                    <form class="form form-vertical" action="{{route('harga_sampah_post-operator')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="new">
                        <div class="row">
                            <div class="col-12 col-lg-6 col-md-6">
                                <div class="form-group has-icon-left">
                                    <label for="kat_user">Kategori User <font style="color:red">*</font></label>
                                    <div class="position-relative">
                                        <select class="form-control form-select" aria-label="kat_user" name="kat_user" required>
                                            <option value="1">Rumah Tangga</option>
                                            <option value="3">Bank Sampah</option>
                                            <option value="2">Kolektor</option>
                                            <option value="4">Pelapak</option>
                                        </select>
                                        <div class="form-control-icon">
                                            <i class="bi bi-person"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 col-md-6">
                                <div class="form-group has-icon-left">
                                    <label for="nama">Nama Sampah <font style="color:red">*</font></label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control" placeholder="Nama" id="nama" name="nama" required>
                                        <div class="form-control-icon">
                                            <i class="bi bi-person"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group has-icon-left">
                                    <label for="foto">Foto Sampah <font style="color:red">*</font></label>
                                    <div class="position-relative">
                                        <div class="form-group">
                                            <div class="file-loading">
                                                <input id="file-1" type="file" name="foto">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 col-md-6">
                                <div class="form-group has-icon-left">
                                    <label for="harga_down">Harga Bawah <font style="color:red">*</font></label>
                                    <div class="position-relative">
                                        <input type="number" class="form-control" placeholder="Harga bawah" id="harga_down" name="harga_down" required>
                                        <div class="form-control-icon">
                                            <span>Rp</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 col-md-6">
                                <div class="form-group has-icon-left">
                                    <label for="harga_top">Harga Atas <font style="color:red">*</font></label>
                                    <div class="position-relative">
                                        <input type="number" class="form-control" placeholder="Harga atas" id="harga_top" name="harga_top" required>
                                        <div class="form-control-icon">
                                            <span>Rp</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                <button type="submit" class="btn btn-success me-1 mb-1">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/plugins/buffer.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/plugins/piexif.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/fileinput.min.js"></script>

<script type="text/javascript">
    $("#file-1").fileinput({
        theme: 'fa',
        uploadExtraData: function() {
            return {
                _token: $("input[name='_token']").val(),
            };
        },
        showUpload: false,
        allowedFileExtensions: ['png', 'jpg', 'jpeg'],
        overwriteInitial: false,
        maxFileSize: 4096,
        slugCallback: function (filename) {
            return filename.replace('(', '_').replace(']', '_');
        }
    });
</script>