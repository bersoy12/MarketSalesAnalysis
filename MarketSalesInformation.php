<!DOCTYPE html>
<html>
<body>
Shows which product has been sold how many times.
<div style="width:100%;">
    <div style="float: left; width: auto"> 
		<form action='showProduct.php' method='post'>
			<input type="submit" value="Product">
        </form>
	</div>
</br>
</br>
Shows which salesman has sold how many products.
</br>
    <div style="float: left; width: auto"> 
		<form action='showSalesman.php' method='post'>
            <input type="submit" value="Salesman">
        </form>
	</div>
	</br>
</br>
Shows all the sale information of chosen salesman.
</br>
	<div style="float: left; width: auto"> 
		<form action='ChooseSalesman.php' method='post'>
			<input type="submit" value="Choose Salesman">
        </form>
	</div>
	</br>
</br>
Shows his/her products, their prices, sale date of chosen customer.
</br>
	<div style="float: left; width: auto">
		<form action='invoice.php' method='post'>
			<input type="submit" value="Invoice">
		</form>
	</div>
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