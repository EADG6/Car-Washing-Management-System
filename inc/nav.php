    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">YiJia Car Washing</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index.php?page=order">Order</a>
                    </li>
                    <li>
                        <a href="index.php?page=addorder">Add Order</a>
                    </li>
                    <li>
                        <a href="index.php?page=customer">Customer</a>
                    </li> 
                    <li>
                        <a href="index.php?page=services">About</a>
                    </li>
				<?php
				    if ($_SESSION['customer_id'] != 0 ){
				?>         
                    <li>
                        <a href="index.php?logout">Logout</a>
                    </li>
                <?php
				    }else{
                        echo "<li><a href='login.php'>Log in</a></li>";
                    }
				?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
	<div class="footwrap">