<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

  var $controller, $model, $page_title, $subformlabel, $theme = 'webarch';

  function __construct () {
    parent::__construct();
    $this->load->helper('url');
    // $this->load->library('session');
    // if (empty ($this->session->userdata['login_user_id'])) redirect (site_url('login'), 'refresh');
    $this->controller = $this->router->class;

    $page_title = preg_split('#([A-Z][^A-Z]*)#', $this->controller, null, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
    $page_title = implode(' ', $page_title);
    $this->subformlabel = $page_title;

    if (!isset ($this->model)) $this->model = $this->controller . 's';
    $this->load->model($this->model);

    // $theme = $this->session->userdata('theme');
    // $theme = !$theme ? 'webarch' : $theme;
    // $this->theme = $theme;
  }

  public function loadview ($view, $vars = array()) {
    // $settings = array('system_name', 'system_title', 'text_align');
    // foreach ($this->db->get('settings')->result() as $setting)
    //   if (in_array($setting->type, $settings)) $vars[$setting->type] = $setting->description;
    // $vars['account_type'] = $this->session->userdata('login_type');

    // $page_title = preg_split('#([A-Z][^A-Z]*)#', $this->controller, null, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
    // $page_title = implode(' ', $page_title);
    // $vars['page_title']   = strlen($this->page_title) > 0 ? get_phrase($this->page_title): $page_title;

    // $vars['menu'] = array();
    // $submenu = array();
    // $this->load->model('Menus');
    // foreach ($this->Menus->getMenus() as $menu) {
    //   if (empty ($menu->parent)) $vars['menu'][$menu->uuid] = array('menu' => $menu, 'submenu' => array());
    //   else $submenu[] = $menu;
    // }
    // foreach ($submenu as $sub) $vars['menu'][$sub->parent]['submenu'][] = $sub;

    // if (file_exists('uploads/' . $vars['account_type'] . '_image/' . $this->session->userdata('login_user_id') . '.jpg')) $vars['photo_profile'] = base_url() . 'uploads/' . $type . '_image/' . $id . '.jpg';
    // else $vars['photo_profile'] = base_url() . 'uploads/user.jpg';

    if (!isset ($vars['form_action'])) $vars['form_action'] = site_url($this->controller);
    $vars['current'] = array (
      'model' => $this->model,
      'controller' => $this->controller
    );
    $this->load->view($view, $vars);
  }

  public function index () {
    $model = $this->model;
    if ($post = $this->$model->lastSubmit($this->input->post())) {
      if (isset ($post['delete'])) $this->$model->delete($post['delete']);
      else {
          $db_debug = $this->db->db_debug; //dapetin config
          $this->db->db_debug = FALSE; //supaya error default nya codeigniter gak tampil (kalo mode production bagian ini dihapus gak masalah)
          $this->$model->save($post);
          $error = $this->db->error();
          $this->db->db_debug = $db_debug; //kembalikan ke config awal
          if(count($error)){
              // $this->session->set_flashdata('model_error', $error['message']);
              redirect($this->controller);
          }
      }
    }
    $vars = array();
    $vars['page_name'] = 'table';
    $vars['records'] = $this->$model->find();
    $vars['thead'] = $this->$model->thead;
    $this->loadview($this->theme . '/index', $vars);
  }

  function create () {
    $model= $this->model;
    $vars = array();
    $vars['page_name'] = 'form';
    $vars['form']     = $this->$model->getForm();
    $vars['subform'] = $this->$model->getFormChild();
    $vars['uuid'] = '';
    $this->loadview($this->theme . '/index', $vars);
  }

  function subformcreate () {
    $model= $this->model;
    $vars = array();
    $vars['form'] = $this->$model->getForm();
    $vars['subformlabel'] = $this->subformlabel;
    $vars['controller'] = $this->controller;
    $vars['uuid'] = '';
    $this->loadview($this->theme . '/subform', $vars);
  }

  function read ($id) {
    $data = array();
    $data['page_name'] = 'form';
    $model = $this->model;
    $data['form'] = $this->$model->getForm($id);
    $data['subform'] = $this->$model->getFormChild($id);
    $data['uuid'] = $id;
    $this->loadview($this->theme . '/index', $data);
  }

  function subformread ($uuid) {
    $data = array();
    $model = $this->model;
    $data['form'] = $this->$model->getForm($uuid);
    $data['subformlabel'] = $this->subformlabel;
    $data['controller'] = $this->controller;
    $data['uuid'] = $uuid;
    $this->loadview($this->theme . '/subform', $data);
  }

  function delete ($uuid) {
    $vars = array();
    $vars['page_name'] = 'confirm';
    $vars['uuid'] = $uuid;
    $this->loadview($this->theme . '/index', $vars);
  }

  function select2 ($model, $field) {
    $this->load->model($model);
    echo '{"results":'. json_encode($this->$model->select2($field, $this->input->post('term'))) . '}';
  }


  function select2region ($previousmodel, $model, $data, $field) {
    $this->load->model($model);
    echo '{"results":'. json_encode($this->$model->select2region($previousmodel, $field, $this->input->post('term'), $data)) . '}';
  }
  

}