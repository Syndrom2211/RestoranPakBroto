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
			if(isset($_GET['aksi']) == "tambahbahanbaku"){
				if(isset($_POST["submit"])){
						tambah_bahanbaku();
				}
			?>
			<form action="" method="POST">
			<div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                           Tambah Bahan Baku
                        </div>
                        <div class="panel-body">
                       <form action="" method="POST">
					   <div class="form-group">
							<label for="exampleInputEmail1">Nama Pegawai</label>
							<select name="no_pegawai" class="form-control">
							<?php
							$sql = mysql_query("SELECT * FROM pegawai WHERE id_jabatan = '2'");
							while($hasil = mysql_fetch_array($sql)){
							?>
								<option value="<?php echo $hasil["no_pegawai"]; ?>"><?php echo $hasil["nama"]; ?></option>
							<?php
							}
							?>
							</select>
						  </div>
						  <?php $random = rand(10,100); ?>
								<input type="hidden" class="form-control" id="exampleInputPassword1" name="no_bahan" value="<?php echo $random; ?>" />
						  <div class="form-group">
							<label for="exampleInputEmail1">Nama Bahan Baku</label>
							<input type="text" class="form-control" id="exampleInputEmail1" name="nama_bahan_baku" />
						  </div>
						  <div class="form-group">
							<label for="exampleInputPassword1">Jenis Bahan Baku</label>
							<input type="text" class="form-control" id="exampleInputPassword1" name="jenis_bahan_baku" />
						  </div>
						  <div class="form-group">
							<label for="exampleInputPassword1">Tanggal Masuk</label>
							<input type="text" class="form-control" id="exampleInputPassword1" name="tanggal_masuk" value="<?php $tgl = date('Y-m-d'); echo $tgl; ?>" readonly />
						  </div>
						  <div class="form-group">
							<label for="exampleInputPassword1">Tanggal Kadaluarsa</label>
							<input type="text" class="form-control" id="datepicker" name="tanggal_kadaluarsa" />
						  </div>
						  <div class="form-group">
							<input type="hidden" class="form-control" id="exampleInputPassword1" name="status_bahan_baku" value="Tersedia" />
						  </div>
						  <button type="submit" name="submit" class="btn btn-default">Tambah</button>
						</form>
                            </div>
                            </div>
                    </div>
				</form>
				<?php
			}else if(isset($_POST['cari'])){	
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
			}else if(isset($_GET['edit']) != ""){	
				$no_bahan = $_GET["edit"];
				$sql = mysql_query("SELECT * FROM bahan_baku INNER JOIN detail_bahanbaku ON bahan_baku.no_bahan = detail_bahanbaku.no_bahan WHERE detail_bahanbaku.no_bahan = '$no_bahan'");
				$hasil = mysql_fetch_array($sql);
				
				if(isset($_POST["edit"])){
					edit_bahanbaku($no_bahan);
				}
			?>
			<form action="" method="POST">
			<div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                           Ubah Bahan Baku
                        </div>
                        <div class="panel-body">
                       <form action="" method="POST">
								<input type="hidden" class="form-control" id="exampleInputPassword1" name="no_bahan" value="<?php echo $hasil["no_bahan"]; ?>" />
						  <div class="form-group">
							<label for="exampleInputEmail1">Nama Bahan Baku</label>
							<input type="text" class="form-control" id="exampleInputEmail1" name="nama_bahan_baku" value="<?php echo $hasil["nama"]; ?>" />
						  </div>
						  <div class="form-group">
							<label for="exampleInputPassword1">Jenis Bahan Baku</label>
							<input type="text" class="form-control" id="exampleInputPassword1" name="jenis_bahan_baku" value="<?php echo $hasil["jenis"]; ?>" />
						  </div>
						  <div class="form-group">
							<label for="exampleInputPassword1">Tanggal Kadaluarsa</label>
							<input type="text" class="form-control" id="datepicker" name="tanggal_kadaluarsa" value="<?php echo $hasil["tgl_kadaluarsa"]; ?>" />
						  </div>
						  <div class="form-group">
						  	<label for="exampleInputPassword1">Status Bahan Baku</label>
							<select class="form-control" name="status_bahan_baku">
								<option value="Tersedia">Tersedia</option>
								<option value="Tidak Tersedia">Tidak Tersedia</option>
							</select>
						  </div>
						  <button type="submit" name="edit" class="btn btn-default">Edit</button>
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
										$sql = mysql_query("SELECT * FROM bahan_baku");
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