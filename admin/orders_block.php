<script>
/**change block's style after click pay,edit,delete and more buttons*/	
	function paidstyle(orid){	
		$('#obnav'+orid+' *').css('background','rgba(166, 255, 209,1)');
		document.getElementById('paid'+orid).style.visibility='visible';
		document.getElementById('btn2'+orid).style.display='none';
		if(document.getElementById('more'+orid)){
			document.getElementById('more'+orid).style.marginLeft='200px'; 
			document.getElementById('fold'+orid).style.marginLeft='200px';
		}		
	}
	function submit(orid){
		document.getElementById('formd'+orid).submit();
	}
	function foldbtn(orid){
		document.getElementById('ob'+orid).style.height='300px';
		document.getElementById('obnav'+orid).style.height= '280px';
		document.getElementById('more'+orid).style.display='inline';
		document.getElementById('fold'+orid).style.display='none';
		var x1 = document.getElementsByClassName('obtd'+orid);
		var i1;
		for (i1=0;i1<x1.length;i1++){
			x1[i1].style.display= 'none';
		}
	}
	function morebtn(orid,t){
		document.getElementById('ob'+orid).style.height= ((40*(t-3))+300)+'px';
		document.getElementById('obnav'+orid).style.height= ((40*(t-3))+280)+'px';
		document.getElementById('more'+orid).style.display='none';
		document.getElementById('fold'+orid).style.display='inline';
		var x = document.getElementsByClassName('obtd'+orid);
		var i;
		for (i=0;i<x.length;i++){
			x[i].style.display= 'table-cell';
		}
	}
	
	function payOrder(orid){
		if(confirm('Do you want to Pay order No.'+orid+'?')){
			document.getElementById('pay'+orid).click();
		}
	}
	function deleteOrder(orid){
		if(confirm('Do you want to Delete order No.'+orid+'?')){
			document.getElementById('del'+orid).click();
		}
	}
</script>
<?php
	include 'timecond.php';
