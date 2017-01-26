<?php
session_start();
if(isset($_SESSION['username'])){
	include "proses.php";
	include "include/koneksi.php";
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<?php include "include/header.php"; ?>
<body>
	<header>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <strong>Login Sebagai : </strong><?php echo $_SESSION['jabatan']; ?>
                </div>

            </div>
        </div>
    </header>
    <!-- HEADER END-->
    <div class="navbar navbar-inverse set-radius-zero">
        <div class="container" style="height:120px;>
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="home.php">

                    <img src="assets/img/logo.png" />
                </a>

            </div>

        </div>
    </div>
    <!-- LOGO HEADER END-->
    <section class="menu-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php include "include/navigation.php"; ?>
                </div>

            </div>
        </div>
    </section>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
		<h4 class="page-head-line">DATA BAHAN BAKU</h4>
		<?php
		if(isset($_POST['cari'])){	
			?>
			<div class="row">
                <div class="col-md-12">
                    
					<form action="" method="POST" style="margin-bottom:10px;">
											<div style="float:right;width:220px;margin:0px 5px 5px 0px"><input type="text" name="datacari" class="form-control"  />
						</div>
						<button type="submit" name="cari" style="float:right;margin:0px 5px 5px 0px" class="btn btn-default"><i class=" fa fa-refresh "></i> Cari Bahan Baku</button>
					</form>
						<a href="data_bahanbaku.php?aksi=tambahbahanbaku"><button style="float:left;margin:0px 5px 5px 0px" class="btn btn-default"><i class=" fa fa-refresh "></i> Tambah Bahan Baku </button></a>
					
					
					
                </div>

            </div>
			
            <div class="row">
                <div class="col-md-12">
                     <!--    Hover Rows  -->
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
										<tr>
											<th>No</th>
                                            <th>No Bahan</th>
                                            <th>Nama Bahan Baku</th>
                                            <th>Jenis</th>
                                            <th>Status Bahan Baku</th>
											<th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php
										$i = 1;
										$pencarian = $_POST["datacari"];
										$sql = mysql_query("SELECT * FROM bahan_baku WHERE no_bahan REGEXP '$pencarian.*' OR nama REGEXP '$pencarian.*' OR jenis REGEXP '$pencarian.*' OR status_bahan_baku REGEXP '$pencarian.*'");
										while($hasil = mysql_fetch_array($sql)){
										?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
											<td><?php echo $hasil['no_bahan']; ?></td>
                                            <td><?php echo $hasil['nama']; ?></td>
                                            <td><?php echo $hasil['jenis']; ?></td>
											<td>
												<?php 
												if($hasil['status_bahan_baku'] == "Tersedia"){
													echo "<font color='lime'>Tersedia</font>"; 
												}else if($hasil['status_bahan_baku'] == "Tidak Tersedia"){
													echo "<font color='red'>Tidak Tersedia</font>"; 
												}
												?>
											</td>
											<td><a href="data_bahanbaku.php?edit=<?php echo $hasil["no_bahan"]; ?>"><button class="btn btn-primary"><i class="fa fa-edit "></i> Ubah Bahan Baku</button></a>
											<?php echo "<a href='#' onClick=\"return konfirmasiHapusBahanBaku('".$hasil["no_bahan"]."','".$hasil["nama"]."');\" value='Hapus'><button class=\"btn btn-danger\">";?><i class="fa fa-trash"></i> Hapus Bahan Baku</button></a></td>
                                        </tr>
										<?php
										$i++;
										}
										if(isset($_GET['hapus']) != ""){
											return hapus_bahanbaku($_GET['hapus']);
										}
										?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- End  Hover Rows  -->
                </div>

            </div>
			<?php
			}else if(isset($_GET['cek']) != ""){	
				$no_bahan = $_GET["cek"];
				$sql = mysql_query("SELECT * FROM detail_bahanbaku INNER JOIN pegawai ON detail_bahanbaku.no_pegawai = pegawai.no_pegawai WHERE detail_bahanbaku.no_bahan = '$no_bahan'");
				$hasil = mysql_fetch_array($sql);
				
				if(isset($_POST["cek"])){
					cek_bahanbaku($no_bahan);
				}
			?>
			<form action="" method="POST">
			<div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                           Pengecekan Bahan Baku
                        </div>
                        <div class="panel-body">
                       <form action="" method="POST">
								<input type="hidden" class="form-control" id="exampleInputPassword1" name="no_bahan" value="<?php echo $hasil["no_bahan"]; ?>" />
						  <div class="form-group">
							<label for="exampleInputEmail1">Waktu Pengecekan</label>
							<input id="datepicker" type="text" class="form-control" id="exampleInputEmail1" name="waktu_cek" />
						  </div>
						  <button type="submit" name="cek" class="btn btn-default">Cek</button>
						</form>
                            </div>
                            </div>
                    </div>
				</form>
			<?php
			}else{
			?>
			<div class="row">
                <div class="col-md-12">
                    
					<form action="" method="POST" style="margin-bottom:10px;">
											<div style="float:right;width:220px;margin:0px 5px 5px 0px"><input type="text" name="datacari" class="form-control"  />
						</div>
						<button type="submit" name="cari" style="float:right;margin:0px 5px 5px 0px" class="btn btn-default"><i class=" fa fa-refresh "></i> Cari Bahan Baku</button>
					</form>
					
					
					
                </div>

            </div>
			
            <div class="row">
                <div class="col-md-12">
                     <!--    Hover Rows  -->
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
										<tr>
                                            <th>No</th>
                                            <th>Nama Bahan Baku</th>
                                            <th>Nama Pegawai</th>
                                            <th>Waktu Pengecekan</th>
											<th>Waktu Pengecekan Selanjutnya</th>
											<th>Tgl Masuk</th>
											<th>Tgl Kadaluarsa</th>
											<th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php
										$i = 1;
										$sql = mysql_query("SELECT detail_bahanbaku.no_bahan, bahan_baku.nama AS nama_bahanbaku, pegawai.nama AS nama_pegawai, detail_bahanbaku.pengecekan_bahan, detail_bahanbaku.pengecekan_selanjutnya, detail_bahanbaku.tgl_masuk, detail_bahanbaku.tgl_kadaluarsa FROM detail_bahanbaku INNER JOIN bahan_baku ON detail_bahanbaku.no_bahan = bahan_baku.no_bahan INNER JOIN pegawai ON detail_bahanbaku.no_pegawai = pegawai.no_pegawai");
										while($hasil = mysql_fetch_array($sql)){
										?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
											<td><?php echo $hasil['nama_bahanbaku']; ?></td>
                                            <td><?php echo $hasil['nama_pegawai']; ?></td>
                                            <td><?php echo $hasil['pengecekan_bahan']; ?></td>
											<td><?php echo $hasil['pengecekan_selanjutnya']; ?></td>
											<td><?php echo $hasil['tgl_masuk']; ?></td>
											<td><?php echo $hasil['tgl_kadaluarsa']; ?></td>
											<td><a href="data_laporan_bahanbaku.php?cek=<?php echo $hasil["no_bahan"]; ?>"><button class="btn btn-primary"><i class="fa fa-edit "></i> Cek Bahan Baku</button></a></td>
                                        </tr>
										<?php
										$i++;
										}
										?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- End  Hover Rows  -->
                </div>

            </div>
            <?php
			}
			?>
        </div>
    </div>
	<?php include "include/footer.php"; ?>
</body>
</html>
<?php
}else{
	header("location:index.php");
}
?>