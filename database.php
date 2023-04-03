<!DOCTYPE html>
<html>
<head>
	<title>Admin Dashboard</title>
	<link rel="stylesheet" href="style.css">
</head>
<h1><i>Admin Dashboard</i></h1>
 <nav>
      <ul>
	<li><a href="database.php">Orders</a></li>
        <li><a href="index.php">Approved/Declined Orders</a></li>
  
      </ul>
    </nav>
<body>
	
	<h3>Orders</h3>
	<table>
		<thead>
			<tr>
				<th>Phone Number</th>
				<th>Product Name</th>
				<th>Quantity</th>
				<th>Action</th>
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

				// Check if order was approved or declined
				if(isset($_POST['approve'])) {
					// Transfer order to approved collection
					$order_id = $_POST['order_id'];
					$order = $collection_orders->findOne(['_id' => new MongoDB\BSON\ObjectID($order_id)]);
					$collection_approved->insertOne($order);

					// Delete order from orders collection
					$collection_orders->deleteOne(['_id' => new MongoDB\BSON\ObjectID($order_id)]);
				} else if(isset($_POST['decline'])) {
					// Transfer order to declined collection
					$order_id = $_POST['order_id'];
					$order = $collection_orders->findOne(['_id' => new MongoDB\BSON\ObjectID($order_id)]);
					$collection_declined->insertOne($order);

					// Delete order from orders collection
					$collection_orders->deleteOne(['_id' => new MongoDB\BSON\ObjectID($order_id)]);
				}

				// Fetch items from the orders collection
				$cursor = $collection_orders->find([]);

				foreach ($cursor as $document) {
				    echo "<tr>";
				    echo "<td>" . $document["phone_number"] . "</td>";
				    echo "<td>" . $document["productname"] . "</td>";
				    echo "<td>" . $document["quantity"] . "</td>";
				    echo "<td>";
				    echo "<form method='post'>";
				    echo "<input type='hidden' name='order_id' value='" . $document["_id"] . "'>";
				    echo "<button type='submit' name='approve' class='approve-btn'>Approve</button>";
				    echo "<button type='submit' name='decline' class='decline-btn'>Decline</button>";
				    echo "</form>";
				    echo "</td>";
				    echo "</tr>";
				}

				// Close connection (optional, as MongoDB automatically closes connections at the end of script execution)
				unset($client);
			?>
		</tbody>
	</table>

	<h3>Users</h3>
	<table>
		<thead>
			<tr>
				<th>User ID</th>

				<th>Name</th>
				<th>Phone Number</th>
				<th>Location</th>
			</tr>
		</thead>
		<tbody>
			<?php
				// Replace these variables with your own database credentials
				$database_name = "ussd";
				$collection_users_name = "users";

				// Create connection (if not already created)
				if (!isset($client)) {
					$client = new MongoDB\Client("mongodb+srv://nmurigi:2461314454@cluster0.3tythl5.mongodb.net/?retryWrites=true&w=majority");
					$database = $client->selectDatabase($database_name);
				}

				// Select the users collection
				$collection_users = $database->selectCollection($collection_users_name);

				// Fetch items from the users collection
				$cursor = $collection_users->find([]);

				foreach ($cursor as $document) {
				    echo "<tr>";
				    echo "<td>" . $document["id_number"] . "</td>";
				    echo "<td>" . $document["fullname"] . "</td>";
				    echo "<td>" . $document["phone_number"] . "</td>";
				    echo "<td>" . $document["location"] . "</td>";
				    echo "</tr>";
				}

				// Close connection (optional, as MongoDB automatically closes connections at the end of script execution)
				unset($client);
			?>
		</tbody>
	</table>

</body>
</html
