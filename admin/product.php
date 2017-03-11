<script>
/**functions of change data in report*/
	function changeQuan(id,valu){
		document.getElementById(id).innerHTML = valu;	
	}
	function addQuan(id,valu){
		var orig =  document.getElementById(id).innerHTML;
		var sum = parseInt(orig)+parseInt(valu);
		document.getElementById(id).innerHTML = sum;
	}
	function firm(text,id){  
		if(confirm(text)){
			document.getElementById(id).submit();
		}else{
			return false;
		}
	}
</script>
<?php
if(isset($_GET['action'])){
	$action = $_GET['action'];
}else{
	$action = 'detail';
}
$sql_fcata = "select type_id,product_name from product_service where price IS NULL ORDER by type_id";
$result_fcata = $mysql->query($sql_fcata);
if($action == 'cata'){
/**Show Catalogue of product*/
    echo "<table class ='table-stripped'>
			<th colspan='2'>Product catalogue:</th>
			<tr>
				<td class='bold'>Catalogue ID</td>
				<td class='bold'>Catalogue Name</td>
				<td style='width:1%;'></td>
				<td style='width:1%;'></td>
			</tr>";
    while($row_fcata = $mysql->fetch($result_fcata)) {
        echo "<tr>
				<td>".$row_fcata['type_id']."</td>
				<td>".$row_fcata['product_name']." </td>
				<td><samp onclick=\"firm('Do you want to Edit this Product Type?','editCata{$row_fcata['type_id']}')\">E</samp></td>
				<td><kbd onclick=\"firm('Do you want to Delete this Product Type and all of its sub product items?','deleteCata{$row_fcata['type_id']}')\">X</kbd></td>
			</tr>";
		echo "<form action='index.php?page=product&action=new' method='post' id='editCata{$row_fcata['type_id']}'>
					<input type='hidden' name='origCataEdit' value='{$row_fcata['type_id']},{$row_fcata['product_name']}'/>
				</form>
				<form action='' method='post' id='deleteCata{$row_fcata['type_id']}'>
					<input type='hidden' name='origCataDel' value='{$row_fcata['type_id']}'/>
				</form>";
    }
    echo "</table>";
	if(isset($_POST['origCataDel'])){
			$sql_delproduct = "DELETE FROM product_service WHERE type_id = {$_POST['origCataDel']}";
			$mysql->query($sql_delproduct);
			echo "<script>window.location.href='index.php?page=product&action=cata';</script>";
		}
}else if($action == 'detail'){
/**Show product detail*/
	$sql_fdetail = "select s.id,s.product_name as product_name,s.price,p.product_name AS product_type from product_service as s join product_service as p where p.type_id = s.type_id and s.price IS NOT NULL GROUP BY s.id"; 
	    $result = $mysql->query($sql_fdetail);
		
        echo "<table class ='table-stripped'>
				<th colspan='6'>Product Category:</th>
				<tr>
					<td class='bold'>Product ID</td>
					<td class='bold'>Product Name</td>
					<td class='bold'>Product Price</td>
					<td class='bold'>Product Type</td>
					<td style='width:1%;'></td>
					<td style='width:1%;'></td>
				</tr>";
        while($row = $mysql->fetch($result)) {
            echo "<tr>
					<td>".$row['id']."</td>
					<td>".$row['product_name']." </td>
					<td>&#165;".$row['price']." </td>
					<td>".$row['product_type']." </td>
					<td><samp onclick=\"firm('Do you want to Edit this product?','editproduct{$row['id']}')\">E</samp></td>
					<td><kbd onclick=\"firm('Do you want to Delete this product?','deleteproduct{$row['id']}')\">X</kbd></td>
				</tr>";
			echo "<form action='index.php?page=product&action=new' method='post' id='editproduct{$row['id']}'>
					<input type='hidden' name='origproductEdit' value='{$row['id']},{$row['product_name']},{$row['price']},{$row['product_name']}'/>
				</form>
				<form action='' method='post' id='deleteproduct{$row['id']}'>
					<input type='hidden' name='origproductDel' value='{$row['id']}'/>
				</form>";
        }
        echo "</table>";
/**Delete product item function*/
		if(isset($_POST['origproductDel'])){
			$sql_delproduct = "DELETE FROM product_service WHERE id = {$_POST['origproductDel']}";
			$mysql->query($sql_delproduct);
			echo "<script>window.location.href='index.php?page=product&action=detail';</script>";
		}
}else if($action == 'sold'){
/**Show product sold information*/
	echo "<table class ='table-stripped'>"; 
	while($row_fcata = $mysql->fetch($result_fcata)) {
		$cata_id = $row_fcata['type_id'];	
        $sql_finfo = "select id,s.product_name as product_name,s.price from product_service as s where s.type_id = ".$cata_id." and s.price IS NOT NULL;";
	    $result_finfo = $mysql->query($sql_finfo); 
        echo "<th colspan='3' id=".$row_fcata['product_name'].">".$row_fcata['product_name']."</th>
				<tr>
					<td  class='text-centered'><b>Product Name</b></td>
					<td class='bold'>Price</td><td class='bold'>Quantity</td>
				</tr>";
		while($row_finfo = $mysql->fetch($result_finfo)) {
			echo "<tr>
					<td class='text-centered'>".$row_finfo['product_name']."</td>
					<td>&#165;".$row_finfo['price']." </td>";   
            $productid = $row_finfo['id'];
            $sql_fquantity = "SELECT sum(quantity)as Quantity from order_product where product_id = ".$productid.";";
			$result_fquantity = $mysql->query($sql_fquantity); 
  			while($row_fquantity = $mysql->fetch($result_fquantity)) {
		        echo "<td>".$row_fquantity['Quantity']."</td>
				</tr>";
		    }
	    }   
    }echo "</table>";
}else if($action == 'new'){
	echo "<form action='submit.php' method='post'>
		<table>
			<th colspan='4'> 
				<label>New Product&nbsp;<input type='radio' name='isCata' value='product' onclick='refresh()' checked>&nbsp; &nbsp;</label><label>&nbsp; &nbsp;
				New Product Category <input type='radio' name='isCata' value='cata' onclick='hideCata()'></label>
			</th>
		<script>
			function refresh(){
				window.location.href='index.php?page=product&action=new';
			}
			function hideCata(){
				var cata = document.getElementsByClassName('hideCata');
				document.getElementsByName('price')[0].required = false;
				for(var i = 0; i < cata.length;i++){
					cata[i].style.display = 'none';
				}
			}
		</script>";
	$sql_LastproductID = 'SELECT id FROM product_service ORDER BY id DESC LIMIT 1';
	$productId = $mysql->fetch($mysql->query($sql_LastproductID))[0]+1;
	echo"		<tr>
				<td class='bold' class='width-2'>Product ID</td>
				<td class='width-2'>
					<input type='number' name='origId' maxlength='6' value='$productId' disabled='disabled'/>
					<input type='hidden' name='cataId' value='$productId' />
					<!--save latest id number for insert new catalogue(set product.id = catalogue_id for each product cata) -->
				</td>
			</tr>
			<tr>
				<td class='bold'>Name<span class='req'> *</span></td>
				<td>
					<input type='text' maxlength='30' name='productName' required/>
				</td>
				<td class='bold'><span class='hideCata'>Product Type<span class='req'> *</span></span></td>
				<td class='width-4'><span class='hideCata'>
					<div style='margin-left:-200px;'><b>Catalogue:</b>
						<select name='productCata' class='width-6'>";
	$sql_productCata = "SELECT type_id,product_name FROM product_service WHERE price is NULL ORDER BY product_name";						
	$result_productCata = $mysql->query($sql_productCata);	
	$productCata = array();
		while($row = $mysql->fetch($result_productCata)) {
			echo "<option value=$row[0]>$row[1]</option>";
			$productCata[$row[1]] = $row[0];
		}	
	echo"				</select>
					</div></span>
				</td>
			</tr>
			<tr>
				<td class='bold'><span class='hideCata'>Price<span class='req'> *</span></span></td>
				<td><span class='hideCata'>
					<label>&#165;&nbsp;</label><input type='number' max='999' name='price' required/>
				</span></td>
			</tr>
		</table>
		<div class='text-right'>
			<button class='submit' type='primary' name='submit'>Submit</button>
		</div>
	</form>";
	if(isset($_POST['origproductEdit'])){
		$origproduct = explode(',',$_POST['origproductEdit']);
		echo "<script>
				document.getElementsByName('isCata')[1].disabled = true;
				var productid = document.getElementsByName('origId')[0];
				productid.disabled = false;
				document.getElementsByName('cataId')[0].disabled = true;
				productid.value = {$origproduct[0]};
				productid.onchange = function(){
					productid.value = {$origproduct[0]};
				};
				document.getElementsByName('productName')[0].value = '{$origproduct[1]}';
				document.getElementsByName('price')[0].value = '{$origproduct[2]}';
				document.getElementsByName('productCata')[0].value = '{$productCata[$origproduct[3]]}';
			</script>";
	}else if(isset($_POST['origCataEdit'])){
		$origCata = explode(',',$_POST['origCataEdit']);
		echo "<script>
				hideCata();
				document.getElementsByName('isCata')[0].disabled = true;
				document.getElementsByName('isCata')[1].checked = true;
				var productid = document.getElementsByName('origId')[0];
				productid.disabled = false;
				document.getElementsByName('cataId')[0].disabled = true;
				productid.value = {$origCata[0]};
				productid.onchange = function(){
					productid.value = {$origCata[0]};
				};
				document.getElementsByName('productName')[0].value = '{$origCata[1]}';
			</script>";
	}
}else if($action== 'weekly'){
	/*echo "<style>
			input[type=range]:before { content: attr(min); padding-right: 5px; }
			input[type=range]:after { content: attr(max); padding-left: 5px;}
		</style>
		<script>function changenum(){
					document.getElementById('rangeres').innerHTML = document.getElementById('weeknum').value;
				}
		</script>
		<b>Week <span id='rangeres'><span></b>
		<input type='range' id='weeknum' step='1' min='0' max='53' onchange='changenum()'/>";*/
/**show weekly report*/
/**a form to change week and year, default is now*/
	$timeres = $mysql->fetch($mysql->query('select year(now()),week(now(),1)'));
	$weeknum = $timeres[1];
	$yearnum = $timeres[0];
	echo "<div class='my_show'>
			<form method='post' action='index.php?page=product&action=weekly'>
				Week:<input type='number' name='weeknum' id='weeknum' placeholder='Week' min='0' max='53' value='$weeknum'/>
				Year:<input type='number' name='yearnum' id='yearnum' placeholder='Year' min='2010' max='$yearnum' value='$yearnum'/>
				<button type='submit' value='OK' class='my_hidden'>OK</button>
			</form>";
	if(isset($_POST['weeknum'])&&$_POST['weeknum']!=''){$weeknum = inputCheck($_POST['weeknum']);}
	if(!empty($_POST['yearnum'])){$yearnum = inputCheck($_POST['yearnum']);}
	echo "<script>
			document.getElementById('weeknum').value = $weeknum;
			document.getElementById('yearnum').value = $yearnum;
		</script>";
/**active sql to find the date of Mon. to Sat.*/	
	$sql_subdate = "select DATE_ADD('$yearnum-01-01',INTERVAL (7*$weeknum-WEEKDAY('$yearnum-01-01')) DAY) AS start, DATE_ADD(DATE_ADD('$yearnum-01-01',INTERVAL (7*$weeknum-WEEKDAY('$yearnum-01-01')) DAY),INTERVAL 5 DAY) AS end;";
	$subdate = $mysql->fetch($mysql->query($sql_subdate));
/**show weekly report table*/
	echo "<table class ='table-stripped'>
			<th style='font-size:1.6em' class='text-centered' colspan='10'>Weekly's selling Product Diary: {$subdate['start']} to {$subdate['end']}</th>"; 
	while($row_fcata = $mysql->fetch($result_fcata)) {
		$cata_id = $row_fcata['type_id'];	
        $sql_finfo = "SELECT id,s.product_name AS product_name,s.price FROM product_service AS s WHERE s.type_id = ".$cata_id." AND s.price IS NOT NULL;";
	    $result_finfo = $mysql->query($sql_finfo); 
        echo "<tr id='{$row_fcata['product_name']}'>
				<td class='text-centered'><b style='font-size:1.2em;'>{$row_fcata['product_name']}</b></td>
				<td class='bold'>Price</td>
				<td class='bold'>Monday</td>
				<td class='bold'>Tuesday</td>
				<td class='bold'>Wednesday</td>
				<td class='bold'>Thursday</td>
				<td class='bold'>Friday</td>
				<td class='bold'>Saturday</td>
				<td class='bold'>Quantity</td>
			</tr>";
		while($row_finfo = $mysql->fetch($result_finfo)) {
			echo "<tr>
					<td class='text-centered'>".$row_finfo['product_name']."</td>
					<td>&#165;".$row_finfo['price']." </td>
					<td id='1_{$row_finfo['id']}'></td>
					<td id='2_{$row_finfo['id']}'></td>
					<td id='3_{$row_finfo['id']}'></td>
					<td id='4_{$row_finfo['id']}'></td>
					<td id='5_{$row_finfo['id']}'></td>
					<td id='6_{$row_finfo['id']}'></td>
					<td id='q_{$row_finfo['id']}'>0</td>
				</tr>";
	    }echo "<tr>
					<td class='text-centered'>TOTAL</td>
					<td></td>
					<td>&#165;<span id='1_c$cata_id'>0</span></td>
					<td>&#165;<span id='2_c$cata_id'>0</span></td>
					<td>&#165;<span id='3_c$cata_id'>0</span></td>
					<td>&#165;<span id='4_c$cata_id'>0</span></td>
					<td>&#165;<span id='5_c$cata_id'>0</span></td>
					<td>&#165;<span id='6_c$cata_id'>0</td>
					<td id='q_c$cata_id'>0</td>
				</tr>
				<tr>
					<td class='text-centered'><b>Total Week: </b></td>
					<td><kbd>&#165;<span id='total_$cata_id'>0</span></kbd></td>
				<tr/>";
	}
	echo "<tr>
			<td class='fat'><b>AMOUNT TOTAL:&nbsp; &nbsp; <samp>&#165;<span id='total_all'>0</span></b></samp></td>
			<td></td>
			<td>&#165;<span id='day1'>0</span></td>
			<td>&#165;<span id='day2'>0</span></td>
			<td>&#165;<span id='day3'>0</span></td>
			<td>&#165;<span id='day4'>0</span></td>
			<td>&#165;<span id='day5'>0</span></td>
			<td>&#165;<span id='day6'>0</span></td>
		  </tr>
		</table>
	</div>";
/**stastic data and write it on the report table*/
	for($dayweek=2;$dayweek<8;$dayweek++){
		$sql="select of.product_id,sum(quantity),sum(quantity)*fc.price,fc.type_id from order_product as of join product_service as fc ON of.product_id = fc.id where order_id in (select id from orders where week(date,1) = $weeknum and year(date)=$yearnum and DAYOFWEEK(date) = $dayweek) group by product_id";
		$res = $mysql->query($sql);
		$zhou = $dayweek - 1;
		while($row = $mysql->fetch($res)){
			echo "<script>
					changeQuan('{$zhou}_{$row[0]}',{$row[1]});
					addQuan('q_{$row[0]}',{$row[1]});
					addQuan('{$zhou}_c{$row[3]}',{$row[2]});
					addQuan('q_c{$row[3]}',{$row[1]});
					addQuan('total_{$row[3]}',{$row[2]});
					addQuan('total_all',{$row[2]});
					addQuan('day{$zhou}',{$row[2]});
				</script>";
		}
	}
}
?>