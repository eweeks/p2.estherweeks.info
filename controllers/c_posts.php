<?php

class posts_controller extends base_controller {

	public function __construct() {
		parent::__construct();
	
		# Make sure user is logged in if they want to use anything in this controller
		if(!$this->user) {
			Router::redirect('/users/login');
		}
	}

/*-------------------------------------------------------------------------------------------------
		Index Function for Posts
-------------------------------------------------------------------------------------------------*/

	public function index() {
	
		# Set up the View
		$this->template->content = View::instance('v_posts_index');
		$this->template->title   = "All Posts";

		# Query
		$q = 'SELECT 
				posts.content,
				posts.created,
				posts.user_id AS post_user_id,
				users_users.user_id AS follower_id,
				users.first_name,
				users.last_name
			FROM posts
			INNER JOIN users_users 
				ON posts.user_id = users_users.user_id_followed
			INNER JOIN users 
				ON posts.user_id = users.user_id
			WHERE users_users.user_id = '.$this->user->user_id;

		# Run the query, store the results in the variable $posts
		$posts = DB::instance(DB_NAME)->select_rows($q);

		# Pass data to the View
		$this->template->content->posts = $posts;

		# Render the View
		echo $this->template;

	}

/*-------------------------------------------------------------------------------------------------
		Add Function for Posts
-------------------------------------------------------------------------------------------------*/
	public function add($error = NULL) {

		# Setup view
		$this->template->content = View::instance('v_posts_add');
		$this->template->title   = "New Post";
		
		# Pass data to the view
		$this->template->content->error = $error;

		# Render template
		echo $this->template;

	}

/*-------------------------------------------------------------------------------------------------
		p_add Function for Posts	**adds posts and checks for errors
-------------------------------------------------------------------------------------------------*/
	public function p_add() {

		# Setup view
		$this->template->content = View::instance('v_posts_posted');
		$this->template->title   = "Post Added";

		foreach($_POST as $key => $value){

			if((empty($value)) || (!$value) || (trim($value) == "") ){
				# Send them back to the login page
				Router::redirect("/posts/add/error");
			}
		}
		
		# Associate this post with this user
		$_POST['user_id']  = $this->user->user_id;

		# Unix timestamp of when this post was created / modified
		$_POST['created']  = Time::now();
		$_POST['modified'] = Time::now();

		# Insert
		# Insert Method Sanitizes
		DB::instance(DB_NAME)->insert('posts', $_POST);

		# Render template
		echo $this->template;

	}
/*-------------------------------------------------------------------------------------------------
		Users Function for Posts  ** Shows list of Users Posts that current user is following
-------------------------------------------------------------------------------------------------*/
	public function users() {

		# Set up the View
		$this->template->content = View::instance("v_posts_users");
		$this->template->title   = "Users";

		# Build the query to get all the users
		$q = "SELECT *
			FROM users";

		# Execute the query to get all the users. 
		# Store the result array in the variable $users
		$users = DB::instance(DB_NAME)->select_rows($q);

		# Build the query to figure out what connections does this user already have? 
		# I.e. who are they following
		$q = "SELECT * 
			FROM users_users
			WHERE user_id = ".$this->user->user_id;

		# Execute this query with the select_array method
		# select_array will return our results in an array and use the "users_id_followed" field as the index.
		# This will come in handy when we get to the view
		# Store our results (an array) in the variable $connections
		$connections = DB::instance(DB_NAME)->select_array($q, 'user_id_followed');

		# Pass data (users and connections) to the view
		$this->template->content->users       = $users;
		$this->template->content->connections = $connections;

		# Render the view
		echo $this->template;
	}
/*-------------------------------------------------------------------------------------------------
		Follow function for Posts    **Allows to follow users
-------------------------------------------------------------------------------------------------*/
	public function follow($user_id_followed) {

		# Prepare the data array to be inserted
		$data = Array(
			"created" => Time::now(),
			"user_id" => $this->user->user_id,
			"user_id_followed" => $user_id_followed
		);

		# Do the insert
		DB::instance(DB_NAME)->insert('users_users', $data);

		# Send them back
		Router::redirect("/posts/users");

	}
/*-------------------------------------------------------------------------------------------------
		Unfollow function for Posts	**Allows un-following of  users
-------------------------------------------------------------------------------------------------*/
	public function unfollow($user_id_followed) {

		# Delete this connection
		$where_condition = 'WHERE user_id = '.$this->user->user_id.' AND user_id_followed = '.$user_id_followed;
		DB::instance(DB_NAME)->delete('users_users', $where_condition);

		# Send them back
		Router::redirect("/posts/users");

	}
/*-------------------------------------------------------------------------------------------------
		Funtcion shows own Posts	
-------------------------------------------------------------------------------------------------*/
	public function edit(){
		# If user is blank, they're not logged in; redirect them to the login page
		if(!$this->user) {
			Router::redirect('/users/login');
		}

		# If they weren't redirected away, continue:
		
		# Setup view
		$this->template->content = View::instance('v_posts_edit');
		$this->template->title   = "Posts of ".$this->user->first_name;

		#query to only show users posts
		$q = "SELECT
				posts.content, 
				posts.created, 
				posts.post_id,
				users.first_name, 
				users.last_name
			FROM posts
			INNER JOIN users
				ON posts.user_id = users.user_id
			WHERE users.user_id =".$this->user->user_id;

		# Execute the query to get all the posts. 
		# Store the result array in the variable $posts
		# Run the query, store the results in the variable $posts
		$posts = DB::instance(DB_NAME)->select_rows($q);

		# Pass data (posts) to the view
		$this->template->content->posts = $posts;

		# Render template
		echo $this->template;
	}
	
/*-------------------------------------------------------------------------------------------------
		Function to delete own posts
-------------------------------------------------------------------------------------------------*/
	public function delete($post_id) {
		$where_condition = 'WHERE post_id = '.$post_id;
		DB::instance(DB_NAME)->delete('posts', $where_condition);
		
		# Send them back
		Router::redirect("/posts/edit");


	}


}