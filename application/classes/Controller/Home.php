<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Home extends Controller_Template {

   public function action_index() {

        $this->view_file = 'home/index';

        // fetch featured campaigns
        $featured_campaigns = Model_Campaign::getFeatured();

        //send a subview to the main page
        $this->vars('featured_campaigns', View::factory('templates/campaigns', array(
            'campaigns' => $featured_campaigns
        )));
    }
}