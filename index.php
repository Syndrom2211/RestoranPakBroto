<?php
session_start();
if(isset($_SESSION['username']) || isset($_SESSION['jabatan']) == 'Pelayan' ||
 isset($_SESSION['jabatan']) == 'Pantry' || isset($_SESSION['jabatan']) == 'Customer Service' ||
 isset($_SESSION['jabatan']) == 'Kasir' || isset($_SESSION['jabatan']) == 'Koki' ||
 isset($_SESSION['jabatan']) == 'Manajer'){
    header('location:home.php');
}else{
	include "proses.php";
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<?php include "include/header.php"; ?>
<body>
    <!-- HEADER END-->
    <div class="navbar navbar-inverse set-radius-zero">
        <div class="container" style="height:120px;">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">

                    <img src="assets/img/logo.png" />
                </a>

            </div>
            </div>
        </div>
    <!-- LOGO HEADER END-->
   
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line">Login Pegawai </h4>

                </div>

            </div>
            <div class="row">
			<?php echo login(); ?>
				<form action="" method="POST">
					<div class="col-md-6">
						 <label>Username : </label>
							<input type="text" name="username" class="form-control" />
							<label>Password :  </label>
							<input type="password" name="password" class="form-control" />
							<hr />
							<div class="btn-group">
												<select name="jabatan" class="form-control" id="sel1">
												<option value="NULL">-</option>
													<?php
													include "include/koneksi.php";
													$sql	= mysql_query("SELECT * FROM jabatan");
													while($hasil = mysql_fetch_array($sql)){
													?>
														<option value="<?php echo $hasil["id_jabatan"]; ?>"><?php echo $hasil["jabatan"]; ?></option>
													<?php
													}
													?>
												</select>
											</div>
								<input type="submit" name="submit" class="btn btn-info" value="Login" >
					</div>
				</form>
            </div>
        </div>
    </div>
    <?php include "include/footer.php"; ?>
</body>
</html>
<?php
}
?>