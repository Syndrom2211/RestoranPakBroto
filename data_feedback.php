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
		<h4 class="page-head-line">DATA KRITIK DAN SARAN</h4>
		<?php
			if(isset($_GET['aksi']) == "tambahkritiksaran"){
				if(isset($_POST["submit"])){
						tambah_kritiksaran();
				}
			?>
			<form action="" method="POST">
			<div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                           Tambah Kritik dan Saran
                        </div>
                        <div class="panel-body">
                       <form action="" method="POST">
						  <div class="form-group">
							<label for="exampleInputEmail1">Nama Pelanggan</label>
							<select name="no_pelanggan" class="form-control">
							<?php
							$sql = mysql_query("SELECT * FROM pelanggan INNER JOIN pembayaran ON pelanggan.no_pelanggan = pembayaran.no_pelanggan WHERE pembayaran.status_bayar = 'Sudah Bayar'");
							while($hasil = mysql_fetch_array($sql)){
							?>
								<option value="<?php echo $hasil["no_pelanggan"]; ?>"><?php echo $hasil["atas_nama"]; ?></option>
							<?php
							}
							?>
							</select>
						  </div>
						  <div class="form-group">
							<label for="exampleInputPassword1">Kritik dan Saran</label>
							<textarea name="kritik_saran" class="form-control"></textarea>
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
						<button type="submit" name="cari" style="float:right;margin:0px 5px 5px 0px" class="btn btn-default"><i class=" fa fa-refresh "></i> Cari data kritik dan saran</button>
					</form>
						<a href="data_menu.php?aksi=tambahmenu"><button style="float:left;margin:0px 5px 5px 0px" class="btn btn-default"><i class=" fa fa-refresh "></i> Tambah Kritik dan Saran </button></a>
					
					
					
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
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php
										$i = 1;
										$pencarian = $_POST["datacari"];
										$sql = mysql_query("SELECT * FROM menu WHERE nama REGEXP '$pencarian.*' OR jenis REGEXP '$pencarian.*' OR harga REGEXP '$pencarian.*'");
										while($hasil = mysql_fetch_array($sql)){
										?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $hasil['nama']; ?></td>
                                            <td><?php echo $hasil['jenis']; ?></td>
											<td><?php echo $hasil['harga']; ?></td>
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
			}else{
			?>
			<div class="row">
                <div class="col-md-12">
                    
					<form action="" method="POST" style="margin-bottom:10px;">
											<div style="float:right;width:220px;margin:0px 5px 5px 0px"><input type="text" name="datacari" class="form-control"  />
						</div>
						<button type="submit" name="cari" style="float:right;margin:0px 5px 5px 0px" class="btn btn-default"><i class=" fa fa-refresh "></i> Cari data kritik dan saran</button>
					</form>
						<a href="data_feedback.php?aksi=tambahkritiksaran"><button style="float:left;margin:0px 5px 5px 0px" class="btn btn-default"><i class=" fa fa-refresh "></i> Tambah Kritik dan saran </button></a>
					
					
					
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
                                            <th>Kritik/Saran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php
										$i = 1;
										$sql = mysql_query("SELECT * FROM pelanggan");
										while($hasil = mysql_fetch_array($sql)){
											if($hasil["kritik_saran"] != NULL){
											?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $hasil['no_pelanggan']; ?></td>
                                            <td><?php echo $hasil['atas_nama']; ?></td>
											<td><?php echo $hasil['kritik_saran']; ?></td>
                                        </tr>
										<?php
										}else if($hasil["kritik_saran"] == NULL){
										?>
											
										<?php
										}
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