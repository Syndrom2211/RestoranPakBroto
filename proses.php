<?php
include "include/koneksi.php";

// Login
function login(){
	if(isset($_POST['submit'])){
		$username = $_POST['username'];
		$password = $_POST['password'];
		$id_jabatan  = $_POST['jabatan'];
		$sql = mysql_query("SELECT * FROM pegawai WHERE id_jabatan='$id_jabatan' && username='$username' && password='".md5($password)."'");
		$hasil = mysql_fetch_array($sql);
		$num = mysql_num_rows($sql);
		if($num==1){
			$_SESSION['nama'] = $hasil['nama'];
			$_SESSION['username'] = $username;
			
			if($id_jabatan == '1'){
				$_SESSION['jabatan'] = 'Pelayan';
				echo '<meta http-equiv="refresh" content="0; url=data_pemesanan.php">';
			}else if($id_jabatan == '2'){
				$_SESSION['jabatan'] = 'Pantry';
				echo '<meta http-equiv="refresh" content="0; url=data_bahanbaku.php">';
			}else if($id_jabatan == '3'){
				$_SESSION['jabatan'] = 'Customer Service';
				echo '<meta http-equiv="refresh" content="0; url=data_feedback.php">';
			}else if($id_jabatan == '4'){
				$_SESSION['jabatan'] = 'Kasir';
				echo '<meta http-equiv="refresh" content="0; url=data_pemesanan.php">';
			}else if($id_jabatan == '5'){
				$_SESSION['jabatan'] = 'Koki';
				echo '<meta http-equiv="refresh" content="0; url=data_menu.php">';
			}else if($id_jabatan == '6'){
				$_SESSION['jabatan'] = 'Manajer';
				echo '<meta http-equiv="refresh" content="0; url=data_pegawai.php">';
			}else{
				$_SESSION['jabatan'] = NULL;
			}
			
			echo "<script language='javascript'>alert('Login Berhasil')</script>";
		}else{
			echo "<script language='javascript'>alert('Login Gagal')</script>";
			echo '<meta http-equiv="refresh" content="0; url=index.php">';
		}
	}
}

// Logout
function logout(){
	session_destroy();
	header("location:index.php");
}

// Tambah Menu Makanan
function tambah_menu(){
	$no_makanan = $_POST['no_makanan'];
	$nama_makanan = $_POST['nama_makanan'];
	$jenis_makanan = $_POST['jenis_makanan'];
	$harga_makanan = $_POST['harga_makanan'];
	$nama_bahan_baku = $_POST['nama_bahan_baku'];
	
	if(empty($nama_makanan) || empty($jenis_makanan) || empty($harga_makanan)){
		echo "<script language='javascript'>alert('Data jangan ada yang dikosongkan');</script>";
		echo '<meta http-equiv="refresh" content="0; url=data_menu.php?aksi=tambahmenu">';
	}else{
		// Untuk ke tabel menu
		$sql = mysql_query("INSERT INTO menu VALUES(NULL,'$no_makanan','$nama_makanan','$jenis_makanan','$harga_makanan')");
		
		$jumlah_dipilih = count($nama_bahan_baku);
		for($x=0;$x<$jumlah_dipilih;$x++){
			// Untuk ke tabel detail menu
			$sqldua = mysql_query("INSERT INTO detail_menu VALUES(NULL,'$no_makanan','$nama_bahan_baku[$x]','Tersedia')");
		}
	
		echo "<script language='javascript'>alert('Menu makanan berhasil di tambahkan');</script>";
		echo '<meta http-equiv="refresh" content="0; url=data_menu.php">';
	}
}

// Tambah Bahan Baku
function tambah_bahanbaku(){
	$no_bahan 			= $_POST['no_bahan'];
	$no_pegawai 		= $_POST['no_pegawai'];
	$nama_bahan_baku 	= $_POST['nama_bahan_baku'];
	$jenis_bahan_baku 	= $_POST['jenis_bahan_baku'];
	$tanggal_masuk 		= $_POST['tanggal_masuk'];
	$tanggal_kadaluarsa = $_POST['tanggal_kadaluarsa'];
	$status_bahan_baku 	= $_POST['status_bahan_baku'];
	
	if(empty($nama_bahan_baku) || empty($jenis_bahan_baku) || empty($tanggal_kadaluarsa)){
		echo "<script language='javascript'>alert('Data jangan ada yang dikosongkan');</script>";
		echo '<meta http-equiv="refresh" content="0; url=data_bahanbbaku.php?aksi=tambahbahanbaku">';
	}else{
		// Ke table bahan baku
		$sql = mysql_query("INSERT INTO bahan_baku VALUES(NULL,'$no_bahan','$nama_bahan_baku','$jenis_bahan_baku','$status_bahan_baku')");
		
		// Ke tabel detail bahan baku
		$sqldua = mysql_query("INSERT INTO detail_bahanbaku VALUES(NULL,'$no_bahan','$no_pegawai',NULL,NULL,'$tanggal_masuk','$tanggal_kadaluarsa')");
		
		echo "<script language='javascript'>alert('Bahan baku berhasil di tambahkan');</script>";
		echo '<meta http-equiv="refresh" content="0; url=data_bahanbaku.php">';
	}
}

