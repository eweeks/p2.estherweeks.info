<!DOCTYPE html>
<html>
<head>
	<title><?php if(isset($title)) echo $title; ?></title>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
	<link href="/css/bootstrap.min.css" rel="stylesheet" />
	<script src="/js/respond.js"></script>
	<!-- Controller Specific JS/CSS -->
	<?php if(isset($client_files_head)) echo $client_files_head; ?>
	
</head>

<body>	
	<div id='menu'>


        <!-- Menu for users who are logged in -->
        <?php if($user): ?>

            <ul class="nav nav-tabs">
  				<li><a href="/">Home</a></li>
 				<li><a href="/users/profile">Profile</a></li>
  				<li><a href="/users/logout">Logout</a></li>
  				<li><a href="/posts">Posts</a></li>
  				<li><a href="/posts/users">Users</a></li>
  				<li><a href="/posts/add">New Post</a></li>
  				<li><a href="/posts/edit">Your Posts</a></li>
			</ul>

            
            
            

        <!-- Menu options for users who are not logged in -->
        <?php else: ?>

            
            <ul class="nav nav-tabs">
  				<li><a href="/">Home</a></li>
 				<li><a href="/users/signup">Sign up</a></li>
  				<li><a href="/users/login">Log in</a></li>
			</ul>

        <?php endif; ?>
	
    </div>
    <div class="container"> <!--to hold it all, for bootstrap-->
    

    <br>

	<?php if(isset($content)) echo $content; ?>

	<?php if(isset($client_files_body)) echo $client_files_body; ?>

	</div>
	
<!-- javascript here so that the important stuff will load first.. -->
	<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
	<script src="js/bootstrap.min.js"></script> <!--Must be second, this refers to jquery -->

</body>
</html>