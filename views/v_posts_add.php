<div class="row">
	<div class="col-md-12 col-sm-12">
		<h2 >New Post</h2>
		<form method='POST' action='/posts/p_add' class="form-horizontal" role="form">
			<!--	New Post Input	-->
			<div class="form-group">
				<label class="col-sm-2 control-label">Enter Your Post</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" id="post" placeholder="New Post" name='content' title="New Post">
				</div>
			</div>
			<!--	Submit New Post	-->
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-default" title="New Post">New Post</button>
				</div>
			</div>
		</form>
	</div><!-- end class col-->
</div><!--end class row -->

	<?php if(isset($error)): ?>
		<div class='error'>
			<p>You must have something to say...</p>
			<p>Please enter some text</p>
		</div>
	<?php endif; ?>
	
	
