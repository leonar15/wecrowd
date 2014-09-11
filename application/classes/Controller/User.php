<?php defined('SYSPATH') or die('No direct script access.');

class Controller_User extends Controller_Template {

	public function action_index() {
		if (Auth::instance()->logged_in()){
			$user = Auth::instance()->get_user();
			$campaign = ORM::factory('Campaign')->where('email', '=', $user->email)->find();
			$this->template->content = View::factory('user/account');
			if (!($campaign->hasAccessToken())) {
				$this->template->content->wepay = "<b>Please confirm your account to manage your money: <p><a class='wepay-widget-button wepay-blue' href=" . URL::base() . "wepayapi>Click here to receive confirmation email!</a>";
				$this->template->content->token = false;
			} else {
				$balances = Controller_Wepayapi::get_balance($campaign);
				$this->template->content->balance = number_format($balances, 2);
				$this->template->content->wepay = '';
				$this->template->content->token = true;
			}
			$this->template->content->state = $campaign->state;
			$this->template->content->first_name = $campaign->first_name;
			$this->template->content->last_name = $campaign->last_name;
			$this->template->content->email = $campaign->email;
			$this->template->content->campaign_name = $campaign->campaign_name;
			$this->template->content->description = $campaign->description;
			$this->template->content->default_donation = number_format($campaign->default_donation,2);
			$this->template->content->edit = true;
			$this->template->content->wepay_link = 'https://stage.wepay.com/account/' . $campaign->wepay_account_id;
			$this->template->content->account_id = Request::current()->param('id');

		}
		else {
			$this->template->content = View::factory('welcome/index');
		}

		$this->template->content->base = URL::base($this->request);
	}

	public function action_add_admin() {
		if (Auth::instance()->logged_in()){
			$user = Auth::instance()->get_user();
			if ($user->login_role == 'admin') {
				$this->template->content = View::factory('user/add_admin');
			}
			else {
				$this->template->content = "You do not have access privileges to this page!";
			}
		}
		else {
			$this->template->content = "You are not logged in!";
		}
	}

	public function action_complete_admin_registration() {

        $validation = Validation::factory($this->request->post())
            ->rule('first_name', 'not_empty')
            ->rule('last_name', 'not_empty')
            ->rule('password', 'not_empty')
            ->rule('password', 'min_length', array(':value', 6))
            ->rule('email', 'not_empty')
            ->rule('email', 'email')
            ->rule('default_donation', 'numeric')
            ->rule('default_donation', 'not_empty')
            ->rule('campaign_name', 'not_empty');

        // Validation check
        if (!$validation->check()) {
            $errors = $validation->errors('user');
			$this->template->content = "Your registration was not valid!";
            return;
        }

        // Create User
        $user = ORM::factory('User');
		$user->username = $_POST['first_name'];
		$user->email = $_POST['email'];
		$user->password = $_POST['password'];
		$user->login_role = 'admin';

        try {
            $user->save();
        } catch (ORM_Validation_Exception $e) {
            $this->template->content = "There was a problem creating your user: " . var_dump($e->errors());
            return;
        }

        // Create Campaign
		$campaign = ORM::factory('Campaign');
		$campaign->first_name = $_POST['first_name'];
		$campaign->last_name = $_POST['last_name'];
		$campaign->email = $_POST['email'];
		$campaign->campaign_name = $_POST['campaign_name'];
		$campaign->description = $_POST['description'];
		$campaign->default_donation = $_POST['default_donation'];
		$campaign->account_type = $_POST['account_type'];

        // Add login role
        $user->add('roles', ORM::factory('Role', array('name' => 'login')));

        try {
            $campaign->save();
        } catch (ORM_Validation_Exception $e) {
            $this->template->content = "There was a problem creating your campaign: " . var_dump($e->errors());
        }

		$success = Auth::instance()->login($_POST['email'], $_POST['password']);

		if ($success) {
			//$this->template->content=$_POST['demo'];
			//HTTP::redirect('wepayapi');
			HTTP::redirect('wepayapi?demo=' . $_POST['demo']);
		} else{
			$this->template->content = "There was an error!";
		}
	}

