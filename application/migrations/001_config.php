<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Migration_config extends CI_Migration {

  function up () {
    $this->db->query("
      CREATE TABLE `user` (
        `uuid` varchar(255) NOT NULL,
        `name` varchar(255) NOT NULL,
        PRIMARY KEY (`uuid`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8
    ");
  }

  function down () {
    $this->db->query("DROP TABLE `user`");
  }

}