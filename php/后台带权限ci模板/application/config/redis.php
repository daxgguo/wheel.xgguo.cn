<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//`tcp` or `unix`
$config['socket_type'] = 'tcp'; 

// in case of `unix` socket type
$config['socket'] = '/var/run/redis.sock'; 
$config['host'] = '127.0.0.1';
$config['password'] = null;
$config['port'] = 6379;
$config['timeout'] = 0;
