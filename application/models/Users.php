<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Model {

  function __construct () {
    parent::__construct();
    $this->form  = array ();

    $this->thead = array(
      (object) array('mData' => 'name', 'sTitle' => 'Name'),
    );

    $this->table = 'user';

    $this->form[]= array(
      'name'    => 'name',
      'label'   => 'Name',
    );

  }

}
