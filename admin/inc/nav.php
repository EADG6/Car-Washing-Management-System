		<center class="tab_out">
            <table class="table-stripped">
		        <tr><td class='text-centered' id='tab'>
				<nav>
					<div class="left-menu">
						<a href="index.php?page=create_order"><button class='btn-danger' type="button">Create order</button></a>
						<a href="index.php?page=current_orders"><button type="button">Current orders</button></a>
					</div>
					<div class="right-menu">
						<div class="nav dropdown">
						    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Menu
						    <span class="caret"></span></button>
						    <ul class="dropdown-menu">
						      <li class="dropdown-header">Overviews</li>
							  <li><a href="index.php?page=product&action=sold">Product sold</a></li>
							  <li><a href="index.php?page=product&action=weekly">Weekly Report</a></li>
						      <li class="divider"></li>
						      <li class="dropdown-header">Customer</li>
						      <li><a href="index.php?page=customer&action=info">Customer info</a></li>
							  <li><a href="index.php?page=customer&action=new">New customer</a></li>
							  <li><a href="index.php?page=recharge">Recharge</a></li>
						      <li class="divider"></li>
							  <li class="dropdown-header">Product</li>							  
							  <li><a href="index.php?page=product&action=detail">Product items</a></li>
							  <li><a href="index.php?page=product&action=cata">Product categories</a></li>
							  <li><a href="index.php?page=product&action=new">New Product</a></li>
						    </ul>
						  </div>
					</div>
				</nav>
				</tr></td>      
		    </table>
		</center>
		<div class='col-xs-1'>
			<div class="left_tab">
				<a href=#><img src='../static/img/icon/up.png'/></a><br/>
				<?php
				if(!isset($_GET['action'])){
					$_GET['action']='';
				}
				if ($page == 'create_order' || ($_GET['action']=='weekly') || $_GET['action']=='sold') {
					$sql_fcata = "SELECT product_name FROM product_service WHERE price IS NULL ORDER BY type_id";
					$res_fcata = $mysql->query($sql_fcata);
					while($row_fcata = $mysql->fetch($res_fcata)){
						echo "<a href=#".$row_fcata['product_name'].">".$row_fcata['product_name']."</a><br/>";
					}
				}
				?>
				<a href='#bottom'><img src='../static/img/icon/down.png'/></a>
			</div>
		</div>
		<div class='col-xs-10'>
           <dl class="container">
				<dd class="row clearfix">