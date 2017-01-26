<?php
session_start();
if(isset($_SESSION['username']) && isset($_SESSION['jabatan'])){
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
		<h4 class="page-head-line">DATA PEMESANAN</h4>
		<?php
			if(isset($_GET['aksi']) == "tambahpemesanan"){
				if(isset($_POST["submit"])){
						tambah_pemesanan();
				}
			?>
			<form action="" method="POST">
			<div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                           Tambah Pemesanan
                        </div>
                        <div class="panel-body">
					   <div class="form-group">
							<label for="exampleInputEmail1">Nama Pelayan</label>
								<select name="nama_pelayan" class="form-control">
								<?php
								$sql = mysql_query("SELECT * FROM pegawai WHERE id_jabatan='1'");
								while($hasil = mysql_fetch_array($sql)){
								?>
									<option value="<?php echo $hasil["no_pegawai"]; ?>"><?php echo $hasil["nama"]; ?></option>
								<?php
								}
								?>
								</select>
						  </div>
						  <div class="form-group">
							<label for="exampleInputEmail1">Nama Pelanggan</label>
								<?php $random = rand(10,100); ?>
								<input type="hidden" class="form-control" id="exampleInputPassword1" name="nilai_random" value="<?php echo $random; ?>" />
								<input type="text" class="form-control" id="exampleInputPassword1" name="nama_pelanggan" />
						  </div>
						  <div class="form-group">
							<label for="exampleInputEmail1">Jenis Kelamin</label>
								<select name="jenis_kelamin" class="form-control">
									<option value="L">Laki-Laki</option>
									<option value="P">Perempuan</option>
								</select>
						  </div>
						  <div class="form-group">
							<label for="exampleInputEmail1">No Handphone</label>
								<input type="text" class="form-control" id="exampleInputPassword1" name="no_handphone" />
						  </div>
						<hr>
						  <div class="form-group">
							<label for="exampleInputPassword1">Nama Makanan</label> 
							<?php
								$sql = mysql_query("SELECT menu.nama AS menu_makanan, menu.harga, detail_menu.status_makanan, bahan_baku.status_bahan_baku FROM detail_menu INNER JOIN menu ON detail_menu.no_makanan = menu.no_makanan INNER JOIN bahan_baku ON detail_menu.no_bahan = bahan_baku.no_bahan GROUP BY menu.nama");
								while($hasil = mysql_fetch_array($sql)){
									if($hasil["status_bahan_baku"] == "Tidak Tersedia"){
									?>
								<!-- NULL -->
							<?php
									}else if($hasil["status_bahan_baku"] == "Tersedia"){
							?>
							<div class="checkbox">
							<label><input class="form-control" type="checkbox" name="nama_makanan[]" value="<?php echo $hasil["menu_makanan"]; ?> (<?php echo $hasil["harga"]; ?>)" /></label><?php echo $hasil["menu_makanan"];
							?> (<?php echo $hasil["harga"]; ?>)
							</div>
							<?php
								}
							}
								?>
							</div>
						  <div class="form-group">
							<input type="hidden" class="form-control" id="exampleInputPassword1" name="tanggal_pesan" value="<?php $tgl = date('Y-m-d'); echo $tgl; ?>" />
							<input type="hidden" class="form-control" id="exampleInputPassword1" name="waktu_pesan" />
							<div id="clockbox"></div>
						  </div>
						  <div class="form-group">
							<label for="exampleInputPassword1">No Meja</label>
							<input type="text" class="form-control" id="exampleInputPassword1" name="no_meja" />
						  </div>
						  <div class="form-group">
							<input type="hidden" class="form-control" id="exampleInputPassword1" value="Belum Jadi" name="status_pembuatan" />
						  </div>
						  <button type="submit" name="submit" class="btn btn-default">Tambah</button>
                            </div>
                            </div>
                    </div>
				</form>
				<?php
			}else if(isset($_GET['bayar']) != ""){
				$no_pelanggan = $_GET["bayar"];
				$sql = mysql_query("SELECT * FROM menu_pesanan INNER JOIN pelanggan ON menu_pesanan.no_pelanggan = pelanggan.no_pelanggan WHERE menu_pesanan.no_pelanggan = '$no_pelanggan'");
				$hasil = mysql_fetch_array($sql);
				
				$sqldua = mysql_query("SELECT * FROM pelanggan INNER JOIN pembayaran ON pelanggan.no_pelanggan = pembayaran.no_pelanggan");
				$hasildua = mysql_fetch_array($sqldua);
				
				if(isset($_POST["submit"])){
						tambah_pembayaran();
				}
				
				if($hasildua["status_bayar"] == "Sudah Bayar"){
					echo "<script language='javascript'>alert('Pelanggan ini sudah membayar transaksi !');</script>";
					echo '<meta http-equiv="refresh" content="0; url=data_pemesanan.php">';
				}else{
			?>
					<form action="" method="POST">
					<div class="col-md-6">
								<div class="panel panel-default">
								<div class="panel-heading">
								   Tambah Pembayaran
								</div>
								<div class="panel-body">
							   <form action="" method="POST">
								  <div class="form-group">
									<label for="exampleInputEmail1">Nama Pelanggan</label>
									<select name="nama_pelanggan" class="form-control" readonly>
										<option value="<?php echo $hasil["no_pelanggan"]; ?>"><?php echo $hasil["atas_nama"]; ?></option>
									</select>
								  </div>
								  <div class="form-group">
									<label for="exampleInputEmail1">List Makanan Pesanan : </label>
									
									<?php
									$sqldua = mysql_query("SELECT * FROM menu_pesanan INNER JOIN pelanggan ON menu_pesanan.no_pelanggan = pelanggan.no_pelanggan WHERE menu_pesanan.no_pelanggan = '$no_pelanggan'");
									echo "<textarea class='form-control' name='makanan_pesanan'>";
									while($hasillagi = mysql_fetch_array($sqldua)){
										echo $hasillagi["list_menu"].", "; 
									}
									echo "</textarea>";
									?>
									
								  </div>
								  <div class="form-group">
									<input type="hidden" class="form-control" id="exampleInputPassword1" name="tgl_bayar" value="<?php $tgl = date('Y-m-d'); echo $tgl; ?>" />
									<input type="hidden" class="form-control" id="exampleInputPassword1" name="waktu_pesan" />
									<div id="clockbox"></div>
								  </div>
								  <div class="form-group">
									<label for="exampleInputPassword1">Total Bayar</label>
									<input type="text" class="form-control" id="exampleInputPassword1" name="total_bayar" />
								  </div>
								  <button type="submit" name="submit" class="btn btn-default">Tambah</button>
								</form>
									</div>
									</div>
							</div>
						</form>
						<div class="col-md-6">
								<div class="panel panel-default">
								<div class="panel-heading">
								   Kalkulator 
								</div>
								<div class="panel-body">
							   <div id="idCalculadora"> </div>
									</div>
									</div>
							</div>
			<?php
				}
			}else if(isset($_GET['detail']) != ""){
				$no_pelanggan = $_GET["detail"];
				$sql = mysql_query("SELECT * FROM menu_pesanan, pelanggan WHERE menu_pesanan.no_pelanggan = pelanggan.no_pelanggan AND menu_pesanan.no_pelanggan = '$no_pelanggan'");
				$dua = mysql_fetch_array($sql);
			?>
			<div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                           Lihat Detail
                        </div>
                        <div class="panel-body">
					   <div class="form-group">
							<?php
							$sql = mysql_query("SELECT * FROM menu_pesanan");
							$jumlah = mysql_num_rows($sql);
							?>
					   		<label for="exampleInputEmail1">Jumlah Pesanan : <?php echo $jumlah; ?></label>
							<br/>
							<label for="exampleInputEmail1">List Makanan Pesanan : </label>
							<br/>
							<?php
							while($hasil = mysql_fetch_array($sql)){
								echo "- ".$hasil["list_menu"]."<br/>"; 
							}
							?>
							<br/>
						  </div>
						  <a href="data_pemesanan.php"><button class="btn btn-default">Kembali</button>
                            </div>
                            </div>
                    </div>
			<?php
			}else if(isset($_GET['edit']) != ""){	
				$no_pelanggan = $_GET["edit"];
				$sql = mysql_query("SELECT pegawai.no_pegawai, pegawai.nama AS pelayan, pelanggan.no_pelanggan, pelanggan.atas_nama, pelanggan.jenis_kelamin, pelanggan.no_handphone, menu.nama AS nama_makanan, pemesanan.tgl_pesan, pemesanan.waktu_pesan, pemesanan.no_meja, pemesanan.status_pembuatan FROM pelanggan, pemesanan, menu, pegawai WHERE pelanggan.no_pelanggan = pemesanan.no_pelanggan AND pelanggan.no_pegawai = pegawai.no_pegawai AND pemesanan.no_pelanggan = '$no_pelanggan'");
				$hasil = mysql_fetch_array($sql);
				
				if(isset($_POST["edit_pelayan"])){
					edit_pemesanan_pelayan($no_pelanggan);
				}
				
				if(isset($_POST["edit_koki"])){
					edit_pemesanan_koki($no_pelanggan);
				}
			?>
				<?php
				if($_SESSION["jabatan"] == "Pelayan"){
				?>
			<form action="" method="POST">
			<div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                           Ubah Pemesanan
                        </div>
                        <div class="panel-body">
					   <div class="form-group">
							<label for="exampleInputEmail1">Nama Pelayan</label>
							<select name="nama_pelayan" class="form-control">
								<option value="<?php echo $hasil["no_pegawai"]; ?>">[Status] <?php echo $hasil["pelayan"]; ?></option>
								<?php
								$sql = mysql_query("SELECT * FROM pegawai WHERE id_jabatan='1'");
								while($hasildua = mysql_fetch_array($sql)){
								?>
									<option value="<?php echo $hasildua["no_pegawai"]; ?>"><?php echo $hasildua["nama"]; ?></option>
								<?php
								}
								?>
								</select>
						  </div>
						  <div class="form-group">
							<label for="exampleInputEmail1">Nama Pelanggan</label>
							<input type="hidden" class="form-control" id="exampleInputPassword1" name="no_pelanggan" value="<?php echo $no_pelanggan; ?>" />
								<input type="text" class="form-control" id="exampleInputPassword1" name="nama_pelanggan" value="<?php echo $hasil["atas_nama"]; ?>" />
						  </div>
						  <div class="form-group">
							<label for="exampleInputEmail1">Jenis Kelamin</label>
								<select name="jenis_kelamin" class="form-control">
									<?php
									if($hasil["jenis_kelamin"] == "L"){
										$status = "Laki-Laki";
									}else if($hasil["jenis_kelamin"] == "P"){
										$status = "Perempuan";
									}
									?>
									<option value="<?php echo $hasil["jenis_kelamin"]; ?>">[Status] <?php echo $status; ?></option>
									<option value="L">Laki-Laki</option>
									<option value="P">Perempuan</option>
								</select>
						  </div>
						  <div class="form-group">
							<label for="exampleInputEmail1">No Handphone</label>
								<input type="text" class="form-control" id="exampleInputPassword1" name="no_handphone" value="<?php echo $hasil["no_handphone"]; ?>" />
						  </div>
						<hr>
						  <div class="form-group">
							<label for="exampleInputPassword1">No Meja</label>
							<input type="text" class="form-control" id="exampleInputPassword1" name="no_meja" value="<?php echo $hasil["no_meja"]; ?>" />
						  </div>
						  <button type="submit" name="edit_pelayan" class="btn btn-default">Edit</button>
                            </div>
                            </div>
                    </div>
				</form>
					<?php
					}if($_SESSION["jabatan"] == "Koki"){
					?>
					<form action="" method="POST">
				<div class="col-md-6">
							<div class="panel panel-default">
							<div class="panel-heading">
							   Ubah Pemesanan
							</div>
							<div class="panel-body">
							  <div class="form-group">
								<label for="exampleInputPassword1">Status Pembuatan</label>
								<select name="status_pembuatan" class="form-control">
									<option value="Belum Jadi">Belum Jadi</option>
									<option value="Sudah Jadi">Sudah Jadi</option>
								</select>
								<input type="hidden" class="form-control" id="exampleInputPassword1" name="no_pelanggan" value="<?php echo $no_pelanggan; ?>" />
							  </div>
							  <button type="submit" name="edit_koki" class="btn btn-default">Edit</button>
								</div>
								</div>
						</div>
					</form>
					<?php
					}
					?>
			<?php
			}else if(isset($_POST['cari'])){	
			?>
			<div class="row">
                <div class="col-md-12">
                    
					<form action="" method="POST" style="margin-bottom:10px;">
											<div style="float:right;width:220px;margin:0px 5px 5px 0px"><input type="text" name="datacari" class="form-control"  />
						</div>
						<button type="submit" name="cari" style="float:right;margin:0px 5px 5px 0px" class="btn btn-default"><i class=" fa fa-refresh "></i> Cari data pemesanan</button>
					</form>
						<?php
						if($_SESSION["jabatan"] == "Pelayan"){
						?>
						<a href="data_pemesanan.php?aksi=tambahpemesanan"><button style="float:left;margin:0px 5px 5px 0px" class="btn btn-default"><i class=" fa fa-refresh "></i> Tambah Pemesanan </button></a>
						<?php
						}else if($_SESSION["jabatan"] == "Koki"){
							// NULL
						?>
						<?php
						}else if($_SESSION["jabatan"] == "Kasir"){
							// NULL
						}
						?>
					
					
					
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
                                            <th>No Pelanggan</th>
                                            <th>Nama Pelanggan</th>
                                            <th>Tanggal Pesan</th>
											<th>Waktu Pesan</th>
											<?php
											if($_SESSION["jabatan"] == "Pelayan"){
											?>
											<th>No Meja</th>
											<?php
											}else if($_SESSION["jabatan"] == "Koki"){
											?>
											
											<?php
											}
											?>
											<th>Status Pembuatan</th>
											<th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php
										$i = 1;
										$pencarian = $_POST["datacari"];
										$sql = mysql_query("SELECT * FROM pemesanan INNER JOIN pelanggan ON pemesanan.no_pelanggan = pelanggan.no_pelanggan WHERE pelanggan.atas_nama REGEXP '$pencarian.*' OR pemesanan.tgl_pesan REGEXP '$pencarian.*' OR pemesanan.waktu_pesan REGEXP '$pencarian.*' OR pemesanan.no_meja REGEXP '$pencarian.*' OR pemesanan.status_pembuatan REGEXP '$pencarian.*'");
										while($hasil = mysql_fetch_array($sql)){
										?>
                                        <tr>
											<td><?php echo $i; ?></td>
                                            <td><?php echo $hasil["no_pelanggan"]; ?></td>
                                            <td><?php echo $hasil["atas_nama"]; ?></td>
                                            <td><?php echo $hasil["tgl_pesan"]; ?></td>
											<td><?php echo $hasil["waktu_pesan"]; ?></td>
											<?php
											if($_SESSION["jabatan"] == "Pelayan"){
											?>
											<td><?php echo $hasil["no_meja"]; ?></td>
											<?php
											}else if($_SESSION["jabatan"] == "Koki"){
											?>
											
											<?php
											}
											?>
											<td>
											<?php
											if($hasil["status_pembuatan"] == "Belum Jadi"){
												echo "<font color='red'>Belum Jadi</font>";
											}else if($hasil["status_pembuatan"] == "Jadi"){
												echo "<font color='lime'>Jadi</font>";
											}
											?></td>
											<td><a href="data_pemesanan.php?edit=<?php echo $hasil["no_pelanggan"]; ?>"><button class="btn btn-primary"><i class="fa fa-edit "></i> Ubah Pemesanan</button></a>
											<?php echo "<a href='#' onClick=\"return konfirmasiHapusPemesanan('".$hasil["no_pelanggan"]."','".$hasil["atas_nama"]."');\" value='Hapus'><button class=\"btn btn-danger\">";?><i class="fa fa-trash"></i> Hapus Pemesanan</button></a>
											<button class="btn btn-info">Lihat Detail</button>
											<!-- Makanan pesanan, jumlah pesanan saat klik detail --></td>
                                        </tr>
										<?php
										$i++;
										}
										if(isset($_GET['hapus']) != ""){
											return hapus_pemesanan($_GET['hapus']);
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
			}else if(isset($_POST['cari_kasir'])){	
			?>
			<div class="row">
                <div class="col-md-12">
                    
					<form action="" method="POST" style="margin-bottom:10px;">
											<div style="float:right;width:220px;margin:0px 5px 5px 0px"><input type="text" name="datacari" class="form-control"  />
						</div>
						<?php
						if($_SESSION["jabatan"] == "Pelayan"){
						?>
						<button type="submit" name="cari" style="float:right;margin:0px 5px 5px 0px" class="btn btn-default"><i class=" fa fa-refresh "></i> Cari data pemesanan</button>
						<?php
						}if($_SESSION["jabatan"] == "Koki"){
						?>
						<button type="submit" name="cari" style="float:right;margin:0px 5px 5px 0px" class="btn btn-default"><i class=" fa fa-refresh "></i> Cari data pemesanan</button>
						<?php
						}if($_SESSION["jabatan"] == "Kasir"){
						?>
						<button type="submit" name="cari_kasir" style="float:right;margin:0px 5px 5px 0px" class="btn btn-default"><i class=" fa fa-refresh "></i> Cari data pemesanan</button>
						<?php
						}
						?>
					</form>
						<?php
						if($_SESSION["jabatan"] == "Pelayan"){
						?>
						<a href="data_pemesanan.php?aksi=tambahpemesanan"><button style="float:left;margin:0px 5px 5px 0px" class="btn btn-default"><i class=" fa fa-refresh "></i> Tambah Pemesanan </button></a>
						<?php
						}else if($_SESSION["jabatan"] == "Koki"){
							// NULL
						?>
						<?php
						}else if($_SESSION["jabatan"] == "Kasir"){
							// NULL
						}
						?>
						
					
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
                                            <th>No Pelanggan</th>
                                            <th>Nama Pelanggan</th>
                                            <th>Tanggal Pesan</th>
											<th>Waktu Pesan</th>
											<?php
											if($_SESSION["jabatan"] == "Pelayan"){
											?>
											<th>No Meja</th>
											<?php
											}else if($_SESSION["jabatan"] == "Koki"){
											?>
											
											<?php
											}
											?>
											<?php
											if($_SESSION["jabatan"] == "Pelayan"){
											?>
											<th>Status Pembuatan</th>
											<?php
											}else if($_SESSION["jabatan"] == "Koki"){
											?>
											<th>Status Pembuatan</th>
											<?php
											}else if($_SESSION["jabatan"] == "Kasir"){
											?>
											<!-- NULL -->
											<?php
											}
											?>
											<th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php
										$i = 1;
										$pencarian = $_POST["datacari"];
										$sql = mysql_query("SELECT * FROM pemesanan INNER JOIN pelanggan ON pemesanan.no_pelanggan = pelanggan.no_pelanggan WHERE pelanggan.atas_nama REGEXP '$pencarian.*' OR pemesanan.tgl_pesan REGEXP '$pencarian.*' OR pemesanan.waktu_pesan REGEXP '$pencarian.*'");
										while($hasil = mysql_fetch_array($sql)){
										?>
                                        <tr>
											<td><?php echo $i; ?></td>
                                            <td><?php echo $hasil["no_pelanggan"]; ?></td>
                                            <td><?php echo $hasil["atas_nama"]; ?></td>
                                            <td><?php echo $hasil["tgl_pesan"]; ?></td>
											<td><?php echo $hasil["waktu_pesan"]; ?></td>
											<?php
											if($_SESSION["jabatan"] == "Pelayan"){
											?>
											<td><?php echo $hasil["no_meja"]; ?></td>
											<?php
											}else if($_SESSION["jabatan"] == "Koki"){
											?>
											
											<?php
											}
											?>
											<?php
											if($_SESSION["jabatan"] == "Pelayan"){
												echo "<td>";
												if($hasil["status_pembuatan"] == "Belum Jadi"){
													echo "<font color='red'>Belum Jadi</font>";
												}else if($hasil["status_pembuatan"] == "Sudah Jadi"){
													echo "<font color='lime'>Sudah Jadi</font>";
												}
												echo "</td>";
											}if($_SESSION["jabatan"] == "Koki"){
												echo "<td>";
												if($hasil["status_pembuatan"] == "Belum Jadi"){
													echo "<font color='red'>Belum Jadi</font>";
												}else if($hasil["status_pembuatan"] == "Sudah Jadi"){
													echo "<font color='lime'>Sudah Jadi</font>";
												}
												echo "</td>";
											}if($_SESSION["jabatan"] == "Kasir"){
												//NULL
											}
											?></td>
											<td>
											<?php
											if($_SESSION["jabatan"] == "Pelayan"){
											?>
											<a href="data_pemesanan.php?edit=<?php echo $hasil["no_pelanggan"]; ?>"><button class="btn btn-primary"><i class="fa fa-edit "></i> Ubah Pemesanan</button></a>
											<?php echo "<a href='#' onClick=\"return konfirmasiHapusPemesanan('".$hasil["no_pelanggan"]."','".$hasil["atas_nama"]."');\" value='Hapus'><button class=\"btn btn-danger\">";?><i class="fa fa-trash"></i> Hapus Pemesanan</button></a>
											<a href="data_pemesanan.php?detail=<?php echo $hasil["no_pelanggan"]; ?>"><button class="btn btn-info">Lihat Detail</button></a>
											<?php
											}else if($_SESSION["jabatan"] == "Koki"){
											?>
											<a href="data_pemesanan.php?edit=<?php echo $hasil["no_pelanggan"]; ?>"><button class="btn btn-primary"><i class="fa fa-edit "></i> Ubah Pemesanan</button></a>
											<?php echo "<a href='#' onClick=\"return konfirmasiHapusPemesanan('".$hasil["no_pelanggan"]."','".$hasil["atas_nama"]."');\" value='Hapus'><button class=\"btn btn-danger\">";?><i class="fa fa-trash"></i> Hapus Pemesanan</button></a>
											<a href="data_pemesanan.php?detail=<?php echo $hasil["no_pelanggan"]; ?>"><button class="btn btn-info">Lihat Detail</button></a>
											<?php
											}else if($_SESSION["jabatan"] == "Kasir"){
											?>
											<a href="data_pemesanan.php?bayar=<?php echo $hasil["no_pelanggan"]; ?>"><button class="btn btn-info">Bayar Makanan</button></a>
											<?php
											}
											?>
											</td>
                                        </tr>
										<?php
										$i++;
										}
										if(isset($_GET['hapus']) != ""){
											return hapus_pemesanan($_GET['hapus']);
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
			}else{
			?>
			<div class="row">
                <div class="col-md-12">
                    
					<form action="" method="POST" style="margin-bottom:10px;">
											<div style="float:right;width:220px;margin:0px 5px 5px 0px"><input type="text" name="datacari" class="form-control"  />
						</div>
						<?php
						if($_SESSION["jabatan"] == "Pelayan"){
						?>
						<button type="submit" name="cari" style="float:right;margin:0px 5px 5px 0px" class="btn btn-default"><i class=" fa fa-refresh "></i> Cari data pemesanan</button>
						<?php
						}if($_SESSION["jabatan"] == "Koki"){
						?>
						<button type="submit" name="cari" style="float:right;margin:0px 5px 5px 0px" class="btn btn-default"><i class=" fa fa-refresh "></i> Cari data pemesanan</button>
						<?php
						}if($_SESSION["jabatan"] == "Kasir"){
						?>
						<button type="submit" name="cari_kasir" style="float:right;margin:0px 5px 5px 0px" class="btn btn-default"><i class=" fa fa-refresh "></i> Cari data pemesanan</button>
						<?php
						}
						?>
					</form>
						<?php
						if($_SESSION["jabatan"] == "Pelayan"){
						?>
						<a href="data_pemesanan.php?aksi=tambahpemesanan"><button style="float:left;margin:0px 5px 5px 0px" class="btn btn-default"><i class=" fa fa-refresh "></i> Tambah Pemesanan </button></a>
						<?php
						}else if($_SESSION["jabatan"] == "Koki"){
							// NULL
						?>
						<?php
						}else if($_SESSION["jabatan"] == "Kasir"){
							// NULL
						}
						?>
						
					
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
                                            <th>No Pelanggan</th>
                                            <th>Nama Pelanggan</th>
                                            <th>Tanggal Pesan</th>
											<th>Waktu Pesan</th>
											<?php
											if($_SESSION["jabatan"] == "Pelayan"){
											?>
											<th>No Meja</th>
											<?php
											}else if($_SESSION["jabatan"] == "Koki"){
											?>
											
											<?php
											}
											?>
											<?php
											if($_SESSION["jabatan"] == "Pelayan"){
											?>
											<th>Status Pembuatan</th>
											<?php
											}else if($_SESSION["jabatan"] == "Koki"){
											?>
											<th>Status Pembuatan</th>
											<?php
											}else if($_SESSION["jabatan"] == "Kasir"){
											?>
											<!-- NULL -->
											<?php
											}
											?>
											<th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php
										$i = 1;
										$sql = mysql_query("SELECT * FROM pemesanan INNER JOIN pelanggan ON pemesanan.no_pelanggan = pelanggan.no_pelanggan");
										while($hasil = mysql_fetch_array($sql)){
										?>
                                        <tr>
											<td><?php echo $i; ?></td>
                                            <td><?php echo $hasil["no_pelanggan"]; ?></td>
                                            <td><?php echo $hasil["atas_nama"]; ?></td>
                                            <td><?php echo $hasil["tgl_pesan"]; ?></td>
											<td><?php echo $hasil["waktu_pesan"]; ?></td>
											<?php
											if($_SESSION["jabatan"] == "Pelayan"){
											?>
											<td><?php echo $hasil["no_meja"]; ?></td>
											<?php
											}else if($_SESSION["jabatan"] == "Koki"){
											?>
											
											<?php
											}
											?>
											<?php
											if($_SESSION["jabatan"] == "Pelayan"){
												echo "<td>";
												if($hasil["status_pembuatan"] == "Belum Jadi"){
													echo "<font color='red'>Belum Jadi</font>";
												}else if($hasil["status_pembuatan"] == "Sudah Jadi"){
													echo "<font color='lime'>Sudah Jadi</font>";
												}
												echo "</td>";
											}if($_SESSION["jabatan"] == "Koki"){
												echo "<td>";
												if($hasil["status_pembuatan"] == "Belum Jadi"){
													echo "<font color='red'>Belum Jadi</font>";
												}else if($hasil["status_pembuatan"] == "Sudah Jadi"){
													echo "<font color='lime'>Sudah Jadi</font>";
												}
												echo "</td>";
											}if($_SESSION["jabatan"] == "Kasir"){
												//NULL
											}
											?></td>
											<td>
											<?php
											if($_SESSION["jabatan"] == "Pelayan"){
											?>
											<a href="data_pemesanan.php?edit=<?php echo $hasil["no_pelanggan"]; ?>"><button class="btn btn-primary"><i class="fa fa-edit "></i> Ubah Pemesanan</button></a>
											<?php echo "<a href='#' onClick=\"return konfirmasiHapusPemesanan('".$hasil["no_pelanggan"]."','".$hasil["atas_nama"]."');\" value='Hapus'><button class=\"btn btn-danger\">";?><i class="fa fa-trash"></i> Hapus Pemesanan</button></a>
											<a href="data_pemesanan.php?detail=<?php echo $hasil["no_pelanggan"]; ?>"><button class="btn btn-info">Lihat Detail</button></a>
											<?php
											}else if($_SESSION["jabatan"] == "Koki"){
											?>
											<a href="data_pemesanan.php?edit=<?php echo $hasil["no_pelanggan"]; ?>"><button class="btn btn-primary"><i class="fa fa-edit "></i> Ubah Pemesanan</button></a>
											<?php echo "<a href='#' onClick=\"return konfirmasiHapusPemesanan('".$hasil["no_pelanggan"]."','".$hasil["atas_nama"]."');\" value='Hapus'><button class=\"btn btn-danger\">";?><i class="fa fa-trash"></i> Hapus Pemesanan</button></a>
											<a href="data_pemesanan.php?detail=<?php echo $hasil["no_pelanggan"]; ?>"><button class="btn btn-info">Lihat Detail</button></a>
											<?php
											}else if($_SESSION["jabatan"] == "Kasir"){
											?>
											<a href="data_pemesanan.php?bayar=<?php echo $hasil["no_pelanggan"]; ?>"><button class="btn btn-info">Bayar Makanan</button></a>
											<?php
											}
											?>
											</td>
                                        </tr>
										<?php
										$i++;
										}
										if(isset($_GET['hapus']) != ""){
											return hapus_pemesanan($_GET['hapus']);
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