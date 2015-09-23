<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
	'login/login' => array(
			array(
					'field' => 'username',
					'label' => 'Username',
					'rules' => 'trim|required',
					'errors' => array('required' => "Tolong isikan %s Anda.")
			),
			array(
					'field' => 'password',
					'label' => 'Password',
					'rules' => 'required',
					'errors' => array('required' => "Tolong isikan %s Anda.")
			)
	)	
);