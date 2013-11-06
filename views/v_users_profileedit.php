<div class="row">
	<div class="col-md-12 col-sm-12">
		<h2 >Edit Profile</h2>
		<form method='POST' action='/users/p_profile' class="form-horizontal" role="form" >
			
			<!--	First Name Input	-->
			<div class="form-group">
				<label class="col-sm-2 control-label">First Name</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="inputFirstName" placeholder="FirstName" name='first_name' title="First Name" >
				</div>
			</div>
			
			<!--	Last Name Input	-->
			<div class="form-group">
				<label class="col-sm-2 control-label">Last Name</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="LastName" placeholder="LastName" name='last_name' title="Last Name">
				</div>
			</div>
			
			<!--	Location Input	-->
			<div class="form-group">
				<label class="col-sm-2 control-label">Location</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="location" placeholder="Location" name='location' title="Location">
				</div>
			</div>
			
			<!--	About Input	-->
			<div class="form-group">
				<label class="col-sm-2 control-label">About</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="about" placeholder="About" name='about' title="About You">
				</div>
			</div>
			
			<!--	Update Profile or Back to Profile	-->
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-default" title="Update You Profile">Update!</button>
					<p><a href="/users/profile" title="Back to Profile">Back to Profile</a></p>
				</div>
			</div>
		</form>
	</div><!-- end class col-->
</div><!--end class row -->

<?php if(isset($error)): ?>
	<div class='error'>
		<p>Please fill in all fields</p>
	</div>
	<br>
<?php endif; ?>