	public function action_account() {
		$id = Request::current()->param('id');
		if (!isset($id)) {
			HTTP::redirect('/');
		}
		$campaign = ORM::factory('Campaign')->where('id', '=', $id)->find();
		$this->template->content = View::factory('user/account');

		if (Auth::instance()->logged_in()) {
			$user = Auth::instance()->get_user();
			if ($campaign->email == $user->email || $user->login_role == 'admin') {
				$this->template->content->edit = true;
				if (!($campaign->hasAccessToken())) {
					$this->template->content->wepay = "<b>Please confirm account to manage your money: <p><a class='wepay-widget-button wepay-blue' href=" . URL::base() . "wepayapi>Click here to create your WeCrowd account</a>";
					$this->template->content->token = false;
				} else {
					$balances = Controller_Wepayapi::get_balance($campaign);
					$this->template->content->token = true;
					$this->template->content->balance = number_format($balances, 2);
					$this->template->content->wepay = '';
					$this->template->content->checkouts = Controller_Wepayapi::get_checkouts($campaign);
				}
			}
			else {
				$this->template->content->edit = false;
				if ($campaign->hasAccountId()) {
					$this->template->content->wepay = "<a href=" . URL::base() . "user/create_credit_card/".$id." class='btn btn-danger btn-large' id='buy-now-button'>Donate to ".$campaign->campaign_name." Now!</a>";
					$this->template->content->token = true;
				} else {
					$this->template->content->wepay = '';
					$this->template->content->token = false;
				}
			}
		} 
		else {
			$this->template->content->edit = false;
			if ($campaign->hasAccountId()) {
				$this->template->content->wepay = "<a href=" . URL::base() . "user/create_credit_card/".$id." class='btn btn-danger btn-large' id='buy-now-button'>Donate to ".$campaign->campaign_name." Now!</a>";
				$this->template->content->token = true;
			} else {
				$this->template->content->wepay = "";
				$this->template->content->token = false;
			}
		}
		$this->template->content->state = $campaign->state;
		$this->template->content->first_name = $campaign->first_name;
		$this->template->content->last_name = $campaign->last_name;		
		$this->template->content->email = $campaign->email;
		$this->template->content->description = $campaign->description;
		$this->template->content->campaign_name = $campaign->campaign_name;
		$this->template->content->default_donation = number_format($campaign->default_donation,2);
		$this->template->content->base = URL::base($this->request);
		$this->template->content->wepay_link = 'https://stage.wepay.com/account/' . $campaign->wepay_account_id;
		$this->template->content->account_id = Request::current()->param('id');
	}

	public function action_account_summary() {
		if (Auth::instance()->logged_in()){
			$user = Auth::instance()->get_user();
			$campaign = ORM::factory('Campaign')->where('email', '=', $user->email)->find();
			HTTP::redirect(URL::base() . 'user/account/' . $campaign->id);
		} else {
			$this->template->content = "Not logged in!";
		}
	}

	public function action_create_credit_card(){
		$this->template->content = View::factory('user/create_credit_card');
	}

	public function action_charge_cc() {

		$credit_card_id = $_POST['credit_card_id'];
		$id = $_POST['account_id'];		
       	$campaign = ORM::factory('Campaign')->where('id', '=', $id)->find();
       	$redirect = URL::base() . '/user/payment_success?account_id=' . $id;
       	$code = 302;

		try {
            Controller_Wepayapi::create_checkout($credit_card_id, $campaign);
            HTTP::redirect($redirect, $code);
        } catch (WePayPermissionException $e) {
            $this->template->content = "There was an error: " . $e->getMessage();
            return;
        }
    }

    public function action_payment_success() { 
    	$id = $_GET['account_id'];
    	$campaign = ORM::factory('Campaign')->where('id', '=', $id)->find();

        $this->template->content = View::factory('user/charge_cc');
		$this->template->content->name = $campaign->first_name;
		$this->template->content->email = $campaign->email;
		$this->template->content->description = $campaign->description;
		$this->template->content->campaign_name = $campaign->campaign_name;
		$this->template->content->default_donation = number_format($campaign->default_donation,2);
	}


	public function action_register(){
		$this->template->content = View::factory('user/register');
		try {
			$this->template->content->demo = $_GET['demo'];
		} catch (Exception $e) {
			$this->template->content->demo = false;
		}
	}

	public function action_manage() {
		if (Auth::instance()->logged_in()){
			//$this->template->content->demo = $_GET['demo'];
			$user = Auth::instance()->get_user();
	        $campaign = ORM::factory('Campaign')->where('email', '=', $user->email)->find();
	        try  {
	        	$manage_uri = Controller_Wepayapi::create_manage($campaign->wepay_account_id);
	        } catch (WePayPermissionException $e) {
	        	$this->template->content = "There was an error" . $e->getMessage();
	        	return;
	        }
	        $this->template->content = View::factory('user/manage');
	        $this->template->content->manage_uri = $manage_uri;
	    } else {
	    	$this->template->content = "Error, you are not logged in!";
	    }
     } 

