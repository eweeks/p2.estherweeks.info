<h1><?php if($user) echo ''.$user->first_name; ?>'s Posts</h1>

<?php foreach($posts as $post): ?>

	<article>

		<h2><?=$post['first_name']?> <?=$post['last_name']?> posted:</h2>
		<p><?=$post['content']?></p>
		
		<time datetime="<?=Time::display($post['created'],'Y-m-d G:i')?>">
			<?=Time::display($post['created'])?>
		</time>
		<a href='/posts/delete/<?=$post['post_id']?>' title="Delete Post">Delete</a>
	
	</article>

<?php endforeach; ?>

