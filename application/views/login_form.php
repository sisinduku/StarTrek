<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title><?php echo $pageTitle; ?></title>
		<meta name="generator" content="Bootply" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link href="<?php echo base_url("/assets/css/bootstrap.min.css");?>" rel="stylesheet">
		<!--[if lt IE 9]>
			<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<link href="<?php echo base_url("/assets/css/loginstyles.css");?>" rel="stylesheet">
	</head>
	<body>
		<!--login modal-->
		<div id="loginModal" class="modal show" tabindex="-1" role="dialog" aria-hidden="true">
		  <div class="modal-dialog">
		  <div class="modal-content">
		      <div class="modal-header">
		          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		          <h1 class="text-center">Login</h1>
		      </div>
		      <div class="modal-body">
		          <form class="form col-md-12 center-block" method="POST" action="<?php echo site_url("login/login");?>">
		          	<input type="hidden" name="location" value="<?php if(isset($location)) echo htmlspecialchars($location); ?>" readonly>
		            <div class="form-group">
		              <input type="text" name="username" class="form-control input-lg" placeholder="Username" required>
		            </div>
		            <div class="form-group">
		              <input type="password" name="password" class="form-control input-lg" placeholder="Password" required>
		            </div>
		            <div class="form-group">
		              <button class="btn btn-primary btn-lg btn-block">Sign In</button>
		            </div>
		          </form>
		      </div>
		      <div class="modal-footer">
		          <div class="col-md-12">
		          <?php
		          	$errString = validation_errors();
					if (!empty($errString) || !empty($errors)) {
						echo "<div class= \"alert alert-danger\"><ol type='1'>";
							if(!empty($errString))  echo validation_errors("<li>", "</li>");
							if(!empty($errors)) echo "<li>".$errors."</li>";
						echo "</ol></div>";
					}
				  ?>
				  </div>	
		      </div>
		  </div>
		  </div>
		</div>
	<!-- script references -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
		<script src="<?php echo base_url("/assets/js/login.min.js");?>"></script>
	</body>
</html>