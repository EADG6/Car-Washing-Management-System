<?php
if(isset($_GET['action'])){
	$action = $_GET['action'];
}else{
	$action='info';
}
if($action == 'new'){
/**query customers ID and show new customer form*/
$sql_cusinfo = "SELECT id from customer order by id DESC;";
	$result = $mysql->query($sql_cusinfo); 
	$row = $mysql->fetch($result);
	$newnum = $row[0]+1;		
	echo "
	<form action='submit.php' method='post'>
	<table>
		<th colspan='4'>New Customer</th>
		<tr>
			<td class='bold' class='width-2'>Customer Number</td>
			<td class='width-3'>
				<input type='text' id='cusid' name='cusid' value='$newnum' disabled='disabled'/>
			</td>
		</tr>
		<tr>
			<td class='bold'>First Name<span class='req'> *</span></td>
			<td>
				<input type='text' maxlength='10' name='fname' required/>
			</td>
			<td class='bold'>Last Name</td>
			<td>
				<input type='text' maxlength='10' name='lname'/>
			</td>
		</tr>
		<tr>
			<td class='bold'>Gender</td>
			<td>
				<label>Male:<input type='radio' name='sex' value=1/></label> 
				<label>Female:<input type='radio' name='sex' value=0/></label> 
				<label>Unknown:<input type='radio' name='sex' value=3 checked/></label>
			</td>
			<td class='bold'>Phone Number</td>
			<td>
				<input type='tel' maxlength='20' name='tel'/>
			</td>
		</tr>
		<tr>
			<td class='bold'>Address</td>
			<td>
				<input type='text' maxlength='200' name='address'/>
			</td>
		</tr>
	</table>
	<div class='text-right'>
		<button class='submit' type='primary' name='submit'>Submit</button>
	</div>
	</form>";	
	if(isset($_POST['origCusEdit'])){
			$origCus = explode(',',$_POST['origCusEdit']);
			echo "<script>
					var cusid = document.getElementById('cusid');
					cusid.disabled = false;
					cusid.value = {$origCus[0]};
					cusid.onchange = function(){
						cusid.value = {$origCus[0]};
					};
					document.getElementsByName('fname')[0].value = '{$origCus[1]}';
					document.getElementsByName('lname')[0].value = '{$origCus[2]}';
					document.getElementsByName('tel')[0].value = '{$origCus[3]}';
					document.getElementsByName('address')[0].value = '{$origCus[5]}';
					var gender = document.getElementsByName('sex');
					if({$origCus[4]}==1) gender[0].checked=true;
					if({$origCus[4]}==0) gender[1].checked=true;	
					if({$origCus[4]}==3) gender[2].checked=true;	
				</script>";
	}
}else if($action == 'info'){
/**show all customer's information*/
		$sql_cusinfo = "SELECT * FROM customer;";
		$result = $mysql->query($sql_cusinfo);
		echo "<table class ='table-stripped'>
				<th colspan='10'>Customer Information:</th>
					<tr>
						<td class='bold'>Customer ID</td>
						<td class='bold'>First Name</td>
						<td class='bold'>Last Nmae</td>
						<td class='bold'>Sex</td>
						<td class='bold'>Tel</td>
						<td class='bold'>Address</td>
						<td class='bold'>Balance</td>
						<td class='bold'>Credit</td>
						<td style='width:1%;'></td>
						<td style='width:1%;'></td>
					</tr>";
/**count how much money does each customer paid*/
		while($row = $mysql->fetch($result)) {
		    echo "<tr>";
				$sql_sum="select sum(f.price * quantity) as credit from order_product inner join product_service as f ON order_product.product_id = f.id where order_id in (select id from orders where cus_id = {$row['id']})";
				$res_cre=$mysql->query($sql_sum);
				$row_cre=$mysql->fetch($res_cre);
				switch($row['sex']){
					case 1: $sex='Male';break;
					case 0: $sex='Female';break;
					default: $sex='Unknown';
				}
				$balance=(empty($row['balance']))? 0:$row['balance'];
				$credit=(empty($row_cre['credit']))? 0:$row_cre['credit'];
			echo "	<td>".$row['id']."</td>
					<td>".$row['FirstName']."</td>
					<td>".$row['LastName']."</td>
					<td>".$sex."</td>
					<td>".$row['tel']."</td>
					<td>".$row['address']."</td>
					<td>&#165;$balance</td>
					<td>&#165;$credit</td>";
?>
					<td><samp onclick="firm('Do you want to Edit this Customer?','editCus<?php echo $row['id'];?>')">E</samp></td>
					<td><kbd onclick="firm('Do you want to Delete this Customer?','deleteCus<?php echo $row['id'];?>')">X</kbd></td>
				</tr>
				<form action='index.php?page=customer&action=new' method='post' id='editCus<?php echo $row['id'];?>'>
					<input type='hidden' name='origCusEdit' value='<?php echo $row['id'].','.$row['FirstName'].','.$row['LastName'].','.$row['tel'].','.$row['sex'].','.$row['address'];?>'/>
				</form>
				<form action='' method='post' id='deleteCus<?php echo $row['id'];?>'>
					<input type='hidden' name='origCusDel' value='<?php echo $row['id'];?>'/>
				</form>
<?php	}
		echo "</table>";
/**Delete Customer function*/
		if(isset($_POST['origCusDel'])){
			$sql_delCus = "DELETE FROM customer WHERE id = {$_POST['origCusDel']}";
			echo $sql_delCus;
			$mysql->query($sql_delCus);
			echo "<script>window.location.href='index.php?page=customer&action=info';</script>";
		}
}	
?>
<script>
	function firm(text,formid){  
		if(confirm(text)){
			document.getElementById(formid).submit();
		}else{
			return false;
		}
	}
</script>
