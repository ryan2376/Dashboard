  <!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <h1><i>Admin Dashboard</i></h1>
    <nav>
      <ul>
        <li><a href="database.php">Orders</a></li>
        <li><a href="index.php">Approved/Declined Orders</a></li>
      </ul>
    </nav>
    <h3 class="approved">Approved Orders</h3>
	<table>
		<thead>
			<tr>
			 	<th>Phone Number</th>
				<th>Product Name</th>
				<th>Quantity</th>
			</tr>
		</thead>
		<tbody>
			<?php
			 // Replace these variables with your own database credentials
				$database_name = "ussd";
				$collection_orders_name = "orders";
				$collection_approved_name = "approved";
				$collection_declined_name = "declined";

				// Create connection
				require_once 'vendor/autoload.php';
				$client = new MongoDB\Client("mongodb+srv://nmurigi:2461314454@cluster0.3tythl5.mongodb.net/?retryWrites=true&w=majority");

				// Select database and collections
				$database = $client->selectDatabase($database_name);
				$collection_orders = $database->selectCollection($collection_orders_name);
				$collection_approved = $database->selectCollection($collection_approved_name);
				$collection_declined = $database->selectCollection($collection_declined_name);

				// Replace these variables with your own database credentials
				$database_name = "ussd";
				$collection_users_name = "approved";

				// Create connection (if not already created)
				if (!isset($client)) {
					$client = new MongoDB\Client("mongodb+srv://nmurigi:2461314454@cluster0.3tythl5.mongodb.net/?retryWrites=true&w=majority");
					$database = $client->selectDatabase($database_name);
				}

				// Select the approved collection
				$collection_users = $database->selectCollection($collection_approved_name);

				// Fetch items from the approved collection
				$cursor = $collection_approved->find([]);

				foreach ($cursor as $document) {
				    echo "<tr>";
				    echo "<td>" . $document["phone_number"] . "</td>";
				    echo "<td>" . $document["productname"] . "</td>";
				    echo "<td>" . $document["quantity"] . "</td>";
				    echo "</tr>";
				}

				// Close connection (optional, as MongoDB automatically closes connections at the end of script execution)
				unset($client);
			?>
		</tbody>

	</table>

<h3 class="declined">Declined Orders</h3>
	<table>
		<thead>
			<tr>
			 	<th>Phone Number</th>
				<th>Product Name</th>
				<th>Quantity</th>
			</tr>
		</thead>
		<tbody>
			<?php

				// Replace these variables with your own database credentials
				$database_name = "ussd";
				$collection_declined_name = "declined";

				// Create connection (if not already created)
				if (!isset($client)) {
					$client = new MongoDB\Client("mongodb+srv://nmurigi:2461314454@cluster0.3tythl5.mongodb.net/?retryWrites=true&w=majority");
					$database = $client->selectDatabase($database_name);
				}

				// Select the declined collection
				$collection_declined = $database->selectCollection($collection_declined_name);

				// Fetch items from the declined collection
				$cursor = $collection_declined->find([]);

				foreach ($cursor as $document) {
				    echo "<tr>";
				    echo "<td>" . $document["phone_number"] . "</td>";
				    echo "<td>" . $document["productname"] . "</td>";
				    echo "<td>" . $document["quantity"] . "</td>";
				    echo "</tr>";
				}

				// Close connection (optional, as MongoDB automatically closes connections at the end of script execution)
				unset($client);

				?>
		</tbody>

	</table>

</body>
</html>
