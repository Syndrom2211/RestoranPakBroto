    <!-- CONTENT-WRAPPER SECTION END-->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    &copy; 2017 Restoran Pak Broto
                </div>

            </div>
        </div>
    </footer>
    <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.11.1.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
	<script type="text/javascript">
	window.onload=function(){
	var defaultDate = new Date();
	hour = "" + defaultDate.getHours(); if (hour.length == 1) { hour = "0" + hour; }
	minute = "" + defaultDate.getMinutes(); if (minute.length == 1) { minute = "0" + minute; }
	second = "" + defaultDate.getSeconds(); if (second.length == 1) { second = "0" + second; }
	document.forms[0]['waktu_pesan'].value = hour + ":" + minute + ":" + second;;
	}
	</script>
	
	<script type="text/javascript">
	function konfirmasiHapusMakanan(no_makanan,nama){
		var no_makanan = no_makanan;
		var nama = nama;

		konfirmasi = confirm("Apakah Makanan dengan menu '"+nama+"' akan di hapus?")
		if(konfirmasi){
			window.location = "data_menu.php?hapus="+no_makanan;
			return false;
		}else{
			alert("Batal Menghapus Menu Makanan");
		}
	}
	
	function konfirmasiHapusPegawai(no_pegawai,nama){
		var no_pegawai = no_pegawai;
		var nama = nama;

		konfirmasi = confirm("Apakah Pegawai bernama '"+nama+"' akan di hapus?")
		if(konfirmasi){
			window.location = "data_pegawai.php?hapus="+no_pegawai;
			return false;
		}else{
			alert("Batal Menghapus Pegawai");
		}
	}
	
	function konfirmasiHapusPemesanan(no_pelanggan,atas_nama){
		var no_pelanggan = no_pelanggan;
		var atas_nama = atas_nama;

		konfirmasi = confirm("Apakah Pelanggan bernama '"+atas_nama+"' akan di hapus?")
		if(konfirmasi){
			window.location = "data_pemesanan.php?hapus="+no_pelanggan;
			return false;
		}else{
			alert("Batal Menghapus Pelanggan");
		}
	}
	
	function konfirmasiHapusPembayaran(id_transaksi,atas_nama){
		var id_transaksi = id_transaksi;
		var atas_nama = atas_nama;

		konfirmasi = confirm("Apakah Pelanggan bernama '"+atas_nama+"' akan di hapus?")
		if(konfirmasi){
			window.location = "data_pembayaran.php?hapus="+id_transaksi;
			return false;
		}else{
			alert("Batal Menghapus Pelanggan");
		}
	}
	
	function konfirmasiHapusBahanBaku(no_bahan,nama){
		var no_bahan = no_bahan;
		var nama = nama;

		konfirmasi = confirm("Apakah Bahan Baku '"+nama+"' akan di hapus?")
		if(konfirmasi){
			window.location = "data_bahanbaku.php?hapus="+no_bahan;
			return false;
		}else{
			alert("Batal Menghapus Pelanggan");
		}
	}
	
	function konfirmasiHapusDetailBahanBaku(no_bahan,nama){
		var no_bahan = no_bahan;
		var nama = nama;

		konfirmasi = confirm("Apakah Bahan Baku '"+nama+"' akan di hapus?")
		if(konfirmasi){
			window.location = "data_bahanbaku.php?hapus="+no_bahan;
			return false;
		}else{
			alert("Batal Menghapus Pelanggan");
		}
	}
	
	</script>
	
	<!-- Plugin -->
    <script src="assets/js/SimpleCalculadorajQuery.js"></script>

	<!-- Untuk ClockPicker -->
	<script src="assets/js/jquery-clockpicker.min.js"></script>
	
	<script src="assets/js/jquery-ui.js" type="text/javascript"></script>

	<script>
	  $(function() {
		$( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
	  });
	</script>
	
	<script type="text/javascript">
	$("#idCalculadora").Calculadora();               
	</script>
	
	<script type="text/javascript">
	var input = $('#input-a');
	var input_dua = $('#input-b');
	input.clockpicker({
		autoclose: true
	});
	
	input_dua.clockpicker({
		autoclose: true
	});
	</script>