<div class="row">
	<div class="col-md-12 col-sm-12">
		<h2 >Edit Profile</h2>
		<form method='POST' action='/users/p_profile' class="form-horizontal" role="form" >
 			 <div class="form-group">
    			<label class="col-sm-2 control-label">First Name</label>
   				<div class="col-sm-10">
      				<input type="text" class="form-control" id="inputFirstName" placeholder="FirstName" name='first_name' >
   				</div>
  			</div>
  			<div class="form-group">
    			<label class="col-sm-2 control-label">Last Name</label>
    			<div class="col-sm-10">
     		 		<input type="text" class="form-control" id="LastName" placeholder="LastName" name='last_name'>
    			</div>
  			</div>
  			<div class="form-group">
    			<label class="col-sm-2 control-label">Location</label>
    			<div class="col-sm-10">
     				<input type="text" class="form-control" id="location" placeholder="Location" name='location'>
    			</div>
  			</div>
  		
  			<div class="form-group">
    			<label class="col-sm-2 control-label">About</label>
    			<div class="col-sm-10">
      				<input type="about" class="form-control" id="about" placeholder="About" name='about'>
    			</div>
  			</div>

  			<div class="form-group">
    			<div class="col-sm-offset-2 col-sm-10">
     	 			<button type="submit" class="btn btn-default">Up date!</button>
    			</div>
  			</div>
		</form>
	</div><!-- end class col-->
</div><!--end class row -->

    <?php if(isset($error)): ?>
        <div class='error'>
            Please fill in all fields
        </div>
        <br>
    <?php endif; ?>
