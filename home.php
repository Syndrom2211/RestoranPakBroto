<?php
session_start();
if(isset($_SESSION['username'])){
	include "proses.php";
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
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line">Dashboard</h4>

                </div>

            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-success">
                        Selamat datang <?php echo $_SESSION['nama']; ?>
                    </div>
                </div>

            </div>
            
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