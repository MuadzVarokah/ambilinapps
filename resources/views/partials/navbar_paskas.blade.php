    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style='background-color:#176e41'>
        <!-- Container wrapper -->
        <div class="container-fluid">
            <!-- Navbar brand -->
            @if (!empty($backslug))
                <a class="navbar-brand" href='{{ route($back,$backslug)}}'><i class="fa-solid fa-chevron-left"></i></a> 
            @else
                <a class="navbar-brand" href='{{ route($back)}}'><i class="fa-solid fa-chevron-left"></i></a>
            @endif
            <p class="navbar-brand" style="margin:0; font-size:90%;font-weight:bold">{{ $page }}</p>
            <ul class="navbar-nav ml-auto justify-content-end">
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="offcanvas" href="#offcanvasFilter" role="button"
                        aria-controls="offcanvasFilter"><i class="fas fa-filter"></i>Filter</a>
                </li>
            </ul>
        </div>
        <!-- Container wrapper -->
    </nav>
    <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasFilter"
        aria-labelledby="offcanvasFilterLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasFilterLabel">Filter</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            @if (!empty($fil_jenis))
                {{-- @php
    $filtered = '?jenis='.$fil_jenis.'&&';
@endphp --}}
                <form action="">
                    <div class="input-group mb-3" >
                        <input type="text" class="form-control" placeholder="Cari Produk ..." name="search"
                            value="{{ request('search') }}">
                        <button class="btn btn-success" type="submit" onsubmit="return validateForm();"
                            onclick="return validateForm();">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            @else
                <form action="">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Cari Produk ..." name="search"
                            value="{{ request('search') }}">
                        <button class="btn btn-success" type="submit" onsubmit="return validateForm();"
                            onclick="return validateForm();">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            @endif

            <div class="row text-center justify-content-center">
                @php
                if (!empty($fil_kata)) {
                    $searched = urlencode($fil_kata);
                }
                    
                @endphp
                <div class="col-lg-12 col-md-12 col-sm-12 col-12 iq-pb-10">
                    <label>Jenis Barkas</label>
                </div>
                <div class="col-12" style="padding:0.75rem">
                    @if (!empty($fil_kata) && empty($fil_kondisi))
                    <a class="btn btn-success" href="{{ url($current) }}?search={{ $searched }}" style="text-decoration: none; width:100%">
                        <div class="iq-blog iq-blog-box">
                            Semua
                        </div>
                    </a>
                    @elseif(empty($fil_kata) && !empty($fil_kondisi))
                    <a class="btn btn-success" href="{{ url($current) }}?kondisi={{$fil_kondisi->id}}" style="text-decoration: none; width:100%">
                        <div class="iq-blog iq-blog-box">
                            Semua
                        </div>
                    </a>
                    @elseif(!empty($fil_kata) && !empty($fil_kondisi))
                    <a class="btn btn-success" href="{{ url($current) }}?search={{ $searched }}&kondisi={{$fil_kondisi->id}}" style="text-decoration: none; width:100%">
                        <div class="iq-blog iq-blog-box">
                            Semua
                        </div>
                    </a>
                    @else
                    <a class="btn btn-success" href="{{ url($current) }}" style="text-decoration: none; width:100%">
                        <div class="iq-blog iq-blog-box">
                            Semua
                        </div>
                    </a>
                    @endif
                </div>
                <div class="row d-flex justify-content-center">
                    @foreach ($jenis as $jns)
                        @if (!empty($fil_kata) && empty($fil_kondisi))
                            <div class="col-lg-6 col-md-6 col-sm-6 col-6" style=" padding:0.25rem">
                                <a class="btn btn-success"
                                    href="{{ $current }}?search={{ $searched }}&jenis={{ $jns->id }}"
                                    style="text-decoration: none">
                                    {{ $jns->jenis }}
                                </a>
                            </div>
                        @elseif(empty($fil_kata) && !empty($fil_kondisi))
                            <div class="col-lg-6 col-md-6 col-sm-6 col-6" style=" padding:0.25rem">
                                <a class="btn btn-success"
                                    href="{{ $current }}?jenis={{ $jns->id }}&kondisi={{ $fil_kondisi->id }}"
                                    style="text-decoration: none">
                                    {{ $jns->jenis }}
                                </a>
                            </div>
                        @elseif(!empty($fil_kata) && !empty($fil_kondisi))
                            <div class="col-lg-6 col-md-6 col-sm-6 col-6" style=" padding:0.25rem">
                                <a class="btn btn-success"
                                    href="{{ $current }}?search={{ $searched }}&jenis={{ $jns->id }}&kondisi={{ $fil_kondisi->id }}"
                                    style="text-decoration: none">
                                    {{ $jns->jenis }}
                                </a>
                            </div>
                        @else
                            <div class="col-lg-6 col-md-6 col-sm-6 col-6" style="padding:0.25rem">
                                <a class="btn btn-success w-100"
                                    href="{{ $current }}?jenis={{ $jns->id }}"
                                    style="text-decoration: none;">
                                    {{ $jns->jenis }}
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
                <hr style="margin-top:1rem">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12 iq-pb-10">
                    <label>kondisi Barkas</label>
                </div>
                <div class="col-12" style="padding:0.75rem">
                    @if (!empty($fil_kata) && empty($fil_jenis))
                    <a class="btn btn-success" href="{{ url($current) }}?search={{ $searched }}" style="text-decoration: none; width:100%">
                        <div class="iq-blog iq-blog-box">
                            Semua
                        </div>
                    </a>
                    @elseif(empty($fil_kata) && !empty($fil_jenis))
                    <a class="btn btn-success" href="{{ url($current) }}?jenis={{$fil_jenis->id}}" style="text-decoration: none; width:100%">
                        <div class="iq-blog iq-blog-box">
                            Semua
                        </div>
                    </a>
                    @elseif(!empty($fil_kata) && !empty($fil_jenis))
                    <a class="btn btn-success" href="{{ url($current) }}?search={{ $searched }}&kondisi={{$fil_jenis->id}}" style="text-decoration: none; width:100%">
                        <div class="iq-blog iq-blog-box">
                            Semua
                        </div>
                    </a>
                    @else
                    <a class="btn btn-success" href="{{ url($current) }}" style="text-decoration: none; width:100%">
                        <div class="iq-blog iq-blog-box">
                            Semua
                        </div>
                    </a>
                    @endif
                </div>
                <div class="row d-flex justify-content-center">
                    @foreach ($kondisi as $knd)
                        @if (!empty($fil_kata) && empty($fil_jenis))
                            @php
                                $searched = urlencode($fil_kata);
                            @endphp
                            <div class="col-lg-6 col-md-6 col-sm-6 col-6" style=" padding:0.25rem">
                                <a class="btn btn-success"
                                    href="{{ $current }}?search={{ $searched }}&kondisi={{ $knd->id }}"
                                    style="text-decoration: none">
                                    {{ $knd->kondisi }}
                                </a>
                            </div>
                        @elseif(empty($fil_kata) && !empty($fil_jenis))
                            <div class="col-lg-6 col-md-6 col-sm-6 col-6" style=" padding:0.25rem">
                                <a class="btn btn-success"
                                    href="{{ $current }}?jenis={{ $fil_jenis->id }}&kondisi={{ $knd->id }}"
                                    style="text-decoration: none">
                                    {{ $knd->kondisi }}
                                </a>
                            </div>
                        @elseif(!empty($fil_kata) && !empty($fil_jenis))
                            <div class="col-lg-6 col-md-6 col-sm-6 col-6" style=" padding:0.25rem">
                                <a class="btn btn-success"
                                    href="{{ $current }}?search={{ $searched }}&jenis={{ $fil_jenis->id }}&kondisi={{ $knd->id }}"
                                    style="text-decoration: none">
                                    {{ $knd->kondisi }}
                                </a>
                            </div>
                        @else
                            <div class="col-lg-6 col-md-6 col-sm-6 col-6" style="padding:0.25rem">
                                <a class="btn btn-success w-100"
                                    href="{{ $current }}?kondisi={{ $knd->id }}"
                                    style="text-decoration: none;">
                                    {{ $knd->kondisi }}
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Navbar -->
