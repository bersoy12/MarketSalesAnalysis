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

$sql = "SELECT DISTINCT(city_name) FROM city ";
$result = mysqli_query($conn,$sql) or die("Error");

if (mysqli_num_rows($result) > 0) {
    // output data of each row
	echo "<form action='ShowCitySalesInformation.php' method='post'>";
	echo '<select name="cityname">';
    while($row = mysqli_fetch_array($result)) {
		echo "<option value='" . $row["city_name"] . "'>";
        echo $row["city_name"];
		echo "</option>";
    }
	echo '</select>';
	echo '<input type="submit" value="Submit">';
	echo "</form>";
}
mysqli_close($conn);
?>
</div>
<style type ="text/css" >
		.footer{ 
			position: fixed;     
			text-align: center;    
			bottom: 0px; 
			width: 100%;
		}  
	 </style>
	 <div class="footer">BerkayErsoyCSE348Project</div>

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

$sql = "SELECT market_name,COUNT(product_id)
		FROM sale s
		LEFT JOIN (SELECT salesman_id,market_name,city_name
					FROM salesman sm
					LEFT JOIN (SELECT city_name,market_name,branch_id
								FROM branch b
								LEFT JOIN (SELECT market_name,market_id FROM market) m ON b.market_id=m.market_id
                				RIGHT JOIN (SELECT city_id,city_name FROM city WHERE city_name='" . $_POST['cityname'] ."') c ON b.city_id=c.city_id) b ON sm.branch_id=b.branch_id) sm ON s.salesman_id=sm.salesman_id
        GROUP BY market_name
		HAVING market_name IS NOT NULL;";
$result = mysqli_query($conn,$sql) or die("Error");

if (mysqli_num_rows($result) > 0) {
    // output data of each row
	echo "<table border='1'>";
	echo "<tr><td>MARKET</td><td>AMOUNT PRODUCT SOLD</td></tr>";
    while($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        echo "<td>" . $row["market_name"]. "</td><td>" . $row["COUNT(product_id)"]. "</td>";
        echo "</tr>";
    }
	echo "</table>";
}
mysqli_close($conn);
?>