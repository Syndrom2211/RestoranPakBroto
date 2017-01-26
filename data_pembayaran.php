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
		<h4 class="page-head-line">DATA PEMBAYARAN</h4>
		<?php
			if(isset($_POST['cari'])){	
			?>
			<div class="row">
                <div class="col-md-12">
                    
					<form action="" method="POST" style="margin-bottom:10px;">
											<div style="float:right;width:220px;margin:0px 5px 5px 0px"><input type="text" name="datacari" class="form-control"  />
						</div>
						<button type="submit" name="cari" style="float:right;margin:0px 5px 5px 0px" class="btn btn-default"><i class=" fa fa-refresh "></i> Cari Pembayaran</button>
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
                                            <th>Nama Pelanggan</th>
                                            <th>Makanan Pesanan</th>
                                            <th>Tanggal Bayar</th>
											<th>Waktu Bayar</th>
											<th>Total Bayar</th>
											<th>Status Bayar</th>
											<th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php
										$i = 1;
										$pencarian = $_POST["datacari"];
										$sql = mysql_query("SELECT * FROM pembayaran WHERE nama_pelanggan REGEXP '$pencarian.*' OR makanan_pesanan REGEXP '$pencarian.*' OR tgl_bayar REGEXP '$pencarian.*' OR waktu_bayar REGEXP '$pencarian.*' OR total_bayar REGEXP '$pencarian.*' OR status_bayar REGEXP '$pencarian.*'");
										while($hasil = mysql_fetch_array($sql)){
										?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $hasil['nama_pelanggan']; ?></td>
                                            <td><?php echo $hasil['makanan_pesanan']; ?></td>
											<td><?php echo $hasil['tgl_bayar']; ?></td>
											<td><?php echo $hasil['waktu_bayar']; ?></td>
											<td><?php echo $hasil['total_bayar']; ?></td>
											<td>
											<?php 
											if($hasil['status_bayar'] == "Sudah Bayar"){
												echo "<font color='lime'>Sudah Bayar</font>";
											}else if($hasil['status_bayar'] == "Belum Bayar"){
												echo "<font color='red'>Belum Bayar</font>";
											}
											?>											
											</td>
											<td><a href="data_pemesanan.php?edit=<?php echo $hasil["no_pelanggan"]; ?>"><button class="btn btn-primary"><i class="fa fa-edit "></i> Ubah Pembayaran</button></a>
											<?php echo "<a href='#' onClick=\"return konfirmasiHapusPembayaran('".$hasil["id_transaksi"]."','".$hasil["nama_pelanggan"]."');\" value='Hapus'><button class=\"btn btn-danger\">";?><i class="fa fa-trash"></i> Hapus Pembayaran</button></a></td>
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
			}else if(isset($_GET['edit']) != ""){	
				$id_transaksi = $_GET["edit"];
				$sql = mysql_query("SELECT * FROM pembayaran INNER JOIN pelanggan ON pembayaran.no_pelanggan = pelanggan.no_pelanggan WHERE id_transaksi = '$id_transaksi'");
				$hasil = mysql_fetch_array($sql);
				
				if(isset($_POST["edit_pembayaran"])){
					edit_pembayaran($id_transaksi);
				}
			?>
			<form action="" method="POST">
			<div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                           Ubah Pembayaran
                        </div>
                        <div class="panel-body">
                       <form action="" method="POST">
						  <div class="form-group">
							<label for="exampleInputEmail1">Nama Pelanggan</label>
							<input type="text" class="form-control" id="exampleInputEmail1" name="nama_pelanggan" value="<?php echo $hasil["atas_nama"]; ?>" readonly />
							<input type="hidden" class="form-control" id="exampleInputEmail1" name="id_transaksi" value="<?php echo $id_transaksi; ?>" />
						  </div>
						  <div class="form-group">
							<label for="exampleInputEmail1">List Makanan Pesanan : </label>
							
							<?php
							echo "<textarea class='form-control' name='makanan_pesanan'>";
							echo $hasil["makanan_pesanan"].", "; 
							echo "</textarea>";
							?>
							
						  </div>
						  <div class="form-group">
							<label for="exampleInputPassword1">Total Bayar</label>
							<input type="text" class="form-control" id="exampleInputPassword1" name="total_bayar" value="<?php echo $hasil["total_bayar"]; ?>" />
						  </div>
						  <div class="form-group">
							<label for="exampleInputPassword1">Status Bayar</label>
							<select name="status_bayar" class="form-control">
								<option value="Sudah Bayar">Sudah Bayar</option>
								<option value="Belum Bayar">Belum Bayar</option>
							</select>
						  </div>
						  <button type="submit" name="edit_pembayaran" class="btn btn-default">Ubah</button>
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
			}else{
			?>
			<div class="row">
                <div class="col-md-12">
                    
					<form action="" method="POST" style="margin-bottom:10px;">
											<div style="float:right;width:220px;margin:0px 5px 5px 0px"><input type="text" name="datacari" class="form-control"  />
						</div>
						<button type="submit" name="cari" style="float:right;margin:0px 5px 5px 0px" class="btn btn-default"><i class=" fa fa-refresh "></i> Cari Pembayaran</button>
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
                                            <th>Nama Pelanggan</th>
                                            <th>Makanan Pesanan</th>
                                            <th>Tanggal Bayar</th>
											<th>Waktu Bayar</th>
											<th>Total Bayar</th>
											<th>Status Bayar</th>
											<th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php
										$i = 1;
										$sql = mysql_query("SELECT * FROM pembayaran INNER JOIN pelanggan ON pembayaran.no_pelanggan = pelanggan.no_pelanggan");
										while($hasil = mysql_fetch_array($sql)){
										?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $hasil['atas_nama']; ?></td>
                                            <td><?php echo $hasil['makanan_pesanan']; ?></td>
											<td><?php echo $hasil['tgl_bayar']; ?></td>
											<td><?php echo $hasil['waktu_bayar']; ?></td>
											<td><?php echo $hasil['total_bayar']; ?></td>
											<td>
											<?php 
											if($hasil['status_bayar'] == "Sudah Bayar"){
												echo "<font color='lime'>Sudah Bayar</font>";
											}else if($hasil['status_bayar'] == "Belum Bayar"){
												echo "<font color='red'>Belum Bayar</font>";
											}
											?>											
											</td>
											<td><a href="data_pembayaran.php?edit=<?php echo $hasil["id_transaksi"]; ?>"><button class="btn btn-primary"><i class="fa fa-edit "></i> Ubah Pembayaran</button></a>
											<?php echo "<a href='#' onClick=\"return konfirmasiHapusPembayaran('".$hasil["id_transaksi"]."','".$hasil["atas_nama"]."');\" value='Hapus'><button class=\"btn btn-danger\">";?><i class="fa fa-trash"></i> Hapus Pembayaran</button></a></td>
                                        </tr>
										<?php
										$i++;
										}
										if(isset($_GET['hapus']) != ""){
											return hapus_pembayaran($_GET['hapus']);
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