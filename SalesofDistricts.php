<!DOCTYPE html>
<html>
<head>
      <title>Number of Sales Divded into Districts</title>
</head>
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

$sql = "SELECT district_name,count(product_name)
        FROM sale s
        LEFT JOIN (SELECT salesman_id,salesman_name,city_name,market_name,district_name
                    FROM salesman sm
                    LEFT JOIN (SELECT city_name,market_name,branch_id,district_name 
                                from branch b
          				        LEFT JOIN (SELECT market_name,market_id FROM market) m ON b.market_id=m.market_id
          				        RIGHT JOIN (SELECT city_name,city_id,district_name 
                                            FROM city c
                                            LEFT JOIN (SELECT district_name,district_id FROM district) d ON c.district_id=d.district_id) c ON b.city_id=c.city_id) b ON sm.branch_id=b.branch_id) sm ON s.salesman_id=sm.salesman_id
                                            RIGHT JOIN (SELECT product_name,product_id FROM product) p ON s.product_id=p.product_id
        GROUP BY district_name
        ORDER BY district_name;";
$result = mysqli_query($conn,$sql) or die("Error");

if (mysqli_num_rows($result) > 0) {
    // output data of each row
	echo "<table border='1'>";
	echo "<tr><td>DISTRICT NAME</td><td>AMOUNT SOLD</td></tr>";
    while($row = mysqli_fetch_array($result)) {
		echo "<tr>";
        echo "<td>" . $row["district_name"]. "</td><td>" . $row["count(product_name)"]. "</td>";
		echo "</tr>";
    }
	echo "</table>";
} else {
    echo "0 results";
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