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
		<h4 class="page-head-line">DATA MENU</h4>
		<?php
			if(isset($_GET['aksi']) == "tambahmenu"){
				if(isset($_POST["submit"])){
						tambah_menu();
				}
			?>
			<form action="" method="POST">
			<div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                           Tambah Menu
                        </div>
                        <div class="panel-body">
                       <form action="" method="POST">
						  <div class="form-group">
							<label for="exampleInputEmail1">Nama Makanan</label>
							<input type="text" class="form-control" id="exampleInputEmail1" name="nama_makanan" />
						  </div>
						  <div class="form-group">
							<label for="exampleInputPassword1">Jenis Makanan</label>
							<input type="text" class="form-control" id="exampleInputPassword1" name="jenis_makanan" />
						  </div>
						  <?php $random = rand(10,100); ?>
								<input type="hidden" class="form-control" id="exampleInputPassword1" name="no_makanan" value="<?php echo $random; ?>" />
						  <div class="form-group">
							<label for="exampleInputPassword1">Bahan Baku</label>
							<div class="checkbox">
							<?php
							$sql = mysql_query("SELECT * FROM bahan_baku");
							while($hasil = mysql_fetch_array($sql)){
							?>
							<div class="checkbox">
							<label><input class="form-control" type="checkbox" name="nama_bahan_baku[]" value="<?php echo $hasil["no_bahan"]; ?>" /></label><?php echo $hasil["nama"];
							?>
							</div>
							<?php
							}
							?>
							</div>
						  </div>
						  <div class="form-group">
							<label for="exampleInputPassword1">Harga Makanan</label>
							<input type="text" class="form-control" id="exampleInputPassword1" name="harga_makanan" />
						  </div>
						  <button type="submit" name="submit" class="btn btn-default">Tambah</button>
						</form>
                            </div>
                            </div>
                    </div>
				</form>
				
			<?php
			}else if(isset($_GET['edit']) != ""){	
				$no_makanan = $_GET["edit"];
				$sql = mysql_query("SELECT * FROM menu WHERE no_makanan = '$no_makanan'");
				$hasil = mysql_fetch_array($sql);
				
				if(isset($_POST["edit"])){
					edit_menu($no_makanan);
				}
			?>
			<form action="" method="POST">
			<div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                           Edit Menu
                        </div>
                        <div class="panel-body">
                       <form action="" method="POST">
						  <div class="form-group">
							<label for="exampleInputEmail1">Nama Makanan</label>
							<input type="text" class="form-control" id="exampleInputEmail1" name="nama_makanan" value="<?php echo $hasil["nama"]; ?>" />
						  </div>
						  <div class="form-group">
							<label for="exampleInputPassword1">Jenis Makanan</label>
							<input type="text" class="form-control" id="exampleInputPassword1" name="jenis_makanan" value="<?php echo $hasil["jenis"]; ?>" />
						  </div>
						  <div class="form-group">
							<label for="exampleInputPassword1">Harga Makanan</label>
							<input type="text" class="form-control" id="exampleInputPassword1" name="harga_makanan" value="<?php echo $hasil["harga"]; ?>" />
						  </div>
						  <button type="submit" name="edit" class="btn btn-default">Edit</button>
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
						<button type="submit" name="cari" style="float:right;margin:0px 5px 5px 0px" class="btn btn-default"><i class=" fa fa-refresh "></i> Cari data menu</button>
					</form>
						<a href="data_menu.php?aksi=tambahmenu"><button style="float:left;margin:0px 5px 5px 0px" class="btn btn-default"><i class=" fa fa-refresh "></i> Tambah Menu </button></a>
					
					
					
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
                                            <th>No Makanan</th>
                                            <th>Nama Makanan</th>
                                            <th>Jenis Makanan</th>
                                            <th>Harga Makanan</th>
											<th>Status Makanan</th>
											<th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php
										$i = 1;
										$pencarian = $_POST["datacari"];
										$sql = mysql_query("SELECT menu.no_makanan, menu.nama AS nama_makanan, menu.jenis, menu.harga, bahan_baku.status_bahan_baku FROM detail_menu INNER JOIN menu ON detail_menu.no_makanan = menu.no_makanan INNER JOIN bahan_baku ON detail_menu.no_bahan = bahan_baku.no_bahan WHERE menu.nama REGEXP '$pencarian.*' OR menu.jenis REGEXP '$pencarian.*' OR menu.harga REGEXP '$pencarian.*' GROUP BY menu.nama");
										while($hasil = mysql_fetch_array($sql)){
										?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $hasil['nama_makanan']; ?></td>
                                            <td><?php echo $hasil['jenis']; ?></td>
											<td><?php echo $hasil['harga']; ?></td>
											<td><?php
											if($hasil["status_bahan_baku"] == "Tidak Tersedia"){
												echo "<font color='red'>Tidak Tersedia</font>";
											}else if($hasil["status_bahan_baku"] == "Tersedia"){
												echo "<font color='lime'>Tersedia</font>";
											}
											?></td>
											<td><a href="data_menu.php?edit=<?php echo $hasil["no_makanan"]; ?>"><button class="btn btn-primary"><i class="fa fa-edit "></i> Ubah Menu</button></a>
											<?php echo "<a href='#' onClick=\"return konfirmasiHapusMakanan('".$hasil["no_makanan"]."','".$hasil["nama_makanan"]."');\" value='Hapus'><button class=\"btn btn-danger\">";?><i class="fa fa-trash"></i> Hapus Menu</button></a></td>
                                        </tr>
										<?php
										$i++;
										}
										if(isset($_GET['hapus']) != ""){
													return hapus_menu($_GET['hapus']);
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
						<button type="submit" name="cari" style="float:right;margin:0px 5px 5px 0px" class="btn btn-default"><i class=" fa fa-refresh "></i> Cari data menu</button>
					</form>
						<a href="data_menu.php?aksi=tambahmenu"><button style="float:left;margin:0px 5px 5px 0px" class="btn btn-default"><i class=" fa fa-refresh "></i> Tambah Menu </button></a>
					
					
					
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
                                            <th>No Makanan</th>
                                            <th>Nama Makanan</th>
                                            <th>Jenis Makanan</th>
                                            <th>Harga Makanan</th>
											<th>Status Makanan</th>
											<th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php
										$i = 1;
										$sql = mysql_query("SELECT menu.no_makanan, menu.nama AS nama_makanan, menu.jenis, menu.harga, bahan_baku.status_bahan_baku FROM detail_menu INNER JOIN menu ON detail_menu.no_makanan = menu.no_makanan INNER JOIN bahan_baku ON detail_menu.no_bahan = bahan_baku.no_bahan GROUP BY menu.nama");
										while($hasil = mysql_fetch_array($sql)){
										?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $hasil['nama_makanan']; ?></td>
                                            <td><?php echo $hasil['jenis']; ?></td>
											<td><?php echo $hasil['harga']; ?></td>
											<td><?php
											if($hasil["status_bahan_baku"] == "Tidak Tersedia"){
												echo "<font color='red'>Tidak Tersedia</font>";
											}else if($hasil["status_bahan_baku"] == "Tersedia"){
												echo "<font color='lime'>Tersedia</font>";
											}
											?></td>
											<td></td>
											<td><a href="data_menu.php?edit=<?php echo $hasil["no_makanan"]; ?>"><button class="btn btn-primary"><i class="fa fa-edit "></i> Ubah Menu</button></a>
											<?php echo "<a href='#' onClick=\"return konfirmasiHapusMakanan('".$hasil["no_makanan"]."','".$hasil["nama_makanan"]."');\" value='Hapus'><button class=\"btn btn-danger\">";?><i class="fa fa-trash"></i> Hapus Menu</button></a></td>
                                        </tr>
										<?php
										$i++;
										}
										if(isset($_GET['hapus']) != ""){
											return hapus_menu($_GET['hapus']);
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