	public function action_complete_registration() {

        $validation = Validation::factory($this->request->post())
            ->rule('first_name', 'not_empty')
            ->rule('last_name', 'not_empty')
            ->rule('password', 'not_empty')
            ->rule('password', 'min_length', array(':value', 6))
            ->rule('email', 'not_empty')
            ->rule('email', 'email')
            ->rule('default_donation', 'numeric')
            ->rule('default_donation', 'not_empty')
            ->rule('campaign_name', 'not_empty');

        // Validation check
        if (!$validation->check()) {
            $errors = $validation->errors('user');
			$this->template->content = "Your registration was not valid!";
            return;
        }

        // Create User
        $user = ORM::factory('User');
		$user->username = $_POST['first_name'];
		$user->email = $_POST['email'];
		$user->password = $_POST['password'];

        try {
            $user->save();
        } catch (ORM_Validation_Exception $e) {
            $this->template->content = "There was a problem creating your user: " . var_dump($e->errors());
            return;
        }

        // Create Campaign
		$campaign = ORM::factory('Campaign');
		$campaign->first_name = $_POST['first_name'];
		$campaign->last_name = $_POST['last_name'];
		$campaign->email = $_POST['email'];
		$campaign->campaign_name = $_POST['campaign_name'];
		$campaign->description = $_POST['description'];
		$campaign->default_donation = $_POST['default_donation'];
		$campaign->account_type = $_POST['account_type'];

        // Add login role
        $user->add('roles', ORM::factory('Role', array('name' => 'login')));

        try {
            $campaign->save();
        } catch (ORM_Validation_Exception $e) {
            $this->template->content = "There was a problem creating your campaign: " . var_dump($e->errors());
        }

		$success = Auth::instance()->login($_POST['email'], $_POST['password']);

		if ($success) {
			//$this->template->content=$_POST['demo'];
			//HTTP::redirect('wepayapi');
			HTTP::redirect('wepayapi?demo=' . $_POST['demo']);
		} else{
			$this->template->content = "There was an error!";
		}
	}



	public function action_login(){
		$this->template->content = View::factory('user/login');
	}

	public function action_complete_login(){
		try{
			$post = Validation::factory($_POST)
				->rule('email', 'not_empty')
				->rule('email', 'email')
	            ->rule('password', 'not_empty')
	            ->rule('password', 'min_length', array('6'));
		} catch (Validation_Exception $e) {
			$this->template->content = "Your login was not valid: ".$e->errors();
		}

		$success = Auth::instance()->login($_POST['email'], $_POST['password']);

		if ($success){
			HTTP::redirect('user');
		} else{
			$this->template->content = "There was an error, try again";
		}
			
	}

	public function action_register_success(){

		$this->template->content = View::factory('user/register_success');
		$this->template->content->return_uri = URL::base() . '/user/account/';
	}

	public function action_logout(){
		#Sign out the user
		Auth::instance()->logout();
 
		#redirect to the user account and then the signin page if logout worked as expected
		HTTP::redirect('/');	

	}

	public function action_edit(){
		if (Auth::instance()->logged_in()){
			$user = Auth::instance()->get_user();
			$campaign = ORM::factory('Campaign')->where('email', '=', $user->email)->find();
			$this->template->content = View::factory('user/edit');
			$this->template->content->name = $campaign->first_name;
			$this->template->content->name = $campaign->last_name;
			$this->template->content->email = $campaign->email;
			$this->template->content->description = $campaign->description;
			$this->template->content->campaign_name = $campaign->campaign_name;
			$this->template->content->default_donation = $campaign->default_donation;
		}
		else{
			$this->template->content = "Error, you're not logged in!";
		}
	}

    public function action_delete() {
		if (Auth::instance()->logged_in()){
			$this->template->content = "Delete? Really?";
			$user = Auth::instance()->get_user();
			$campaign = ORM::factory('Campaign')->where('email', '=', $user->email)->find();
			if (!($user->login_role == 'admin')) {
			    Auth::instance()->logout();
	            $campaign->delete();
	            $user->delete();
			    HTTP::redirect('/');
			} else {
				$campaign = ORM::factory('Campaign')->where('id', '=', $_GET['account_id'])->find();
				$user = ORM::factory('user')->where('email', '=', $campaign->email)->find();
				$campaign->delete();
				$user->delete();
				HTTP::redirect('/');
			}
		}
		else{
			$this->template->content = "Error, you're not logged in!";
		}

    }

    public function action_resend_email() {
    	if (Auth::instance()->logged_in()) {
    		$user = Auth::instance()->get_user();
			$campaign = ORM::factory('Campaign')->where('email', '=', $user->email)->find();
    		Controller_Wepayapi::resend_email($campaign);
    		$this->template->content = "Thanks! Please check your email to finish registering.";
    	}
    	else {
    		$this->template->content = "Error, you're not logged in!";
    	}
    }

	public function action_update(){
		try{
			$post = Validation::factory($_POST)
            ->rule('name', 'not_empty')
            ->rule('email', 'not_empty')
            ->rule('email', 'email')
            ->rule('default_donation', 'numeric')
            ->rule('default_donation', 'not_empty')
            ->rule('kitchen', 'not_empty')
            ->rule('campaign_name', 'not_empty');
		} catch (Validation_Exception $e) {
			$this->template->content = "Your registration was not valid: ".$e->errors();
		}

		if (Auth::instance()->logged_in()){
			$user = Auth::instance()->get_user();
			$campaign = ORM::factory('Campaign')->where('email', '=', $user->email)->find();
			$campaign->campaign_name = $_POST['campaign_name'];
			$campaign->kitchen = $_POST['kitchen'];
			$campaign->default_donation = $_POST['default_donation'];
			$campaign->save();

			HTTP::redirect('user');
		}
		else{
			$this->template->content = "You can't update information for this user!";
		}	
	}
} 