// Tambah Pembayaran
function tambah_pembayaran(){
	$nama_pelanggan 	= $_POST['nama_pelanggan'];
	$makanan_pesanan	= $_POST['makanan_pesanan'];
	$tgl_bayar 			= $_POST['tgl_bayar'];
	$waktu_bayar 		= $_POST['waktu_pesan'];
	$total_bayar 		= $_POST['total_bayar'];
	$status_bayar		= "Sudah Bayar";
	
	if(empty($total_bayar) || empty($makanan_pesanan)){
		echo "<script language='javascript'>alert('Data jangan ada yang dikosongkan');</script>";
		echo '<meta http-equiv="refresh" content="0; url=data_pemesanan.php?bayar='.$no_pelanggan.'">';
	}else{
		$sql = mysql_query("INSERT INTO pembayaran VALUES(NULL,'$nama_pelanggan','$makanan_pesanan','$tgl_bayar','$waktu_bayar','$total_bayar','$status_bayar')");
		echo "<script language='javascript'>alert('Pembayaran berhasil ditambahkan');</script>";
		echo '<meta http-equiv="refresh" content="0; url=data_pembayaran.php">';
	}
}

// Tambah Kritik dan Saran
function tambah_kritiksaran(){
	$no_pelanggan	 	= $_POST['no_pelanggan'];
	$kritik_saran		= $_POST['kritik_saran'];
	
	if(empty($kritik_saran)){
		echo "<script language='javascript'>alert('Data jangan dikosongkan');</script>";
		echo '<meta http-equiv="refresh" content="0; url=data_feedback.php?aksi=tambahkritiksaran">';
	}else{
		$sql = mysql_query("UPDATE pelanggan SET kritik_saran='$kritik_saran' WHERE no_pelanggan='$no_pelanggan'");
		echo "<script language='javascript'>alert('Kritik dan saran berhasil ditambahkan');</script>";
		echo '<meta http-equiv="refresh" content="0; url=data_feedback.php">';
	}
}

// Tambah Pemesanan
function tambah_pemesanan(){
	$nama_pelanggan 	= $_POST['nama_pelanggan'];
	$nama_makanan 		= $_POST['nama_makanan'];
	$tanggal_pesan 		= $_POST['tanggal_pesan'];
	$waktu_pesan 		= $_POST['waktu_pesan'];
	$no_meja 			= $_POST['no_meja'];
	$status_pembuatan 	= $_POST['status_pembuatan'];
	
	$nilairandom	= $_POST["nilai_random"];
	$nama_pelayan 	= $_POST['nama_pelayan'];
	$jenis_kelamin 	= $_POST['jenis_kelamin'];
	$no_handphone 	= $_POST['no_handphone'];
	
	if(empty($nama_pelanggan) || empty($nama_makanan) || empty($no_meja)){
		echo "<script language='javascript'>alert('Data jangan ada yang dikosongkan');</script>";
		echo '<meta http-equiv="refresh" content="0; url=data_pemesanan.php?aksi=tambahpemesanan">';
	}else{
		// Untuk ke tabel pelanggan
		$sql = mysql_query("INSERT INTO pelanggan VALUES(NULL,'$nilairandom','$nama_pelayan','$nama_pelanggan','$jenis_kelamin','$no_handphone',NULL)");
		
		// Untuk ke tabel pemesanan
		$sqldua = mysql_query("INSERT INTO pemesanan VALUES(NULL,'$nilairandom','$tanggal_pesan','$waktu_pesan','$no_meja','$status_pembuatan')");
		
		$jumlah_dipilih = count($nama_makanan);
		
		for($x=0;$x<$jumlah_dipilih;$x++){
			// Untuk ke tabel menu pemesanan
			$sqlempat = mysql_query("INSERT INTO menu_pesanan VALUES(NULL,'$nilairandom','$nama_makanan[$x]')");
		}
		
		echo "<script language='javascript'>alert('Pemesanan makanan berhasil di tambahkan');</script>";
		echo '<meta http-equiv="refresh" content="0; url=data_pemesanan.php">';
	}
}

