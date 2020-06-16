<?php

$conn =new mysqli('localhost', 'root', 'mysql' , '');

$query = '';
$sqlScript = file('berkay_ersoy.sql');
foreach ($sqlScript as $line)	{
	
	$startWith = substr(trim($line), 0 ,2);
	$endWith = substr(trim($line), -1 ,1);
	
	if (empty($line) || $startWith == '--' || $startWith == '/*' || $startWith == '//') {
		continue;
	}
		
	$query = $query . $line;
	if ($endWith == ';') {
		mysqli_query($conn,$query) or die('<div class="error-response sql-import-response">Problem in executing the SQL query <b>' . $query. '</b></div>');
		$query= '';		
	}
}
echo '<div class="success-response sql-import-response">SQL file imported successfully</div>';


$con=mysqli_connect("localhost","root","mysql","berkay_ersoy");

if($con)
{
    $file="csv/districts.csv";
    $handle=fopen($file,"r");
    $i=0;
    while(($cont=fgetcsv($handle,1000,";")) !==false)
    {
        if($i==0)
        {
        $id=$cont[0];
        $name=$cont[1];
        $query="CREATE TABLE district (district_id int(11) PRIMARY KEY,district_name varchar(50));";
        echo $query,"<br>";
        mysqli_query($con,$query);
        }
        else
        {
        $query="INSERT INTO district (district_id,district_name) values ('$cont[0]','$cont[1]');";
        echo $query,"<br>";
        mysqli_query($con,$query);
        }
        $i++;
    }
    $file="csv/city.csv";
    $handle=fopen($file,"r");
    $i=0;
    while(($cont=fgetcsv($handle,1000,";")) !==false)
    {
        if($i==0)
        {
        $id=$cont[0];
        $name=$cont[1];
        $district=$cont[2];
        $query="CREATE TABLE city (city_id int(11) PRIMARY KEY,city_name varchar(50),district_id int(11),
                                    FOREIGN KEY (district_id) REFERENCES district(district_id)) ENGINE=INNODB;";
        echo $query,"<br>";
        mysqli_query($con,$query);
        }
        else
        {
        $query="INSERT INTO city (city_id,city_name,district_id) values ('$cont[0]','$cont[1]','$cont[2]');";
        echo $query,"<br>";
        mysqli_query($con,$query);
        }
        $i++;
    }
    $file="csv/markets.csv";
    $handle=fopen($file,"r");
    $i=0;
    while(($cont=fgetcsv($handle,1000,";")) !==false)
    {
        if($i==0)
        {
        $id=$cont[0];
        $name=$cont[1];
        $query="CREATE TABLE market (market_id int(11) PRIMARY KEY,market_name varchar(50));";
        echo $query,"<br>";
        mysqli_query($con,$query);
        }
        else
        {
        $query="INSERT INTO market (market_id,market_name) VALUES ('$cont[0]','$cont[1]');";
        echo $query,"<br>";
        mysqli_query($con,$query);
        }
        $i++;
    }
    $input = array("1", "2", "3", "4", "5","6","7","8","9","10");
    $rand_keys = array_rand($input, 5);
    for($city=0; $city<=81; $city++)
    {
        if($city==0)
        {
            $query="CREATE TABLE branch (branch_id int(11) AUTO_INCREMENT PRIMARY KEY,
                                    city_id int(11),
                                    market_id int(11),
                                    FOREIGN KEY (city_id) REFERENCES city(city_id),
                                    FOREIGN KEY (market_id) REFERENCES market(market_id)) ENGINE=INNODB;";
            echo $query,"<br>";
            mysqli_query($con,$query);
        }
        else
        {
        $input = array("1", "2", "3", "4", "5","6","7","8","9","10");
        $rand_keys = array_rand($input, 5);
        echo $city." ";
        echo $input[$rand_keys[0]];
        echo $input[$rand_keys[1]];
        echo $input[$rand_keys[2]];
        echo $input[$rand_keys[3]];
        echo $input[$rand_keys[4]];
        $market1=$input[$rand_keys[0]];
        $market2=$input[$rand_keys[1]];
        $market3=$input[$rand_keys[2]];
        $market4=$input[$rand_keys[3]];
        $market5=$input[$rand_keys[4]];
        $query="INSERT INTO branch(city_id,market_id)
                VALUES ('$city','$market1'),
                        ('$city','$market2'),
                        ('$city','$market3'),
                        ('$city','$market4'),
                        ('$city','$market5');";
        echo $query,"<br>";
        mysqli_query($con,$query);
        echo "<br>";
        }
    }
    $file="csv/customer.csv";
    $handle=fopen($file,"r");
    $i=0;
    $city_id=range(1,81);
    $city=array_merge($city_id,$city_id,$city_id,$city_id,$city_id,$city_id,$city_id,$city_id,$city_id,$city_id,$city_id,$city_id,$city_id,$city_id,$city_id,$city_id,$city_id,$city_id,$city_id,$city_id);
    shuffle($city);
    while(($cont=fgetcsv($handle,1000,";")) !==false)
    {
        if($i==0)
        {
        $id=$cont[0];
        $name=$cont[1];
        $query="CREATE TABLE customer (customer_id int(11) PRIMARY KEY,customer_name varchar(50),city_id int(11),
                                        FOREIGN KEY (city_id) REFERENCES city(city_id));";
        echo $query,"<br>";
        mysqli_query($con,$query);
        }
        else
        {
        $city_number=$city[($i-1)];
        $query="INSERT INTO customer (customer_id,customer_name,city_id) VALUES ('$cont[0]','$cont[1]',$city_number);";
        echo $query,"<br>";
        mysqli_query($con,$query);
        }
        $i++;
    }
    $file="csv/salesmans.csv";
    $handle=fopen($file,"r");
    $i=0;
    while(($cont=fgetcsv($handle,1000,";")) !==false)
    {
        if($i==0)
        {
        $id=$cont[0];
        $name=$cont[1];
        $query="CREATE TABLE salesman (salesman_id int(11) PRIMARY KEY,
                                    salesman_name varchar(50),
                                    branch_id int(11),
                                    FOREIGN KEY (branch_id) REFERENCES branch(branch_id)) ENGINE=INNODB;";
        echo $query,"<br>";
        mysqli_query($con,$query);
        }
        else
        {
        $query="INSERT INTO salesman (salesman_id,salesman_name,branch_id) values ('$cont[0]','$cont[1]','1');";
        echo $query,"<br>";
        mysqli_query($con,$query);
        }
        $i++;
    }
    $salesman=range(1,1215);
    shuffle($salesman);
    for($branch_id=1 ; $branch_id <406; $branch_id++)
    {
        echo "branch_id=". $branch_id. "<br>";
        echo "salesman_id=". $salesman[(3*$branch_id-3)]. "<br>";
        echo "salesman_id=". $salesman[(3*$branch_id-2)]. "<br>";
        echo "salesman_id=". $salesman[(3*$branch_id-1)]. "<br>";
        $salesman1=$salesman[(3*$branch_id-3)];
        $salesman2=$salesman[(3*$branch_id-2)];
        $salesman3=$salesman[(3*$branch_id-1)];
        $query1="UPDATE `salesman` 
                SET `branch_id` = '$branch_id' 
                WHERE `salesman`.`salesman_id` = $salesman1;";
            
        $query2="UPDATE `salesman` 
                SET `branch_id` = '$branch_id' 
                WHERE `salesman`.`salesman_id` = $salesman2;";
            
        $query3="UPDATE `salesman` 
                SET `branch_id` = '$branch_id' 
                WHERE `salesman`.`salesman_id` = $salesman3;";
        mysqli_query($con,$query1);
        mysqli_query($con,$query2);
        mysqli_query($con,$query3);
        echo $query1. "<br>";
        echo $query2. "<br>";
        echo $query3. "<br>";
        echo "<br>";
    }
    $file="csv/products.csv";
    $handle=fopen($file,"r");
    $i=0;
    while(($cont=fgetcsv($handle,1000,";")) !==false)
    {
        if($i==0)
        {
        $id=$cont[0];
        $name=$cont[1];
        $price=$cont[2];
        $query="CREATE TABLE product (product_id int(11) PRIMARY KEY,product_name varchar(100),price DOUBLE(10,2)) ENGINE=INNODB;";
        echo $query,"<br>";
        mysqli_query($con,$query);
        }
        else
        {
        $query="INSERT INTO product (product_id,product_name,price) VALUES ('$cont[0]','$cont[1]','$cont[2]');";
        echo $query,"<br>";
        mysqli_query($con,$query);
        }
        $i++;
    }
    $product=range(1,200);
    for ($customer=0; $customer < 1621; $customer++)
    {
        if($customer==0)
        {
            $query1="CREATE TABLE IF NOT EXISTS sale (
                        sale_id int(11) NOT NULL AUTO_INCREMENT,
                        product_id int(11) DEFAULT NULL,
                        customer_id int(11) DEFAULT NULL,
                        salesman_id int(11) DEFAULT NULL,
                        sale_date DATE DEFAULT NULL,
                        PRIMARY KEY (sale_id),
                        FOREIGN KEY (product_id) REFERENCES product(product_id),
                        FOREIGN KEY (customer_id) REFERENCES customer(customer_id),
                        FOREIGN KEY (salesman_id) REFERENCES salesman(salesman_id)) ENGINE=InnoDB;";
            mysqli_query($con,$query1);
            echo $customer. " ";
            echo $query1,"<br>";
        }
        else
        {
        echo $customer. " ". "<br>";
        $rand_num=mt_rand(2,5);
        echo "item numbers ". $rand_num. " ";
    
        for($i=0 ; $i < $rand_num; $i++)
        {
            $rand_keys=array_rand($product, $rand_num);
            $product1=$product[$rand_keys[$i]];
            $query="INSERT INTO sale(product_id,customer_id,salesman_id,sale_date)
                    VALUES ('$product1','$customer',(FLOOR(RAND()*(1215-1+1))+1),'2017-01-01' + INTERVAL rand()*1000 day);";
            mysqli_query($con,$query);
            echo $query,"<br>";
        }
        echo "<br>";
        }
    }
}
else
{
    echo "connection failed.";
}
?>