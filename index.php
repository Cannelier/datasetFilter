<?php if (isset($_POST['typeSearch'])) {
		$typeSearch = $_POST['typeSearch'];
	};

		//requête liste des marques de voitures
	$db = new PDO('mysql:host=localhost;dbname=car_sales;charset=utf8', 'root', '');

	$getCarList= "SELECT DISTINCT carBrand FROM tableau_csv";
?>

<!DOCTYPE html>
<html>
<head>
	<title>Search</title>
	 <!-- BOOTSTRAP : Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
	<div class="container mt-3">
		<h3>Search a car purchase</h3>

		<form action="result.php" method="POST">
			<div class="form-group">
				Search by :
				<!-- CRITERE DE RECHERCHE-->
				<select name="typeSearch" class="mt-3 mb-2" required>
					<option 
					<?php //on fige la valeur à l'envoi du form//
					 if(isset($typeSearch) AND $typeSearch=='date') { ?>selected <?php } ?> 
					value="date">Date</option>
					<option
					<?php if(isset($typeSearch) AND $typeSearch=='name') { ?>selected <?php } ?> 
					 value="name">Name</option>
					<option <?php if(isset($typeSearch) AND $typeSearch=='carBrand') { ?>selected <?php } ?>  value="carBrand">Car brand</option>
				</select>
				<input type="submit" name="submit" value="Go" formaction="#">
				<!-- ----------  ------- -->
			<br>


			<!-- FORMULAIRE SELON LE CRITERE DE RECERCHE -->
			<?php
			if (isset($typeSearch)) {
				echo "<form action='result.php' method='POST'>";

				switch ($typeSearch) {
					case 'date':
						echo "Purchase Date : <input type='Date' name='searchDate' value='2010-05-02' required>";
						break;

					case 'name':
						echo "First Name : <input type='text' name='searchFirstName' value='Eleanore' required>
							<br>
							Last name : <input type='text' name='searchLastName' value='Kihn' required>";
						break;

					case 'carBrand': ?>
						Car Brand:
						<select name='searchCarBrand' required>
							<?php //afficher la liste des marques de voitures
								foreach ($db->query($getCarList) as $carBrand) {
									echo "<option value='". $carBrand[0]. "'>".$carBrand[0]. "</option>";
								};
							?>
						</select>
						
						<?php
						break;
				};
			}; ?>


				<br><br>
				<?php
				if (isset($_POST['typeSearch'])) {
				echo "<input type='submit' name='submit' class='mt-1' value='Rechercher'>";
				}; ?>
			</div>
			</form>
		</div>
</body>
</html>