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
				include __DIR__.'\menu.php';
			?>
		</div>
		<!-- /Navigation -->

		<!-- Autorization -->
		<div class="autorize">
			<ul class="menu">
				<li class="menu_item">

					<?php
					if ($_SESSION['user']['name']==''){
						echo "<a href='modules/authorization/authorization.php'>Войти</a>";
					} else {
						echo "<a href='modules/authorization/profile.php'>Личный кабинет</a>";
					}
					?>

				</li>
				<li class="menu_item">
					
					<?php
						if ($_SESSION['user']['name']==''){
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

