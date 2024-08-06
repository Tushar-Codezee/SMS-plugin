<?php
/*
* Plugin Name: Student Management System
* Description: This is custom SMS
* Plugin URI: https://example.com/sms
* Author: Tushar
* Author URI: https://example.com
* version: 1.0.0
* Requires at least: 6.3 above
* Requires PHP: 7.4 above
*/

define("SMS_PLUGIN_PATH", plugin_dir_path(__FILE__));
define("SMS_PLUGIN_URL", plugin_dir_url(__FILE__));


include_once(SMS_PLUGIN_PATH . 'class/StudentManagement.php');

$sms = new StudentManagement;

register_activation_hook(__FILE__, array($sms, "CreateStudentTable"));

register_deactivation_hook(__FILE__, array($sms, "DropStudentTable"));
