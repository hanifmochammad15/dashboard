@extends('layouts/frontend')

@section('pagetitle','Asuransi Personal Kecelakaan')

@section('content')

<style>

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 40%;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
</style>
<!-- Google Analytics -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-99824788-1', 'auto');
  ga('send', 'pageview');

</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-99588226-1', 'auto');
  ga('send', 'pageview');

</script>
<!-- End of Google Analytics -->


	<section class="content-intro intro-kecelakaan"></section>

	<main id="content" class="asuransi-kecelakaan">
		<div class="container">
			<div class="row">
				<div class="col-md-12">	
					<div class="breadcrumb">Personal</div>
				</div>
				<div class="col-md-12">
					<h1 class="text-center">Asuransi Kecelakaan Diri</h1>
					<p>Asuransi Kecelakaan Diri memberikan jaminan terhadap resiko Kematian, Cacat
					Tetap, Biaya Perawatan atau Pengobatan yang disebabkan oleh suatu kecalakaan yang
					diderita.</p>
					<p>Kami menyediakan produk Asuransi Kecelakaan Diri yang dapat disesuaikan
					dengan kebutuhan Anda serta dengan proses pendaftaran dan pembayaran yang mudah
					dan cepat.</p>
				</div>
				<div class="col-md-9">
					<h4>Jaminan</h4>
					<p>Jaminan yang disediakan untuk Asuransi Kecelakaan Diri Personal, antara lain:</p>
					<img src="{{ url('images/jaminan-asuransi-kecelakaan.png') }}">
				</div>
				
			</div>	
		</div>

		<div class="highlight-asuransi">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h4>Prosedur Klaim</h4>
						<ul class="min-style">
							<li>Memberikan Laporan melalui telepon 1x24 jam, disusulkan dengan laporan tertulis serta melengkapi dokumen pendukung.</li>
							<li>Berita acara kecelakaan.</li>
							<li>Surat Keterangan Kepolisian (bila diperlukan)</li>
							<li>Kwitansi Pengobatan</li>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center">
					<a class="btn read-more"  id="myBtn"  href="#">Daftar Sekarang</a>

				</div>
			</div>
		</div>
		
	</main>

	<!-- The Modal -->
	<div id="myModal" class="modal">

	  <!-- Modal content -->
	  <div class="modal-content">
	    <span class="close">&times;</span>
	    <input type="radio" id="instagram" name="choice" value="instagram">
  		<label for="instagram">Instagram</label><br><br>
  		<input type="radio" id="newsletter" name="choice" value="newsletter">
  		<label for="newsletter">Newsletter</label><br><br>
  		<input type="radio" id="facebook" name="choice" value="facebook">
  		<label for="facebook">Facebook</label><br><br>
  		<input type="radio" id="twitter" name="choice" value="twitter">
  		<label for="twitter">Twitter</label><br><br>
  		<input type="radio" id="temankeluarga" name="choice" value="temankeluarga">
  		<label for="temankeluarga">Teman/Keluarga</label><br><br>
  		<input type="radio" id="othermedia" name="choice" value="othermedia">
  		<label for="othermedia">Media lainnya</label><br><br>
  		<input type="radio" id="marketing" name="choice" value="marketing">
  		<label for="marketing">Marketing</label>
  		<br><br>
  		<button id="submitchoice" onclick="hanifFunction()" type="button">Submit</button>

	  </div>

	</div>
	<script type="text/javascript">
			// Get the modal
			var modal = document.getElementById("myModal");

			// Get the button that opens the modal
			var btn = document.getElementById("myBtn");

			// Get the <span> element that closes the modal
			var span = document.getElementsByClassName("close")[0];

			// When the user clicks the button, open the modal 
			btn.onclick = function() {
			  modal.style.display = "block";
			}

			// When the user clicks on <span> (x), close the modal
			span.onclick = function() {
			  modal.style.display = "none";
			}

			// When the user clicks anywhere outside of the modal, close it
			window.onclick = function(event) {
			  if (event.target == modal) {
			    modal.style.display = "none";
			  }
			}
		function hanifFunction(){
			if(document.getElementById("instagram").checked){
		    var x = document.getElementById("instagram").value;
			}
			else if(document.getElementById("newsletter").checked){
		    var x = document.getElementById("newsletter").value;
			}
			else if(document.getElementById("facebook").checked){
		    var x = document.getElementById("facebook").value;
			}
			else if(document.getElementById("twitter").checked){
		    var x = document.getElementById("twitter").value;
			}
			else if(document.getElementById("temankeluarga").checked){
		    var x = document.getElementById("temankeluarga").value;
			}
			else if(document.getElementById("othermedia").checked){
		    var x = document.getElementById("othermedia").value;
			}
			else if(document.getElementById("marketing").checked){
		    var x = document.getElementById("marketing").value;
			}else{
			var x = '';
			}
		    var param='?param='+x;
			var link='https://ecommerce.asuransibintang.com/index.php/payment/pa/index';
			location.replace(link);
		
		}
	</script>

	@include('layouts/frontend-menu')
	@yield('menu-personal')

@endsection

