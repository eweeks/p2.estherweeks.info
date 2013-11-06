<h1>This is the profile of <?=$user->first_name?></h1>


<article>

	<p>First Name: <?=$user->first_name?></p>
	<p>Last Name: <?=$user->last_name?></p>

	<p>Location: <?=$user->location?></p>
	<p>About: <?=$user->about?></p>

</article>

<p><a href="/users/profileedit" title="Edit Profile">Edit Profile</a></p>
<p><a href="/users/resetp" title="Change Password">Change Password </a></p>
