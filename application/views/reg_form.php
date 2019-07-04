<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Register</title>

  <!-- Custom fonts for this template-->
  <link href="<?php echo base_url('vendor/fontawesome-free/css/all.min.css');?>" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template-->
  <link href="<?php echo base_url('css/sb-admin.css');?>" rel="stylesheet">

</head>

<body class="bg-dark">

  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Register</div>
      <div class="card-body">
		<form method="POST" action="<?php echo base_url().'user/register'; ?>">
    <div style ='color:green;' class="form-group">
      <?php echo $this->session->flashdata('reg_succ');?>
    </div>
    <div style ='color:red;' class="form-group">
      <?php echo $this->session->flashdata('reg_dang');?>
    </div>
		<div class="form-group">
		  <div class="form-label-group">
				<input type="text" class="form-control" id="name" name="name" value="<?php echo set_value('name'); ?>" required="required" autofocus="autofocus">
				<label for="email">Name</label>
		  </div>
		</div>
		  <div class="form-group">
		  	<div class="form-label-group">
				  <input type="text" class="form-control" id="email" name="email" value="<?php echo set_value('email'); ?>" required="required" autofocus="autofocus">
				  <label for="email">Email</label>
			  </div>
		  </div>
		  <div class="form-group">
		  	<div class="form-label-group">
				  <input type="password" class="form-control" id="password" name="password" value="<?php echo set_value('password'); ?>" required="required" autofocus="autofocus">
				  <label for="password">Password</label>
			  </div>
		  </div>
		  <div class="form-group">
		  	<div class="form-label-group">
				  <input type="password" class="form-control" id="password_confirm" name="password_confirm" value="<?php echo set_value('password_confirm'); ?>" required="required" autofocus="autofocus">
				  <label for="password_confirm">Confirm Password</label>
			  </div>
		  </div>
        <div class="form-group">
          <?php echo $this->recaptcha->render(); ?>
        </div>
        <div class="form-group">
          <a href="<?php echo site_url('login');?>">Login</a>
        </div>
        <div class="form-group">
          <button class="btn btn-primary btn-block" type="submit">Register</button>
        </div>
    </form>
      </div>
      </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo base_url('vendor/jquery/jquery.min.js');?>"></script>
  <script src="<?php echo base_url('vendor/bootstrap/js/bootstrap.bundle.min.js');?>"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?php echo base_url('vendor/jquery-easing/jquery.easing.min.js');?>"></script>

</body>

</html>