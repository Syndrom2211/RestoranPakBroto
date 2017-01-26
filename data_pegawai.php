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
		<h4 class="page-head-line">DATA PEGAWAI</h4>
		<?php
			if(isset($_GET['aksi']) == "tambahpegawai"){
				if(isset($_POST["submit"])){
						tambah_pegawai();
				}
			?>
			<form action="" method="POST">
			<div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                           Tambah Pegawai
                        </div>
                        <div class="panel-body">
                       <form action="" method="POST">
						  <div class="form-group">
							<label for="exampleInputEmail1">Nama Pegawai</label>
							<input type="text" class="form-control" id="exampleInputEmail1" name="nama_pegawai" />
						  </div>
						  <div class="form-group">
							<label for="exampleInputEmail1">Jabatan Pegawai</label>
							<select name="jabatan" class="form-control">
								<?php
								$sql = mysql_query("SELECT * FROM jabatan");
								while($hasildua = mysql_fetch_array($sql)){
								?>
									<option value="<?php echo $hasildua["id_jabatan"]; ?>"><?php echo $hasildua["jabatan"]; ?></option>
								<?php
								}
								?>
							</select>
						  </div>
						  <div class="form-group">
							<label for="exampleInputPassword1">Username</label>
							<input type="text" class="form-control" id="exampleInputPassword1" name="username" />
						  </div>
						  <div class="form-group">
							<label for="exampleInputPassword1">Password</label>
							<input type="password" class="form-control" id="exampleInputPassword1" name="password" />
						  </div>
						  <div class="form-group">
							<label for="exampleInputPassword1">Jenis Kelamin</label>
							<select name="jenis_kelamin" class="form-control">
								<option value="L">Laki-Laki</option>
								<option value="P">Perempuan</option>
							</select>
						  </div>
						  <div class="form-group">
							<label for="exampleInputPassword1">Alamat</label>
							<textarea name="alamat" class="form-control" rows="3"></textarea>
						  </div>
						  <div class="form-group">
							<label for="exampleInputPassword1">No Handphone</label>
							<input type="text" class="form-control" id="exampleInputPassword1" name="no_handphone" />
						  </div>
						  <div class="form-group">
							<label for="exampleInputPassword1">Waktu Kerja</label>
							<input id="input-a" style="width:120px" type="text" class="form-control" id="exampleInputPassword1" name="waktu_kerja_start" />
							s.d
							<input id="input-b" style="width:120px"type="text" class="form-control" id="exampleInputPassword1" name="waktu_kerja_end" />
						  </div>
						  <div class="form-group">
							<label for="exampleInputPassword1">Bagian Kerja</label>
							<input id="input-a" type="text" class="form-control" id="exampleInputPassword1" name="bagian_kerja" />
						  </div>
						  <button type="submit" name="submit" class="btn btn-default">Tambah</button>
						</form>
                            </div>
                            </div>
                    </div>
				</form>
				
			<?php
			}else if(isset($_GET['edit']) != ""){	
				$no_pegawai = $_GET["edit"];
				$sql = mysql_query("SELECT * FROM pegawai INNER JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan WHERE no_pegawai = '$no_pegawai'");
				$hasil = mysql_fetch_array($sql);
				
				if(isset($_POST["edit"])){
					edit_pegawai($no_pegawai);
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
							<label for="exampleInputEmail1">Nama Pegawai</label>
							<input type="text" class="form-control" id="exampleInputEmail1" name="nama_pegawai" value="<?php echo $hasil["nama"]; ?>" />
						  </div>
						  <div class="form-group">
							<label for="exampleInputEmail1">Jabatan Pegawai</label>
							<select name="jabatan" class="form-control">
								<option value="<?php echo $hasil["id_jabatan"]; ?>">[Status] <?php echo $hasil["jabatan"]; ?></option>
								<?php
								$sql = mysql_query("SELECT * FROM jabatan");
								while($hasildua = mysql_fetch_array($sql)){
								?>
									<option value="<?php echo $hasildua["id_jabatan"]; ?>"><?php echo $hasildua["jabatan"]; ?></option>
								<?php
								}
								?>
							</select>
						  </div>
						  <div class="form-group">
							<label for="exampleInputPassword1">Username</label>
							<input type="text" class="form-control" id="exampleInputPassword1" name="username" value="<?php echo $hasil["username"]; ?>" readonly />
						  </div>
						  <div class="form-group">
							<label for="exampleInputPassword1">Password</label>
							<input type="hidden" class="form-control" id="exampleInputPassword1" name="password_lama" value="<?php echo $hasil["password"]; ?>"/>
							<input type="password" class="form-control" id="exampleInputPassword1" name="password_baru" placeholder="Kosongkan jika tidak diganti.." />
						  </div>
						  <div class="form-group">
							<label for="exampleInputPassword1">Jenis Kelamin</label>
							<select name="jenis_kelamin" class="form-control">
								<option value="<?php echo $hasil["jenis_kelamin"]; ?>">[Status] <?php if($hasil["jenis_kelamin"] == "L"){ echo "Laki-Laki"; }else if($hasil["jenis_kelamin"] == "P"){ echo "Perempuan"; }?></option>
								<option value="L">Laki-Laki</option>
								<option value="P">Perempuan</option>
							</select>
						  </div>
						  <div class="form-group">
							<label for="exampleInputPassword1">Alamat</label>
							<textarea name="alamat" class="form-control" rows="3"><?php echo $hasil["alamat"]; ?></textarea>
						  </div>
						  <div class="form-group">
							<label for="exampleInputPassword1">No Handphone</label>
							<input type="text" class="form-control" id="exampleInputPassword1" name="no_handphone" value="<?php echo $hasil["no_handphone"]; ?>" />
						  </div>
						  <div class="form-group">
							<label for="exampleInputPassword1">Waktu Kerja</label>
							<input width="120px" type="hidden" class="form-control" id="exampleInputPassword1" name="waktu_kerja_lama" value="<?php echo $hasil["waktu_kerja"]; ?>" />
							<input id="input-a" width="120px" type="text" class="form-control" id="exampleInputPassword1" name="waktu_kerja_start_baru" placeholder="Kosongkan jika tidak diganti.."/> s.d
							<input id="input-b" width="120px" type="text" class="form-control" id="exampleInputPassword1" name="waktu_kerja_end_baru" placeholder="Kosongkan jika tidak diganti.." />
						  </div>
						  <div class="form-group">
							<label for="exampleInputPassword1">Bagian Kerja</label>
							<input type="text" class="form-control" id="exampleInputPassword1" name="bagian_kerja" value="<?php echo $hasil["bagian_kerja"]; ?>" />
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
						<button type="submit" name="cari" style="float:right;margin:0px 5px 5px 0px" class="btn btn-default"><i class=" fa fa-refresh "></i> Cari data pegawai</button>
					</form>
						<a href="data_pegawai.php?aksi=tambahpegawai"><button style="float:left;margin:0px 5px 5px 0px" class="btn btn-default"><i class=" fa fa-refresh "></i> Tambah Pegawai </button></a>
					
					
					
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
                                            <th>No Pegawai</th>
                                            <th>Nama Pegawai</th>
                                            <th>Jabatan</th>
                                            <th>Waktu Kerja</th>
											<th>Bagian Kerja</th>
											<th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php
										$i = 1;
										$pencarian = $_POST["datacari"];
										$sql = mysql_query("SELECT * FROM pegawai INNER JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan WHERE nama REGEXP '$pencarian.*' OR jabatan REGEXP '$pencarian.*' OR waktu_kerja REGEXP '$pencarian.*' OR bagian_kerja REGEXP '$pencarian.*'");
										while($hasil = mysql_fetch_array($sql)){
										?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
											<td><?php echo $hasil['no_pegawai']; ?></td>
                                            <td><?php echo $hasil['nama']; ?></td>
                                            <td><?php echo $hasil['jabatan']; ?></td>
											<td><?php echo $hasil['waktu_kerja']; ?></td>
											<td><?php echo $hasil['bagian_kerja']; ?></td>
											<td><a href="data_pegawai.php?edit=<?php echo $hasil["no_pegawai"]; ?>"><button class="btn btn-primary"><i class="fa fa-edit "></i> Ubah Pegawai</button></a>
											<?php echo "<a href='#' onClick=\"return konfirmasiHapusPegawai('".$hasil["no_pegawai"]."','".$hasil["nama"]."');\" value='Hapus'><button class=\"btn btn-danger\">";?><i class="fa fa-trash"></i> Hapus Pegawai</button></a></td>
                                        </tr>
										<?php
										$i++;
										}
										if(isset($_GET['hapus']) != ""){
											return hapus_pegawai($_GET['hapus']);
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
						<button type="submit" name="cari" style="float:right;margin:0px 5px 5px 0px" class="btn btn-default"><i class=" fa fa-refresh "></i> Cari data pegawai</button>
					</form>
						<a href="data_pegawai.php?aksi=tambahpegawai"><button style="float:left;margin:0px 5px 5px 0px" class="btn btn-default"><i class=" fa fa-refresh "></i> Tambah Pegawai </button></a>
					
					
					
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
                                            <th>No Pegawai</th>
                                            <th>Nama Pegawai</th>
                                            <th>Jabatan</th>
                                            <th>Waktu Kerja</th>
											<th>Bagian Kerja</th>
											<th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php
										$i = 1;
										$sql = mysql_query("SELECT * FROM pegawai INNER JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan");
										while($hasil = mysql_fetch_array($sql)){
										?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
											<td><?php echo $hasil['no_pegawai']; ?></td>
                                            <td><?php echo $hasil['nama']; ?></td>
                                            <td><?php echo $hasil['jabatan']; ?></td>
											<td><?php echo $hasil['waktu_kerja']; ?></td>
											<td><?php echo $hasil['bagian_kerja']; ?></td>
											<td><a href="data_pegawai.php?edit=<?php echo $hasil["no_pegawai"]; ?>"><button class="btn btn-primary"><i class="fa fa-edit "></i> Ubah Pegawai</button></a>
											<?php echo "<a href='#' onClick=\"return konfirmasiHapusPegawai('".$hasil["no_pegawai"]."','".$hasil["nama"]."');\" value='Hapus'><button class=\"btn btn-danger\">";?><i class="fa fa-trash"></i> Hapus Pegawai</button></a></td>
                                        </tr>
										<?php
										$i++;
										}										
										if(isset($_GET['hapus']) != ""){
											return hapus_pegawai($_GET['hapus']);
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