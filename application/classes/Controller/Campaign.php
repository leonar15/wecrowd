<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Campaign extends Controller_Template {

    public function action_index() {
        // redirect to index page
        HTTP::redirect('/');
	}


    public function action_new(){

        // did they submit the form?
        $posted_form = $this->request->post();
        if ($posted_form) {
            // validate data
            $validation = Validation::factory($posted_form)
                ->rule('first_name', 'not_empty')
                ->rule('first_name', 'max_length', array(':value', 32))
                ->rule('last_name', 'not_empty')
                ->rule('last_name', 'max_length', array(':value', 32))
                ->rule('email', 'not_empty')
                ->rule('email', 'email')
                ->rule('password', 'not_empty')
                ->rule('password', 'min_length', array(':value', 6))
                ->rule('default_donation', 'numeric')
                ->rule('default_donation', 'not_empty')
                ->rule('campaign_goal', 'numeric')
                ->rule('campaign_goal', 'not_empty')
                ->rule('campaign_name', 'not_empty');
            
            // enforce validation
            if ($validation->check()) {

                // create a new user
                $new_user = ORM::factory('User');
                $new_user->first_name = $posted_form['first_name'];
                $new_user->last_name  = $posted_form['last_name'];
                $new_user->email      = $posted_form['email'];
                $new_user->password   = $posted_form['password'];

                try {
                    // save the new user to the database
                    $new_user->save();
                    
                    // add login role
                    $new_user->add('roles', ORM::factory('Role', array('name' => 'login')));

                } catch (ORM_Validation_Exception $e) {
                    $this->show_error_message("There was a problem creating your user account: " . var_dump($e->errors()));
                    return;
                }

                // create a donation campaign
                $campaign = ORM::factory('Campaign');
                $campaign->first_name = $new_user->first_name;
                $campaign->last_name = $new_user->last_name;
                $campaign->email = $new_user->email;
                
                $campaign->name = $posted_form['campaign_name'];
                $campaign->description = $posted_form['description'];
                $campaign->default_donation = $posted_form['default_donation'];
                $campaign->total_goal = $posted_form['campaign_goal'];
                $campaign->account_type = $posted_form['account_type'];
                
                try {
                    $campaign->save();
                } catch (ORM_Validation_Exception $e) {
                    $this->show_error_message("There was a problem creating your campaign: " . var_dump($e->errors()));
                }

                // login this user!
                $login_success = Auth::instance()->login($posted_form['email'], $posted_form['password']);
                
                if ($login_success) {
                    HTTP::redirect('wepayapi' . (isset($posted_form['enable_demo']) ? '?demo=' : ''));
                } else{
                    $this->show_error_message("There was an error!");
                }

            } else {
                // just reload the form with an error message
            }
        }

        // let's setup the form with some demo data
        $this->view_file = 'campaign/new';
        $campaign = Demo::getCamapaignDetails();
        
        // pass variables to the view
        $this->vars('enable_demo', $this->request->query('demo'));
        $this->vars('first_name', Demo::getFirstName());
        $this->vars('last_name', Demo::getLastName());
        $this->vars('campaign_name', $campaign['name']);
        $this->vars('campaign_description', $campaign['description']);
	}

	public function action_view() {
        $campaign_id = Request::current()->param('campaign_id');
        
        $campaign = ORM::factory('Campaign', $campaign_id);
        
        if (!$campaign->loaded()) {
            $this->show_error_message('We could not find that campaign');
            HTTP::redirect('/');
        }
        
        $this->view_file = 'campaign/view';
        $this->vars('campaign', $campaign);
        
        
   		if (Auth::instance()->logged_in()) {
			$user = Auth::instance()->get_user();
			if ($campaign->email == $user->email || $user->logged_in('admin')) {
				$this->vars('edit', true);
				if (!($campaign->hasAccessToken())) {
					$this->vars('wepay', "<b>Please confirm account to manage your money: <p><a class='wepay-widget-button wepay-blue' href=" . URL::base() . "wepayapi>Click here to create your WeCrowd account</a>");
					$this->vars('token', false);
				} else {
					$balances = Controller_Wepayapi::get_balance($campaign);
					$this->vars('token', true);
					$this->vars('balance', number_format($balances, 2));
					$this->vars('wepay', '');
					$this->vars('checkouts', Controller_Wepayapi::get_checkouts($campaign));
				}
			}
			else {
				$this->vars('edit', false);
				if ($campaign->hasAccountId()) {
					$this->vars('wepay', "<a href=" . URL::base() . "user/create_credit_card/".$id." class='btn btn-danger btn-large' id='buy-now-button'>Donate to ".$campaign->name." Now!</a>");
					$this->vars('token', true);
				} else {
					$this->vars('wepay', '');
					$this->vars('token', false);
				}
			}
		} else {
			$this->vars('edit', false);
			if ($campaign->hasAccountId()) {
				$this->vars('wepay', "<a href=" . URL::base() . "user/create_credit_card/".$id." class='btn btn-danger btn-large' id='buy-now-button'>Donate to ".$campaign->name." Now!</a>");
				$this->vars('token', true);
			} else {
				$this->vars('wepay', "");
				$this->vars('token', false);
			}
		}
		$this->vars('state', $campaign->state);
		$this->vars('wepay_link', 'https://stage.wepay.com/account/' . $campaign->wepay_account_id);

        
    }

}
