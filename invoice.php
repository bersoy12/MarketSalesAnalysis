<!DOCTYPE html>
<html>
<body>
<?php
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "berkay_ersoy";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} 

$sql = "SELECT customer_id, customer_name FROM customer";
$result = mysqli_query($conn,$sql) or die("Error");

if (mysqli_num_rows($result) > 0) {
    // output data of each row
	echo "<form action='invoice.php' method='post'>";
	echo '<select name="customername">';
    while($row = mysqli_fetch_array($result)) {
		echo "<option value='" . $row["customer_name"] . "'>";
        echo $row["customer_name"];
		echo "</option>";
    }
	echo '</select>';
	echo '<input type="submit" value="Submit">';
	echo "</form>";
} else {
    echo "0 results";
}
mysqli_close($conn);
?>

</body>
</html>

<?php
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "berkay_ersoy";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} 

$sql = "SELECT customer_name,city_name,market_name,product_name,CONCAT(price,' ₺'),sale_date
        FROM sale s
        LEFT join (SELECT salesman_id,salesman_name,city_name,market_name
                    FROM salesman sm
                    LEFT JOIN (SELECT city_name,market_name,branch_id 
                                FROM branch b
          				        LEFT join (select market_name,market_id FROM market) m ON b.market_id=m.market_id
          				        RIGHT join (select city_name,city_id FROM city) c ON b.city_id=c.city_id) b ON sm.branch_id=b.branch_id) sm ON s.salesman_id=sm.salesman_id
        RIGHT JOIN (SELECT product_name,product_id,price FROM product) p ON s.product_id=p.product_id
        RIGHT JOIN (select customer_name,customer_id from customer) cu ON s.customer_id=cu.customer_id
        HAVING customer_name LIKE '" . $_POST['customername'] . "'
        ORDER BY sale_date;";
$result = mysqli_query($conn,$sql) or die("Error");

if (mysqli_num_rows($result) > 0) {
    // output data of each row
	echo "<table border='1'>";
	echo "<tr><td>CUSTOMER NAME</td><td>CITY NAME</td><td>MARKET NAME</td><td>PRODUCT NAME</td><td>PRICE</td><td>SALE DATE</td></tr>";
    while($row = mysqli_fetch_array($result)) {
		echo "<tr>";
        echo "<td>" . $row["customer_name"]. "</td><td>" . $row["city_name"]. "</td><td>" . $row["market_name"]. "</td><td>" . $row["product_name"]. "</td><td>" . $row["CONCAT(price,' ₺')"]. "</td><td>" . $row["sale_date"]. "</td>";
		echo "</tr>";
    }
	echo "</table>";
} else {
    echo "0 results";
}
mysqli_close($conn);
?>