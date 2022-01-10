<?php
	session_start();
	if (isset($_POST['hostname']))
	{
		$flag=true;

		$hostname=$_POST['hostname'];
		if ((strlen($hostname)<5) || (strlen($hostname)>10))
		{
			$flag=false;
			$_SESSION['error_hostname']="Nazwa maszyny składa się zawsze z 5-10 znaków. Sprawdź poprawność nazwy maszyny.";
		}
		$hostname=$_POST['user'];
                if ((strlen($hostname)<5) || (strlen($hostname)>10))
                {
                        $flag=false;
                        $_SESSION['error_user']="Nazwa użytkownika składa się zawsze z 5-10 znaków. Sprawdź poprawność nazwy użytkownika.";
		}




		$_SESSION['flag']=$flag;

	}
?>


<!DOCTYPE html>
<html lang="pl">
<head>

	<meta charset="utf-8">
	<title>Platforma do automatyzacji</title>
	<meta name="description" content="Platforma do automatyzacji urządzeń z systemem Linux">
	<meta name="author" content="Bartłomiej Olczyk">
	<link rel="stylesheet" href="css/main.css">


</head>

<body>

	<header>
		<img src="img/logo.png">
		<h1>Wybierz swoją konfigurację:</h1>

	</header>
	
	<main>
	
		<article>
			<div id="container">	
				<form method="post">
					<div class="row">
						<fieldset>
							<legend> Rodzaj konfiguracji: </legend>
							<div><label><input type="radio" value="standard" name="conf_type" checked> Standard </label></div>
							<div><label><input type="radio" value="rnd" name="conf_type"> RnD </label></div>
							<div><label><input type="radio" value="java_developer" name="conf_type"> Java Developer </label></div>						
							<div><label><input type="radio" value="azure_developer" name="conf_type"> Azure Developer </label></div>
						</fieldset>
					
					</div>				
					<div class="row">
						<fieldset>
							<legend> Dodatkowe oprogramowanie </legend>
							<div class="row">
								<div><label><input type="checkbox" name="docker" value="1"> Docker </label></div>
								<div><label><input type="checkbox" name="teams" value="1"> Microsoft Teams </label></div>
							</div>
						</fieldset>
					
					</div>
					
					<div class="row">
						<div><label> Nazwa użytkownika <input type="text" name="user" placeholder="Jak user ma być utworzony?"></label></div>
						<div class="error">
                                                <?php
                                                if (isset($_SESSION['error_user']))
                                                {
                                                        echo $_SESSION['error_user'];
                                                        unset($_SESSION['error_user']);
                                                }
                                                ?>
                                                </div>
						<div><label> Nazwa maszyny <input type="text" name="hostname"></label></div>
						<div class="error">
						<?php
						if (isset($_SESSION['error_hostname']))
						{	
							echo $_SESSION['error_hostname'];
							unset($_SESSION['error_hostname']);
						}
						?>
						</div>
					</div>
				
					<div class="row">
						<input type="submit" value="Start">
					</div>
				</form>		
			</div>	
		</article>
		<?php
                	if (isset($_SESSION['flag']))
			{
				if ($_SESSION['flag'] == true )
				{	
					echo "printing <br />";	
					$hostname=$_POST['hostname'];
					$user=$_POST['user'];
					$conf= $_POST['conf_type'];
					if ($_POST['docker'] == true)
					{
					$output = shell_exec("/var/www/html/scripts/packages.sh $hostname 'docker_var' 2>&1");
                                        echo "<pre>$output</pre>";
					}
					if ($_POST['teams'] == true)
					{
					$output = shell_exec("/var/www/html/scripts/packages.sh $hostname 'teams_var' 2>&1");
                                        echo "<pre>$output</pre>";
					}
					//Dodawanie do inventory
					$output = shell_exec("/var/www/html/scripts/test.sh $user $hostname $conf 2>&1");
					echo "<pre>$output</pre>";
				}
                                unset($_SESSION['flag']);
                        }
                ?>


		
	</main>

</body>
</html>