// Tambah Pegawai
function tambah_pegawai(){
	$nama_pegawai 		= $_POST['nama_pegawai'];
	$jabatan 			= $_POST['jabatan']; 
	$username 			= $_POST['username'];
	$password 			= $_POST['password'];
	$jenis_kelamin 		= $_POST['jenis_kelamin'];
	$alamat 			= $_POST['alamat'];
	$no_handphone 		= $_POST['no_handphone'];
	$waktu_kerja_start 	= $_POST['waktu_kerja_start'];
	$waktu_kerja_end 	= $_POST['waktu_kerja_end'];
	$bagian_kerja 		= $_POST['bagian_kerja'];
	
	if(empty($nama_pegawai) || empty($username) || empty($password) || empty($jenis_kelamin) || empty($alamat) || empty($no_handphone) || empty($waktu_kerja_start) || empty($waktu_kerja_end) || empty($bagian_kerja)){
		echo "<script language='javascript'>alert('Data jangan ada yang dikosongkan');</script>";
		echo '<meta http-equiv="refresh" content="0; url=data_pegawai.php?aksi=tambahpegawai">';
	}else{
		$sql = mysql_query("INSERT INTO pegawai VALUES(NULL,'$jabatan','$nama_pegawai','$username','".md5($password)."','$jenis_kelamin','$alamat','$no_handphone',CONCAT('$waktu_kerja_start',' - ','$waktu_kerja_end'),'$bagian_kerja')");
		echo "<script language='javascript'>alert('Data pegawai berhasil di tambahkan');</script>";
		echo '<meta http-equiv="refresh" content="0; url=data_pegawai.php">';
	}
}

// Hapus Menu Makanan
function hapus_menu($no_makanan){
	$hapus = mysql_query("DELETE FROM menu WHERE no_makanan=".$no_makanan."");
	if($hapus){
		echo "<script language='javascript'>alert('Data berhasil di hapus');</script>";
		 echo '<meta http-equiv="refresh" content="0; url=data_menu.php">';
	}
}

// Hapus Pegawai
function hapus_pegawai($no_pegawai){
	$hapus = mysql_query("DELETE FROM pegawai WHERE no_pegawai=".$no_pegawai."");
	if($hapus){
		echo "<script language='javascript'>alert('Data pegawai berhasil di hapus');</script>";
		 echo '<meta http-equiv="refresh" content="0; url=data_pegawai.php">';
	}
}

// Hapus Pemesanan
function hapus_pemesanan($no_pelanggan){
	$hapus = mysql_query("DELETE FROM pemesanan WHERE no_pelanggan=".$no_pelanggan."");
	if($hapus){
		echo "<script language='javascript'>alert('Data pemesanan berhasil di hapus');</script>";
		 echo '<meta http-equiv="refresh" content="0; url=data_pemesanan.php">';
	}
}

// Hapus Pembayaran
function hapus_pembayaran($id_transaksi){
	$hapus = mysql_query("DELETE FROM pembayaran WHERE id_transaksi=".$id_transaksi."");
	if($hapus){
		echo "<script language='javascript'>alert('Data pembayaran berhasil di hapus');</script>";
		 echo '<meta http-equiv="refresh" content="0; url=data_pembayaran.php">';
	}
}

// Hapus Bahan Baku
function hapus_bahanbaku($no_bahan){
	$hapus = mysql_query("DELETE FROM bahan_baku WHERE no_bahan=".$no_bahan."");
	if($hapus){
		echo "<script language='javascript'>alert('Data bahan baku berhasil di hapus');</script>";
		 echo '<meta http-equiv="refresh" content="0; url=data_bahanbaku.php">';
	}
}

