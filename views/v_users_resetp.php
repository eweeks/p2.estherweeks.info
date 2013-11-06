<div class="row">
	<div class="col-md-12 col-sm-12">
		<h2 >New Password</h2>
		<form method='POST' action='/users/p_reset' class="form-horizontal" role="form">
			<!--	Email Input	-->
			<div class="form-group">
				<label class="col-sm-2 control-label">Reset Password</label>
				<div class="col-sm-2">
					<input type="password" class="form-control" id="password" placeholder="update password" name='password' title="New Password">
				</div>
			</div>
			<!--	Submit New Password	-->
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-default" title="Reset Your Password">Reset Password</button>
				</div>
			</div>
		</form>
	</div><!-- end class col-->
</div><!--end class row -->

<?php if(isset($error)): ?>
	<div class='error'>
		<p>Fields must be set</p>
	</div>
	<br>
<?php endif; ?>

<p><a href="/users/profile" title="Back to Profile">Back to Profile</a></p>
