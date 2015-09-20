<?php
	define('BACKEND_VERSION', 1.0);
	
	define('API_SUCCESS_LIST', 1000);
	define('API_SUCCESS_LIST_EMPTY', 1001);
    define('API_SUCCESS_UPDATE', 1002);
    define('API_SUCCESS_FAVORITE', 1003);
    define('API_SUCCESS_DELETE', 1004);
    define('API_SUCCESS_SAVE', 1005);
	define('API_SUCCESS_CLEAR', 1006);
	
	define('API_ERROR_SERVER', 5000);
    define('API_ERROR_404', 5001);
    define('API_ERROR_403', 5002);
    define('API_ERROR_MISSING_FUNCTION', 5003);
    define('API_ERROR_NO_DATABASE', 5004);
    define('API_ERROR_CONFIG', 5005);
    define('API_ERROR_UNKNOWN', 5006);
	define('API_ERROR_DATABASE_CONNECT', 5012);
	define('API_ERROR_MISSING_PARAMETER', 5013);
    define('API_ERROR_FUNCTION_NOT_SPECIFIED', 5014);
	define('API_ERROR_NOT_CONFIGURED', 5015);
	
	define('API_ERROR_UPDATE_', 6001);
    define('API_ERROR_FAVORITE', 6002);
    define('API_ERROR_DELETE', 6003);
    define('API_ERROR_SAVE', 6004);
	define('API_ERROR_CLEAR', 6005);
?>