// Edit Menu Makanan
function edit_menu($no_makanan){
	$nama_makanan = $_POST['nama_makanan'];
	$jenis_makanan = $_POST['jenis_makanan'];
	$harga_makanan = $_POST['harga_makanan'];
	
	if(empty($nama_makanan) || empty($jenis_makanan) || empty($harga_makanan)){
		echo "<script language='javascript'>alert('Data jangan ada yang dikosongkan');</script>";
		echo '<meta http-equiv="refresh" content="0; url=data_menu.php?edit='.$no_makanan.'">';
	}else{
		$sql = mysql_query("UPDATE menu SET nama='$nama_makanan', jenis='$jenis_makanan', harga='$harga_makanan' WHERE no_makanan = '$no_makanan'");
		echo "<script language='javascript'>alert('Menu makanan berhasil di ubah');</script>";
		echo '<meta http-equiv="refresh" content="0; url=data_menu.php">';
	}
}

//Edit Pegawai
function edit_pegawai($no_pegawai){
	$nama_pegawai 		= $_POST['nama_pegawai'];
	$jabatan 			= $_POST['jabatan']; 
	$username 			= $_POST['username'];
	$password_lama		= $_POST['password_lama'];
	$password_baru		= $_POST['password_baru'];
	$jenis_kelamin 		= $_POST['jenis_kelamin'];
	$alamat 			= $_POST['alamat'];
	$no_handphone 		= $_POST['no_handphone'];
	$waktu_kerja_lama 	= $_POST['waktu_kerja_lama'];
	$waktu_kerja_start_baru 	= $_POST['waktu_kerja_start_baru'];
	$waktu_kerja_end_baru 		= $_POST['waktu_kerja_end_baru'];
	$bagian_kerja 				= $_POST['bagian_kerja'];
	
	$waktu_kerjanya = $waktu_kerja_start_baru." - ".$waktu_kerja_end_baru;
	
	if(empty($nama_pegawai) || empty($alamat) || empty($no_handphone) || empty($bagian_kerja)){
		echo "<script language='javascript'>alert('Data jangan ada yang dikosongkan');</script>";
		echo '<meta http-equiv="refresh" content="0; url=data_menu.php?edit='.$no_makanan.'">';
	}else if($_POST["password_baru"] == "" && $_POST["waktu_kerja_start_baru"] == "" && $_POST["waktu_kerja_end_baru"] == ""){
		$sql = mysql_query("UPDATE pegawai SET id_jabatan='$jabatan', nama='$nama_pegawai', username='$username', password='$password_lama', jenis_kelamin='$jenis_kelamin', alamat='$alamat', no_handphone='$no_handphone', waktu_kerja='$waktu_kerja_lama', bagian_kerja='$bagian_kerja' WHERE no_pegawai = '$no_pegawai'");
		echo "<script language='javascript'>alert('Data pegawai berhasil di ubah');</script>";
		echo '<meta http-equiv="refresh" content="0; url=data_pegawai.php">';
	}else if($_POST["password_baru"] != "" && $_POST["waktu_kerja_start_baru"] == "" && $_POST["waktu_kerja_end_baru"] == ""){
		$sql = mysql_query("UPDATE pegawai SET id_jabatan='$jabatan', nama='$nama_pegawai', username='$username', password='".md5($password_baru)."', jenis_kelamin='$jenis_kelamin', alamat='$alamat', no_handphone='$no_handphone', waktu_kerja='$waktu_kerja_lama', bagian_kerja='$bagian_kerja' WHERE no_pegawai = '$no_pegawai'");
		echo "<script language='javascript'>alert('Data pegawai berhasil di ubah');</script>";
		echo '<meta http-equiv="refresh" content="0; url=data_pegawai.php">';
	}else if($_POST["password_baru"] != "" && $_POST["waktu_kerja_start_baru"] != "" && $_POST["waktu_kerja_end_baru"] == ""){
		echo "<script language='javascript'>alert('Data waktu kerja yang baru jangan di kosongkan !');</script>";
		echo '<meta http-equiv="refresh" content="0; url=data_pegawai.php?edit='.$no_pegawai.'">';
	}else if($_POST["password_baru"] != "" && $_POST["waktu_kerja_start_baru"] != "" && $_POST["waktu_kerja_end_baru"] != ""){
		$sql = mysql_query("UPDATE pegawai SET id_jabatan='$jabatan', nama='$nama_pegawai', username='$username', password='".md5($password_baru)."', jenis_kelamin='$jenis_kelamin', alamat='$alamat', no_handphone='$no_handphone', waktu_kerja='$waktu_kerjanya', bagian_kerja='$bagian_kerja' WHERE no_pegawai = '$no_pegawai'");
		echo "<script language='javascript'>alert('Data pegawai berhasil di ubah');</script>";
		echo '<meta http-equiv="refresh" content="0; url=data_pegawai.php">';
	}else if($_POST["password_baru"] == "" && $_POST["waktu_kerja_start_baru"] != "" && $_POST["waktu_kerja_end_baru"] == ""){
		echo "<script language='javascript'>alert('Data waktu kerja yang baru jangan di kosongkan !');</script>";
		echo '<meta http-equiv="refresh" content="0; url=data_pegawai.php?edit='.$no_pegawai.'">';
	}else if($_POST["password_baru"] == "" && $_POST["waktu_kerja_start_baru"] == "" && $_POST["waktu_kerja_end_baru"] != ""){
		echo "<script language='javascript'>alert('Data waktu kerja yang baru jangan di kosongkan !');</script>";
		echo '<meta http-equiv="refresh" content="0; url=data_pegawai.php?edit='.$no_pegawai.'">';
	}else if($_POST["password_baru"] == "" && $_POST["waktu_kerja_start_baru"] != "" && $_POST["waktu_kerja_end_baru"] != ""){
		$sql = mysql_query("UPDATE pegawai SET id_jabatan='$jabatan', nama='$nama_pegawai', username='$username', password='$password_lama', jenis_kelamin='$jenis_kelamin', alamat='$alamat', no_handphone='$no_handphone', waktu_kerja='$waktu_kerjanya', bagian_kerja='$bagian_kerja' WHERE no_pegawai = '$no_pegawai'");
		echo "<script language='javascript'>alert('Data pegawai berhasil di ubah');</script>";
		echo '<meta http-equiv="refresh" content="0; url=data_pegawai.php">';
	}else{
		echo "<script language='javascript'>alert('Data gagal di ubah !');</script>";
		echo '<meta http-equiv="refresh" content="0; url=data_pegawai.php?edit='.$no_pegawai.'">';
	}
}

