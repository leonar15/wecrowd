<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Home extends Controller_Base {

   public function action_index() {

        $this->template->content = View::factory('welcome/index');
        $this->template->table = ORM::factory('Campaign')->find_all();
        return;
    }
}