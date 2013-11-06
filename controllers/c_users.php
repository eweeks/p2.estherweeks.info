<?php

class users_controller extends base_controller {

	public function __construct() {
		parent::__construct();
	}

/*-------------------------------------------------------------------------------------------------
		Index Function for Users
-------------------------------------------------------------------------------------------------*/
	public function index() {
		if(!$this->user) {
			Router::redirect('/users/login');
		}else{
			Router::redirect('/users/profile');
			
		}
	}
	
/*-------------------------------------------------------------------------------------------------
		Signup Function for Users
-------------------------------------------------------------------------------------------------*/
	public function signup($error = NULL) {
		
		# Setup view
		$this->template->content = View::instance('v_users_signup');
		$this->template->title   = "Sign Up";

		# Pass data to the view
		$this->template->content->error = $error;

		# Render template
		echo $this->template;

	}
/*-------------------------------------------------------------------------------------------------
		p_signup Function	**Checks for errors and signs up user
-------------------------------------------------------------------------------------------------*/
	public function p_signup() {
			
		$this->template->content = View::instance('v_users_firstlogin');
		$this->template->title   = "Welcome to Bleats";
	
		foreach($_POST as $key => $value){
			if((empty($value)) || (!$value) || (trim($value) == "") ){
				# Send them back to the login page
				Router::redirect("/users/signup/error");
			}
		
		}
	
		# More data we want stored with the user
		$_POST['created']  = Time::now();
		$_POST['modified'] = Time::now();
	
		# Encrypt the password  
		$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);

		# Create an encrypted token via their email address and a random string
		$_POST['token'] = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string());
		$email=$_POST['email'];

		if(!$this->userObj->confirm_unique_email($email) ) {
			# Send them back to the login page
			Router::redirect("/users/signup/error");
		}else{
			# Insert this user into the database
			$user_id = DB::instance(DB_NAME)->insert('users', $_POST);
			
			# Render template
			echo $this->template;
		}

	}
/*-------------------------------------------------------------------------------------------------
		Login Function for Users
-------------------------------------------------------------------------------------------------*/
	public function login($error = NULL) {
		# Setup view
		$this->template->content = View::instance('v_users_login');
		$this->template->title   = "Login";

		# Pass data to the view
		$this->template->content->error = $error;

		# Render template
		echo $this->template;
	}
/*-------------------------------------------------------------------------------------------------
		p_login function	**sanitizes data, checks for errors, redirects if all is okay
-------------------------------------------------------------------------------------------------*/
	public function p_login() {

		# Sanitize the user entered data to prevent any funny-business (re: SQL Injection Attacks)
		$_POST = DB::instance(DB_NAME)->sanitize($_POST);

		# Hash submitted password so we can compare it against one in the db
		$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);

		# Search the db for this email and password
		# Retrieve the token if it's available
		$q = "SELECT token 
			FROM users 
			WHERE email = '".$_POST['email']."' 
			AND password = '".$_POST['password']."'";

		$token = DB::instance(DB_NAME)->select_field($q);

		# If we didn't find a matching token in the database, it means login failed
		if(!$token) {

			# Send them back to the login page
			Router::redirect("/users/login/error");

		# But if we did, login succeeded! 
		} else {
		
		/*  Store this token in a cookie using setcookie()
		Important Note: *Nothing* else can echo to the page before setcookie is called
		Not even one single white space.
		param 1 = name of the cookie
		param 2 = the value of the cookie
		param 3 = when to expire
		param 4 = the path of the cooke (a single forward slash sets it for the entire domain)
		*/
			setcookie("token", $token, strtotime('+1 year'), '/');
			# Send them to the main page - or whever you want them to go
			Router::redirect("/");
		}
	}
/*-------------------------------------------------------------------------------------------------
		Log Out Function for User
-------------------------------------------------------------------------------------------------*/
	public function logout() {
		# Generate and save a new token for next login
		$new_token = sha1(TOKEN_SALT.$this->user->email.Utils::generate_random_string() );

		# Create the data array we'll use with the update method
		# In this case, we're only updating one field, so our array only has one entry
		$data = Array("token" => $new_token);

		# Do the update
		DB::instance(DB_NAME)->update("users", $data, "WHERE token = '".$this->user->token."'");

		# Delete their token cookie by setting it to a date in the past - effectively logging them out
		setcookie("token", "", strtotime('-1 year'), '/');

		# Send them back to the main index.
		Router::redirect("/");
	}
/*-------------------------------------------------------------------------------------------------
		Profile Function for User
-------------------------------------------------------------------------------------------------*/
	public function profile() {
		# If user is blank, they're not logged in; redirect them to the login page
		if(!$this->user) {
			Router::redirect('/users/login');
		}
		
		# If they weren't redirected away, continue:
		
		# Setup view
		$this->template->content = View::instance('v_users_profile');
		$this->template->title   = "Profile of ".$this->user->first_name;

		# Pass data (profile) to the view
		$this->template->content->profile = $profile;

		# Render template
		echo $this->template;
	}
/*-------------------------------------------------------------------------------------------------
		Edit Profile function for Users
-------------------------------------------------------------------------------------------------*/
	public function profileedit($error = NULL){
		$this->template->content = View::instance('v_users_profileedit');
		$this->template->title   = "Edit Profile";

		#error
		$this->template->content->error = $error;

		# Render template
		echo $this->template;
	}
/*-------------------------------------------------------------------------------------------------
		p_profile function for Users	**Checks for errors, updates profile
-------------------------------------------------------------------------------------------------*/
	public function p_profile( ){
		foreach($_POST as $key => $value) { 
			#if blank, error
			if((empty($value)) || (!$value) || (trim($value) == "") ){
				Router::redirect("/users/profileedit/error");
			}
		}
		
		$where_condition = 'WHERE user_id = '.$this->user->user_id;
		
		#update user table
		DB::instance(DB_NAME)->update("users", $_POST, 'WHERE user_id = '.$this->user->user_id);
		Router::redirect("/users/profile");

	}
/*-------------------------------------------------------------------------------------------------
		Reset Password Function for Users
-------------------------------------------------------------------------------------------------*/
	public function resetp($error = NULL){

		# Setup view
		$this->template->content = View::instance('v_users_resetp');
		$this->template->title   = "Reset";
		
		# Pass data to the view
		$this->template->content->error = $error;

		# Render template
		echo $this->template;
	}
/*-------------------------------------------------------------------------------------------------
		p_reset function for Users	**checks for errors, and resets password
-------------------------------------------------------------------------------------------------*/
	public function p_reset() {

		foreach($_POST as $key => $value){
			if((empty($value)) || (!$value) || (trim($value) == "") ){
				# Send them back to the login page
				Router::redirect("/users/resetp/error");
			}
		}	
		
		# Encrypt the password  
		$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']); 

		DB::instance(DB_NAME)->update("users", $_POST, 'WHERE user_id = '.$this->user->user_id);

		# Send them back to the main index.
		Router::redirect('/users/login');

	}

} # end of the class