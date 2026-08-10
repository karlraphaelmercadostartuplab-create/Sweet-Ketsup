<?php
$servername = "localhost";
$username = "root";  // Replace with your database username
$password = "";      // Replace with your database password
$dbname = "sweet_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update the stock if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $new_quantity = $_POST['new_quantity'];

    $update_sql = "UPDATE products SET quantity_in_stock = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ii", $new_quantity, $product_id);

    if ($stmt->execute()) {
        echo "Stock updated successfully!";
    } else {
        echo "Error updating stock: " . $conn->error;
    }
}

// Fetch products from the database
$sql = "SELECT id, name, price, quantity_in_stock FROM products";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Market Stock</title>
    <style>
        table {
            width: 70%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
        }
        form {
            display: inline;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">SweetKetsoup Stock</h1>
    <table>
        <tr>
            <th>Product Name</th>
            <th>Price</th>
            <th>Stock Quantity</th>
            <th>Edit Stock</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["price"] . "</td>";
                echo "<td>";
                if ($row["quantity_in_stock"] == 0) {
                    echo "Out of Stock";
                } else {
                    echo $row["quantity_in_stock"];
                }
                echo "</td>";
                echo "<td>";
                echo "<form action='' method='POST'>";
                echo "<input type='hidden' name='product_id' value='" . $row['id'] . "'>";
                echo "<input type='number' name='new_quantity' value='" . $row['quantity_in_stock'] . "' min='0'>";
                echo "<input type='submit' value='Update'>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No products found</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>