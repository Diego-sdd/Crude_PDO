<?php

session_start();
	unset($_SESSION['cd_user']);
	header('location: index.php');
