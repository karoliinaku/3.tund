<?php

	//võtab ja kopeerib faili sisu
	require("../../config.php");

	
	//MUUTUJAD
	$signupUsernameError = "";
	$signupEmailError = "";
	$signupPasswordError = "";
	$signupEmail = "";
	
	if (isset ($_POST["signupUsername"]) ) {
	
		if (empty ($_POST["signupUsername"]) ) { 
			$signupUsernameError = "See väli on kohustuslik!";
		
		}
	}
	
	if (isset ($_POST["signupPassword"]) ) {
	
		if (empty ($_POST["signupPassword"]) ) { 
			$signupPasswordError = "See väli on kohustuslik!";
		
		} else {
			
			if (strlen ($_POST["signupPassword"]) <= 5 ){
				$signupPasswordError = "Parool peab olema 5 tähemärki pikk!";
			}
		} 
		
	}

	$gender = "";
	if (isset ($_POST["gender"]) ) {
	
		if (empty ($_POST["gender"]) ) { 
			$genderError = "See väli on kohustuslik!";
		} else {
			$gender = $_POST["gender"];
		}
	}
	
	if (isset ($_POST["signupEmail"]) ) {
	
		if (empty ($_POST["signupEmail"]) ) { 
			$signupEmailError = "See väli on kohustuslik!";
		} else {
			$signupEmail = $_POST["signupEmail"];
		}
	}
	
	// Kus tean, et ühtegi viga ei olnud ja saan kasutaja andmed salvestada
	if (isset($_POST["signupPassword"]) &&
		isset($_POST["signupEmail"]) &&
		empty($signupEmailError) && 
		empty($signupPasswordError)  
	) {
			//näitab, millised andmed kasutaja sisestas: email, parool, räsi
		echo "Salvestan...<br>";
		echo "email ".$signupEmail."<br>";
		
		$password = hash("sha512", $_POST["signupPassword"]);
		
		echo "parool ".$_POST["signupPassword"]."<br>";
		echo "räsi ".$password."<br>";
		
		//echo $serverUsername; 
		
		$database = "if16_karoku";
		
		//ühendus
		$mysqli = new mysqli($serverHost, $serverUsername, $serverPassword, $database);
		
		//käsk
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES (?, ?)");
		
		//asendan küsimärgid väärtustega
		//iga muutuja kohta 1 täht, mis tüüpi muutuja on
		// s - string
		// i - integer
		// d - double/float
		$stmt->bind_param("ss", $signupEmail, $password);
		
		if ($stmt->execute()) {
			
			echo "salvestamine õnnestus";
		} else {
			echo "ERROR".$stmt->error;
		}
	}
	
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Sisselogimise lehekülg</title>
	</head>
	<body>

		<h1>Logi sisse</h1>

		<form method="POST">
		
			<input name="loginEmail" type="email" placeholder="E-maili aadress">
			
			<br><br>
			
			<input name="loginPassword" type="password" placeholder="Parool">
			
			<br><br>
			
			<input type="submit" value="Logi sisse">
		
		</form>
		
		<br><br>
		
		<h1>Loo kasutaja</h1>
		
		<form method="POST"> 
		
			<input name="signupUsername" type="username" placeholder="Kasutajatunnus"> <?php echo $signupUsernameError; ?>
		
			<br><br>
			
			<input name="signupPassword" type="password" placeholder="Parool"> <?php echo $signupPasswordError; ?>
			
			<br><br>
			
			<label>Sugu</label><br>
			
			 <?php if($gender == "male") { ?>
				<input type="radio" name="gender" value="male" checked> Male<br>
			 <?php } else { ?>
				<input type="radio" name="gender" value="male" > Male<br>
			 <?php } ?>
			 
			 <?php if($gender == "female") { ?>
				<input type="radio" name="gender" value="female" checked> Female<br>
			 <?php } else { ?>
				<input type="radio" name="gender" value="female" > Female<br>
			 <?php } ?>
			 
			 <?php if($gender == "other") { ?>
				<input type="radio" name="gender" value="other" checked> Other<br>
			 <?php } else { ?>
				<input type="radio" name="gender" value="other" > Other<br>
			 <?php } ?>
			
			<br><br>
		
			<input name="signupEmail" type="email" value="<?=$signupEmail;?>" placeholder="E-maili aadress"> <?php echo $signupEmailError; ?>
			
			<br><br>
			
			<input type="submit" value="Loo kasutaja">
		
		</form>
		
	</body>

</html>