// Edit Pemesanan Pelayan
function edit_pemesanan_pelayan($no_pelanggan){
	$no_meja 			= $_POST['no_meja'];
	
	$nama_pelayan 		= $_POST['nama_pelayan'];
	$nama_pelanggan 	= $_POST['nama_pelanggan'];
	$jenis_kelamin 		= $_POST['jenis_kelamin'];
	$no_handphone 		= $_POST['no_handphone'];
	$no_pelanggan		= $_POST["no_pelanggan"];
	
	if(empty($nama_pelanggan) || empty($no_handphone) || empty($no_meja)){
		echo "<script language='javascript'>alert('Data jangan ada yang dikosongkan');</script>";
		echo '<meta http-equiv="refresh" content="0; url=data_pemesanan.php?edit='.$no_pelanggan.'">';
	}else{
		// Untuk ke tabel pelanggan
		/* --> tidak terupdate */ $sqlsatu = mysql_query("UPDATE pelanggan SET no_pegawai='$nama_pelayan', atas_nama='$nama_pelanggan', jenis_kelamin='$jenis_kelamin', no_handphone='$no_handphone' WHERE no_pelanggan='$no_pelanggan'");
		
		// Untuk ke tabel pemesanan
		$sqldua = mysql_query("UPDATE pemesanan SET no_meja='$no_meja' WHERE no_pelanggan='$no_pelanggan'");
		
		echo "<script language='javascript'>alert('Pemesanan makanan berhasil di ubah');</script>";
		echo '<meta http-equiv="refresh" content="0; url=data_pemesanan.php">';
	}
}

// Edit Pemesanan Koki
function edit_pemesanan_koki($no_pelanggan){
	
	$no_pelanggan 		= $_POST['no_pelanggan'];
	$status_pembuatan 	= $_POST['status_pembuatan'];
	
	if(empty($status_pembuatan)){
		echo "<script language='javascript'>alert('Data jangan ada yang dikosongkan');</script>";
		echo '<meta http-equiv="refresh" content="0; url=data_pemesanan.php?edit='.$no_pelanggan.'">';
	}else{
		// Untuk ke tabel pemesanan
		$sql = mysql_query("UPDATE pemesanan SET status_pembuatan='$status_pembuatan' WHERE no_pelanggan='$no_pelanggan'");
		
		echo "<script language='javascript'>alert('Status Pembuatan makanan berhasil di ubah');</script>";
		echo '<meta http-equiv="refresh" content="0; url=data_pemesanan.php">';
	}
}

