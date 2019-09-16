<?php 
$db = new PDO('mysql:host=localhost;dbname=car_sales;charset=utf8', 'root', '');
$typeSearch = $_POST["typeSearch"];

switch ($typeSearch) { //requête differente en f° du critere de recherche
	case 'date':
		$req1 = $db->prepare('SELECT * FROM tableau_csv WHERE purchaseDate = ?');
		$req1->execute(array($_POST['searchDate']));
		break;

	case 'name':
		$req1 = $db->prepare('SELECT * FROM tableau_csv WHERE firstName = ? AND lastName = ?');
		$req1->execute(array($_POST['searchFirstName'], $_POST['searchLastName']));
		break;

	case 'carBrand':
		$req1 = $db->prepare('SELECT * FROM tableau_csv WHERE carBrand = ?');
		$req1->execute(array($_POST['searchCarBrand']));
		break;
	
	default:
		echo "Please enter a search criteria.";
		break;
	};

$rows = $req1->fetch(); //retourne la table filtrée

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8"/>
	<title>Results</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
	<div class="container mt-3">
		<form action="index.php">
			<input type="Submit" value="Retour">
		</form>
		<p>
			<b>Total : </b>
		</p>
		<table class='table'>
			<tr>
				<th>Purchase date</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Age</th>
				<th>Car Brand</th>
				<th>Mileage (km/year)</th>
			</tr>
			
			<?php
				do {
					echo '<tr>';
					for($column=0; $column<6; $column++){
						echo '<td>' . $rows[$column] . '</td>'; //affiche cellule colomne par colomne
					};
					echo '</tr>';
				} while ($rows = $req1->fetch()); //on parcourt ligne par ligne, do/while sinon la boucle skip la première ligne
			?>
		</table>

		<?php $req1->closeCursor(); ?>
	</div>
</body>
</html>