@if (session()->has('warning'))
    <div class="toastify on  toastify-center toastify-top alert" role="alert"
        style="background: rgb(255, 193, 7); transform: translate(0px, 0px); top: 15px;">
        {{ session('warning') }}
        <span class="toast-close" data-bs-dismiss="alert" aria-label="Close">✖</span>
    </div>
@elseif (session()->has('success'))
    <div class="toastify on  toastify-center toastify-top alert" role="alert"
        style="background:rgb(25, 135, 84); transform: translate(0px, 0px); top: 15px;">
        {{ session('success') }}
        <span class="toast-close" data-bs-dismiss="alert" aria-label="Close">✖</span>
    </div>
@elseif (session()->has('danger'))
    <div class="toastify on  toastify-center toastify-top alert" role="alert"
        style="background: rgb(220, 53, 69); transform: translate(0px, 0px); top: 15px;">
        {{ session('danger') }}
        <span class="toast-close" data-bs-dismiss="alert" aria-label="Close">✖</span>
    </div>
@endif

{{-- @if (!empty(Illuminate\Support\Arr::flatten($errors->default))) --}}
@php
    $error = $errors->toarray();
    // $error2 = Illuminate\Support\Arr::flatten($errors);
    $error3 = Illuminate\Support\Arr::flatten($error);
    // dd(get_defined_vars());
    // dd(session('last_edit'));
    // dd($errors, $errors->default, Illuminate\Support\Arr::flatten($errors->default), Illuminate\Support\Arr::flatten($errors), $error, $error2, $error3);
@endphp
{{-- @endif --}}
@php
    $i = 1;
    $num = 15;
@endphp
@foreach ($error3 as $errors4)
    @php
        $top = 0 + $i * $num;
    @endphp
    {{-- @foreach ($default as $default1)
        @foreach ($messages as $messages1) --}}
    <div class="toastify on  toastify-center toastify-top alert" autoClose="5000" role="alert"
        style="background: rgb(220, 53, 69); transform: translate(0px, 0px); top: {{ $top }}px;">
        {{ $errors4 }} 
        <span class="toast-close" data-bs-dismiss="alert" aria-label="Close">✖</span>
    </div>
    @php
        $i += 4;
    @endphp
    {{-- @endforeach
    @endforeach --}}
@endforeach
{{-- @foreach ($error as $id_produk => $produk)
@foreach ($produk->slice(0, 1) as $produk1) --}}
{{-- @error('')
<div class="toastify on  toastify-center toastify-top alert" role="alert" style="background: rgb(220, 53, 69); transform: translate(0px, 0px); top: 15px;">
    {{ session('danger') }}
    <span class="toast-close" data-bs-dismiss="alert" aria-label="Close">✖</span>
</div>
    {{ $message }}
@enderror --}}
