<div class="navbar-collapse collapse ">
						<?php
						if(isset($_GET['logout'])){
							logout();
						}
						?>
                        <ul id="menu-top" class="nav navbar-nav navbar-right">
							<?php
							if($_SESSION['jabatan'] == 'Pelayan'){
							?>
							<li><a href="data_pemesanan.php">Data Pemesanan</a></li>
							<li><a href="?logout">Logout</a></li>
							<?php
							}else if($_SESSION['jabatan'] == 'Pantry'){
							?>
							<li><a href="data_bahanbaku.php">Data Bahan Baku</a></li>
							<li><a href="data_laporan_bahanbaku.php">Laporan Bahan Baku</a></li>
							<li><a href="?logout">Logout</a></li>
							<?php
							}else if($_SESSION['jabatan'] == 'Customer Service'){
							?>
							<li><a href="data_feedback.php">Data Feedback</a></li>
							<li><a href="?logout">Logout</a></li>
							<?php
							}else if($_SESSION['jabatan'] == 'Kasir'){
							?>
							<li><a href="data_pemesanan.php">Data Pemesanan</a></li>
							<li><a href="data_pembayaran.php">Data Pembayaran</a></li>
							<li><a href="?logout">Logout</a></li>
							<?php
							}else if($_SESSION['jabatan'] == 'Koki'){
							?>
							<li><a href="data_menu.php">Data Menu</a></li>
							<!-- Pengolahan Menu -->
							<li><a href="data_pemesanan.php">Data Pemesanan</a></li>
							<li><a href="?logout">Logout</a></li>
							<?php
							}else if($_SESSION['jabatan'] == 'Manajer'){
							?>
							<li><a href="data_pegawai.php">Data Pegawai</a></li>
							<li><a href="?logout">Logout</a></li>
							<?php
							}
							?>
                            

                        </ul>
                    </div>