/**query all the orders and customer information in limited condition*/	
	$sql_orders = "SELECT o.id,o.cus_id,CONCAT(c.firstname,' ',c.lastname) AS cusname,employee_id,CONCAT(e.firstname,' ',e.lastname) AS empname,Date,Time,status FROM orders as o LEFT JOIN customer as c ON o.cus_id = c.id LEFT JOIN employee as e ON o.employee_id = e.id $condition ORDER BY Date DESC,time DESC";
	$result = $mysql->query($sql_orders);
	while($row_order = $mysql->fetch($result)) {
		$cusname= empty($row_order['cusname']) ? 'Unknown': $row_order['cusname'];
		$empname= empty($row_order['empname']) ? 'Unknown': $row_order['empname'];
?>
<div class='order_block' id='ob<?php echo $row_order[0];?>'>
  <div class='ob_nav' id='obnav<?php echo $row_order[0];?>'>
	<table id="ob_tbl<?php echo $row_order[0];?>">
		<tr>
		<?php
/**count one orders' total price and item number*/
		$sql_order_price = "select sum(f.price * quantity) as order_price, count(*) as num from order_product inner join product_service as f ON order_product.product_id = f.id where order_id = {$row_order['id']}";
			$res=$mysql->query($sql_order_price);
			$row_item=$mysql->fetch($res);
			$num=$row_item['num'];
			echo "<th colspan='2'>$cusname  <samp><small>$empname</small></samp></th>
					<th class='text-right' colspan='2'>".substr($row_order['Date'],5)." ".substr($row_order['Time'],0,5)."</th>";
			?>
		</tr>
		<tr id='ob_tbl_th'>
			<td>Products</td>
			<td>Quantity</td>
			<td>Single</td>
			<td>Total</td>
		</tr>
		<?php
/**find and show detail information of each order*/
		$sql_item_detail = "SELECT Item_id,F.order_id,cus.lastname as lname,Cs.product_name as item_name,Cp.product_name,Quantity,Cs.price as Single_Price,(Cs.price*quantity)as Total_Price,F.product_id from order_product as F JOIN orders as O on F.order_id = O.id JOIN product_service as Cs ON F.product_id = Cs.id JOIN product_service as Cp ON Cp.id = Cs.type_id LEFT JOIN customer as cus ON cus.id = O.cus_id WHERE F.order_id= {$row_order['id']}";
			$result_item_detail = $mysql->query($sql_item_detail);
/**action to create_order to edit order if user need*/
			echo "<form id='formd{$row_order['id']}' method='post' action='index.php?page=create_order'>";
			$showtimes=0;
			while($row_item_detail = $mysql->fetch($result_item_detail)) {
				$showtimes++;
/**if an order have more than 4 items, it should be fold*/
				if ($showtimes<4){
					echo "<tr id='ob_tbl_tb' >
							<td>".$row_item_detail['item_name']." </td>
							<td>".$row_item_detail['Quantity']." </td>
							<td>&#165;".$row_item_detail['Single_Price']." </td>
							<td>&#165;".$row_item_detail['Total_Price']." </td>
						</tr>";
				}else{
					echo "<tr id='ob_tbl_tb1'>
							<td class='obtd$row_order[0]'>".$row_item_detail['item_name']." </td>
							<td class='obtd$row_order[0]'>".$row_item_detail['Quantity']." </td>
							<td class='obtd$row_order[0]'>&#165;".$row_item_detail['Single_Price']." </td>
							<td class='obtd$row_order[0]'>&#165;".$row_item_detail['Total_Price']." </td>
						</tr>";
				}
/**save product_id, quantity, order_id and cus_id in hidden input*/	
				echo "<input type='hidden' name='fd_quan[{$row_item_detail['product_id']}]' value='{$row_item_detail['Quantity']}'/>";
			}
			echo "<input type='hidden' name='od_cus[{$row_order['id']}]' value='{$row_order['cus_id']}'/>
					<input type='hidden' name='od_emp' value='{$row_order['employee_id']}'/>
				</form>";
			/*fill in blank row if the order have less than 3 items*/	
			for($n=$num;$n<3;$n++){
				echo "<tr id='ob_tbl_tb'><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td></tr>";
			}		
			echo "<tr id='ob_tbl_tb'>
					<th colspan='2' id='paid'><span id='paid$row_order[0]'>Paid</span></th>
					<th class='text-right' colspan='2'>{$row_item['order_price']}&nbspRMB</th>
				</tr>";
		?>
	</table>
		<div id='paybtn'>
			<span id="btn2<?php echo $row_order[0];?>">
				<button type="button"  onclick="payOrder('<?php echo $row_order[0];?>')" class='btn btn-success'>Pay</button>
				<button type="button" onclick="alert('<?php echo $row_order['employee_id'];?>')" class='btn btn-warning'>Rate</button>
				<button type='button' name='edit' onclick="submit('<?php echo $row_order[0];?>')"  class='btn btn-primary'>Edit</button>
				<button type='button' onclick="deleteOrder('<?php echo $row_order['id'];?>')" class='btn btn-danger'>Del</button>
				<form method='post' action=''>
					<input id='del<?php echo $row_order['id'];?>' type='submit' name='deloid' value='<?php echo $row_order['id'];?>' style='display:none;'/>
				</form>
				<form method='post' action=''>
					<input id='pay<?php echo $row_order['id'];?>' type='submit' name='payoid' value='<?php echo $row_order['id'];?>' style='display:none;'/>
				</form>
			</span>
			<?php
/**change style if more than 3 row*/
			if($num > 3){	
				echo "<div id='more$row_order[0]' class='morerow' onclick='morebtn($row_order[0],$num)'>
						<a>More</a>
					</div>
					<div id='fold$row_order[0]' class='morerow' style='display:none;' onclick='foldbtn($row_order[0])'>
						<a>Fold</a>
					</div>";
			}
/**paid style*/
			if($row_order['status']==4){
				echo "<script>paidstyle('$row_order[0]')</script>";
			}
			?>
		</div>
</div>
</div>
<?php
	}
/**function of pay order*/
	if(isset($_POST['payoid'])){
		$payId = $_POST['payoid'];
		$sql_pay = "UPDATE orders SET status=4 WHERE id= $payId";
		$mysql->query($sql_pay);
		echo "<script>paidstyle($payId);</script>";
	}
/**function of delete order*/
	if(isset($_POST['deloid'])){
			$delId = $_POST['deloid'];
			echo "<script>document.getElementById('obnav'+$delId).style.display='none';</script>";
			$mysql->query("DELETE FROM orders WHERE id = $delId");
		}
/**if row_item is not empty,row_order must not be empty(no orders).Because it's outside of while loop,so it only can use row_item*/		
	if(empty($row_item)){
		echo "No $unpaidAdj orders for <samp>$timestamp</samp> yet";
	}
	
?>