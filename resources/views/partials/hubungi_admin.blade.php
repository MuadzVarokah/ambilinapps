<!--Floating Button-->
<style>
#float{
	position:fixed;
	width:3rem;
	height:3rem;
	bottom:4.1rem;
	right:0.8rem;
    text-align:center;
	box-shadow: 2px 2px 3px #999;
	z-index: 1;
	border: 2.5px solid white;
}
</style>

<a class="btn btn-success btn-lg rounded-circle d-flex justify-content-center align-items-center" id="float" onclick="kirimWA()" role="button">
    <div class="row">
        <div class="col-12" style="padding: 0;"><i class="fa-solid fa-headset"></i></div>
        {{-- <div class="col-12" style="padding: 0;"><p style="font-size: 40%; margin: 0; text-transform: capitalize; font-weight: 500;">Operator</p></div> --}}
    </div>
</a>

<script>
      	function kirimWA() {Website2APK.openExternal("https://wa.me/6281229505900");}
</script>

<!--Floating Button-->