// Edit Pembayaran
function edit_pembayaran($id_transaksi){
	$id_transaksi	 	= $_POST['id_transaksi'];
	$makanan_pesanan	= $_POST['makanan_pesanan'];
	$total_bayar 		= $_POST['total_bayar'];
	$status_bayar		= $_POST['status_bayar'];
	
	if(empty($total_bayar) || empty($status_bayar)){
		echo "<script language='javascript'>alert('Data jangan ada yang dikosongkan');</script>";
		echo '<meta http-equiv="refresh" content="0; url=data_pemesanan.php?edit='.$id_transaksi.'">';
	}else{
		// Untuk ke tabel pemesanan
		$sql = mysql_query("UPDATE pembayaran SET makanan_pesanan='$makanan_pesanan', total_bayar='$total_bayar', status_bayar='$status_bayar' WHERE id_transaksi='$id_transaksi'");
		
		echo "<script language='javascript'>alert('Perubahan pada data pembayaran berhasil');</script>";
		echo '<meta http-equiv="refresh" content="0; url=data_pembayaran.php">';
	}
}

// Edit Bahan Baku
function edit_bahanbaku($no_bahan){
	$no_bahan	 			= $_POST['no_bahan'];
	$nama_bahan_baku		= $_POST['nama_bahan_baku'];
	$jenis_bahan_baku 		= $_POST['jenis_bahan_baku'];
	$tanggal_kadaluarsa		= $_POST['tanggal_kadaluarsa'];
	$status_bahan_baku		= $_POST['status_bahan_baku'];

	if(empty($nama_bahan_baku) || empty($jenis_bahan_baku) || empty($tanggal_kadaluarsa) || empty($status_bahan_baku)){
		echo "<script language='javascript'>alert('Data jangan ada yang dikosongkan');</script>";
		echo '<meta http-equiv="refresh" content="0; url=data_bahanbaku.php?edit='.$no_bahan.'">';
	}else{
		// Untuk ke tabel bahan baku
		$sql = mysql_query("UPDATE bahan_baku SET nama='$nama_bahan_baku', jenis='$jenis_bahan_baku', status_bahan_baku='$status_bahan_baku' WHERE no_bahan='$no_bahan'");
		
		// Untuk ke tabel detail bahan baku
		$sqldua = mysql_query("UPDATE detail_bahanbaku SET tgl_kadaluarsa='$tanggal_kadaluarsa' WHERE no_bahan='$no_bahan'");
		
		echo "<script language='javascript'>alert('Perubahan pada data bahan baku berhasil');</script>";
		echo '<meta http-equiv="refresh" content="0; url=data_bahanbaku.php">';
	}
}

// Edit Kritik dan Saran
function edit_kritiksaran($no_pelanggan){
	$no_pelanggan	 		= $_POST['no_pelanggan'];
	$kritik_saran			= $_POST['kritik_saran'];

	if(empty($kritik_saran)){
		echo "<script language='javascript'>alert('Data jangan dikosongkan');</script>";
		echo '<meta http-equiv="refresh" content="0; url=data_feedback.php?edit='.$kritik_saran.'">';
	}else{
		// Untuk ke tabel bahan baku
		$sql = mysql_query("UPDATE pelanggan SET kritik_saran='$kritik_saran' WHERE no_pelanggan='$no_pelanggan'");
		
		echo "<script language='javascript'>alert('Perubahan kritik dan saran berhasil');</script>";
		echo '<meta http-equiv="refresh" content="0; url=data_feedback.php">';
	}
}

// Cek Bahan Baku
function cek_bahanbaku($no_bahan){
	$no_bahan	 			= $_POST['no_bahan'];
	$waktu_cek				= $_POST['waktu_cek'];

	$satuminggu = strtotime('+7 day' , strtotime ($waktu_cek));
	$satuminggu = date ('Y-m-d' , $satuminggu);
	
	if(empty($waktu_cek)){
		echo "<script language='javascript'>alert('Data jangan dikosongkan');</script>";
		echo '<meta http-equiv="refresh" content="0; url=data_laporan_bahanbaku">';
	}else{
		// Untuk ke tabel detail bahan baku
		$sqldua = mysql_query("UPDATE detail_bahanbaku SET pengecekan_bahan='$waktu_cek', pengecekan_selanjutnya='$satuminggu' WHERE no_bahan='$no_bahan'");
		
		echo "<script language='javascript'>alert('Perubahan pada data bahan baku berhasil');</script>";
		echo '<meta http-equiv="refresh" content="0; url=data_laporan_bahanbaku.php">';
	}
}

?>