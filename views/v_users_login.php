<div class="row">
	<div class="col-md-12 col-sm-12">
		<h2 >Log-in</h2>
		<form method='POST' action='/users/p_login' class="form-horizontal" role="form">
		 	<div class="form-group">
    			<label class="col-sm-2 control-label">Email</label>
    			<div class="col-sm-10">
     				<input type="text" class="form-control" id="email" placeholder="Email" name='email'>
    			</div>
  			</div>
  			<div class="form-group">
    			<label class="col-sm-2 control-label">Password</label>
    			<div class="col-sm-10">
      				<input type="password" class="form-control" id="Password" placeholder="Password" name='password'>
    			</div>
  			</div>  

  			<div class="form-group">
    			<div class="col-sm-offset-2 col-sm-10">
     	 			<button type="submit" class="btn btn-default">Log in!</button>
    			</div>
  			</div>
		</form>
	</div><!-- end class col-->
</div><!--end class row -->    

    <br><br>

	
    <?php if(isset($error)): ?>
        <div class='error'>
            Login failed. Please double check your email and password.
        </div>
        <br>
    <?php endif; ?>


</form>
