    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style='background-color:#176e41'>
        <!-- Container wrapper -->
        <div class="container-fluid">
            <!-- Navbar brand -->
            @if (!empty($backslug))
            <a class="navbar-brand" href='{{route($back,$backslug)}}'><i class="fa-solid fa-chevron-left"></i></a> 
            @elseif (!empty($back_url))
            <a class="navbar-brand" href="{{ $back_url }}"><i class="fa-solid fa-chevron-left"></i></a>
            @else
            <a class="navbar-brand" href="{{route($back)}}"><i class="fa-solid fa-chevron-left"></i></a>
            @endif
            <p class="navbar-brand" style="margin:0; font-size:90%;font-weight:bold">{{$page}}</p>
            <p style="padding:0 12px">&nbsp;</p>
        </div>
        <!-- Container wrapper -->
    </nav>
    <!-- Navbar -->