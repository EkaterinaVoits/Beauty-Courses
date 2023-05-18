<?php 
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
include 'connect\connect_database.php';
?>
<link rel="stylesheet" href="../../css/style.css" type="text/css">
<header>
	<div class="container">
	<div class="wrapper"> 

		<!-- Logo -->
		<div class="logo"> 
			<a href="/index.php">
			YOUR BEAUTY 
			</a>
		</div>
		<!-- Logo -->

		<!-- Navigation -->		
		<div class="nav">
			<?php
				include 'modules/menu/menu.php';
			?>
			<!-- <a href="#" class="menu_item">О нас</a>
			<a href="#" class="menu_item">Наши курсы</a>
			<a href="#" class="menu_item">Наши преподаватели</a>
			<a href="#" class="menu_item">Выбрать курс</a> -->
		</div>
		<!-- /Navigation -->

		<!-- Autorization -->
		<div class="autorize">
			<ul class="menu">
				<li class="menu_item">

					<?php
					if (empty($_SESSION['user']['name'])){
						echo "<a href='modules/authorization/authorization.php'>Войти</a>";
					} else {
						if($_SESSION['userType']=='user') {
							echo "<a href='modules/authorization/profile.php'>Личный кабинет</a>";
						} else {
							echo "<a href='modules/authorization/admin_panel.php'>Панель администрирования</a>";
						}
						
					}
					?>

				</li>
				<li class="menu_item">
					
					<?php
					if (empty($_SESSION['user']['name'])){
						echo "<a href='/modules/registration/registration.php'>Зарегистрироваться</a>";
					} else {						
						echo "<a href='..\modules\authorization\authorization_out.php'>Выйти</a>";
					}

						
					?>	

				</li>
			</ul>
		</div>
		<!-- Autorization -->
	</div>
	</div>
</header>

