<?php
/* Template Name: Logout */
session_start();
session_destroy();
session_unset();
header('location: '.esc_url(home_url()));

?>