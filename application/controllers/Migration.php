<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration extends CI_Controller {

  public function __construct () {
    parent::__construct();
  }

  public function index ($version = 0)
  {
    $this->load->library('migration');
    $success = $version > 0 ? $this->migration->version($version) : $this->migration->latest();
    if (!$success) show_error($this->migration->error_string());
  }

}