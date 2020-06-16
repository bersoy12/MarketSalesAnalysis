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

$sql = "SELECT salesman_id, salesman_name FROM salesman";
$result = mysqli_query($conn,$sql) or die("Error");

if (mysqli_num_rows($result) > 0) {
    // output data of each row
	echo "<form action='ChooseSalesman.php' method='post'>";
	echo '<select name="salesmanname">';
    while($row = mysqli_fetch_array($result)) {
		echo "<option value='" . $row["salesman_name"] . "'>";
        echo $row["salesman_name"];
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

$sql = "SELECT salesman_name,city_name,market_name,product_name
        FROM sale s
        LEFT JOIN (SELECT salesman_id,salesman_name,city_name,market_name
                    FROM salesman sm
                    LEFT JOIN (SELECT city_name,market_name,branch_id 
                                FROM branch b
          				        LEFT JOIN (SELECT market_name,market_id FROM market) m ON b.market_id=m.market_id
          				        RIGHT JOIN (select city_name,city_id FROM city) c ON b.city_id=c.city_id) b ON sm.branch_id=b.branch_id) sm ON s.salesman_id=sm.salesman_id
        RIGHT JOIN (SELECT product_name,product_id FROM product) p ON s.product_id=p.product_id
        HAVING salesman_name LIKE '" . $_POST['salesmanname'] . "';";
$result = mysqli_query($conn,$sql) or die("Error");

if (mysqli_num_rows($result) > 0) {
    // output data of each row
	echo "<table border='1'>";
	echo "<tr><td>SALESMAN NAME</td><td>CITY NAME</td><td>MARKET NAME</td><td>PRODUCT NAME</td></tr>";
    while($row = mysqli_fetch_array($result)) {
		echo "<tr>";
        echo "<td>" . $row["salesman_name"]. "</td><td>" . $row["city_name"]. "</td><td>" . $row["market_name"]. "</td><td>" . $row["product_name"]. "</td>";
		echo "</tr>";
    }
	echo "</table>";
} else {
    echo "0 results";
}
mysqli_close($conn);
?>