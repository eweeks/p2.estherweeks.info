<?php
class users_controller extends base_controller {

    public function __construct() {
        parent::__construct();
        //echo "users_controller construct called<br><br>";
    } 

    public function index() {

    }

    public function signup() {

        # Setup view
            $this->template->content = View::instance('v_users_signup');
            $this->template->title   = "Sign Up";

        # Render template
            echo $this->template;

    }

    public function p_signup() {
			
		$this->template->content = View::instance('v_users_firstlogin');
    	$this->template->title   = "Welcome to Bleats";
    	
    	# More data we want stored with the user
    	$_POST['created']  = Time::now();
    	$_POST['modified'] = Time::now();
    	
    	
   		# Encrypt the password  
   		$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);            

    	# Create an encrypted token via their email address and a random string
    	$_POST['token'] = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string());

   		# Insert this user into the database
		$user_id = DB::instance(DB_NAME)->insert('users', $_POST);

        # Render template
        echo $this->template;


    }

    public function login($error = NULL) {
        # Setup view
        $this->template->content = View::instance('v_users_login');
        $this->template->title   = "Login";
        
        # Pass data to the view
    	$this->template->content->error = $error;

    	# Render template
        echo $this->template;
    }
    
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

        /* 
        Store this token in a cookie using setcookie()
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
    
    
	public function profile() {

    # If user is blank, they're not logged in; redirect them to the login page
    if(!$this->user) {
        Router::redirect('/users/login');
    }

    # If they weren't redirected away, continue:

    # Setup view
    $this->template->content = View::instance('v_users_profile');
    $this->template->title   = "Profile of".$this->user->first_name;

    
    
    #query to only show users profile
    $q ="SELECT 
    		profile . * , 
    		users.first_name, 
    		users.last_name
		FROM profile
		INNER JOIN users 
			ON profile.user_id = users.user_id
		WHERE users.user_id =".$this->user->user_id;
		
	 $profile = DB::instance(DB_NAME)->select_rows($q);
	 
	# Pass data (profile) to the view
    $this->template->content->profile = $profile;
    

    # Render template
    echo $this->template;
	
	}
	
	public function profileedit(){
		$this->template->content = View::instance('v_users_profileedit');
    	$this->template->title   = "Edit Profile";
    	# Render template
        echo $this->template;
	}
	
	public function p_profile(){
		
		/*$q = "UPDATE users 
			 		SET 
						first_name = '".$_POST['first_name']."',
						last_name = '".$_POST['last_name']."'
        		WHERE user_id = ".$this->user->user_id;	*/
		/*DB::instance(DB_NAME)->update("users", $data, "WHERE user_id = 56");*/
		$where_condition = 'WHERE user_id = '.$this->user->user_id;
		$name = $_POST['first_name'];
    	DB::instance(DB_NAME)->update("users", $_POST, 'WHERE user_id = '.$this->user->user_id);
		Router::redirect("/users/profile");
	/*	# Sanitize the user entered data to prevent any funny-business (re: SQL Injection Attacks)
    	$_POST = DB::instance(DB_NAME)->sanitize($_POST);
	
	    $q = "SELECT user_id 
        	FROM profile
        	WHERE user_id = ".$this->user->user_id;

    	$present = DB::instance(DB_NAME)->select_field($q);

    	# No match
    	if(!$present) {

	     $q = "INSERT INTO profile 
	    	(created, modified, user_id, location, about)
			VALUES('".Time::now()."', 
					'".Time::now()."', 
					'".$this->user->user_id."', 
					'".$_POST['location']."', 
					'".$_POST['about']."')";
        $profile = DB::instance(DB_NAME)->select_field($q);
			echo "Updated";
        
		} else {

			$q = "UPDATE profile 
			 		SET 
						location =  '".$_POST['location']."',
						about =  '".$_POST['about']."',
						modified ='".Time::now()."'
        		WHERE user_id = ".$this->user->user_id;	
        $profile = DB::instance(DB_NAME)->select_field($q);
	    echo "Updated";
		}
		*/
	
	}
	
		public function resetp(){
			
			# Setup view
    		$this->template->content = View::instance('v_users_resetp');
    		$this->template->title   = "Reset";
			
			# Render template
   			echo $this->template;
		}
	
		public function p_reset() {
		
		# Encrypt the password  
   		$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']); 
   		/*$q = "UPDATE users 
			 	SET 
					password='".$new."'
        		WHERE user_id = ".$this->user->user_id;	*/
		
		DB::instance(DB_NAME)->update("users", $_POST, 'WHERE user_id = '.$this->user->user_id);
   		
   		# Send them back to the main index.
        Router::redirect('/users/login');
   		
		
		
		}
	

} # end of the class