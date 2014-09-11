<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Template extends Kohana_Controller_Template {

    public $template = 'templates/page';
    public $view_file = null;
    public $header_file = 'templates/header';

    private $vars = array();

    public function before() {
        parent::before();

        if (Auth::instance()->logged_in()) {
            $this->header_file = 'templates/header_logged_in';
        }

        $this->template->content = '';
        $this->template->table = '';
    }

	/**
	 * Assigns the template [View] as the request response.
	 */
	public function after()
	{

        if ($this->view_file) {
            $this->template->content = View::factory($this->view_file, $this->vars);
	    } else {
            $this->template->content->set($this->vars);
	    }

        $this->template->header = View::factory($this->header_file, $this->vars);

		parent::after();
	}
    
    public function vars($key, $value) {
        $this->vars[$key] = $value;
    }
    
    public function show_error_message($message) {
        $this->vars('error_message', $message);
    }
    
    public function show_success($message) {
        $this->vars('success_message', $message);
    }
}