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
	),
	'api/getDataAPI' => array(
			array(
					'field' => 'server',
					'label' => 'Server',
					'rules' => 'required',
					'errors' => array('required' => "Tolong pilih %s yang Anda inginkan.")
			),
			array(
					'field' => 'searchBy',
					'label' => 'Kategori',
					'rules' => 'required',
					'errors' => array('required' => "Tolong Pilih %s yang Anda inginkan.")
			),
			array(
					'field' => 'seacrh',
					'label' => 'Kata Kunci',
					'rules' => 'required',
					'errors' => array('required' => "Tolong Isikan %s yang Anda inginkan.")
			)
	)
);