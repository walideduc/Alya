<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 09/09/15
 * Time: 19:03
 */
error_reporting(E_ALL ^ E_NOTICE);
/************************************************************************
 * REQUIRED
 *
 * Access Key ID and Secret Acess Key ID, obtained from:
 * http://aws.amazon.com
 ***********************************************************************/
define('AWS_ACCESS_KEY_ID', 'AWS_ACCESS_KEY_ID_xxxxxxxxxxxxxxxxxx');
define('AWS_SECRET_ACCESS_KEY', 'AWS_SECRET_ACCESS_KEY_xxxxxxxxxxxxxxxxxx');

/************************************************************************
 * REQUIRED
 *
 * All MWS requests must contain a User-Agent header. The application
 * name and version defined below are used in creating this value.
 ***********************************************************************/
define('APPLICATION_NAME', 'alyya');
define('APPLICATION_VERSION', '1.0');

/************************************************************************
 * REQUIRED
 *
 * All MWS requests must contain the seller's merchant ID and
 * marketplace ID.
 ***********************************************************************/
define ('MERCHANT_ID', 'MERCHANT_ID_xxxxxxxxxxxxxxx');


define ('MARKETPLACE_ID_FRANCE', 'A13V1IB3VIYZZH');
define ('MARKETPLACE_ID_ITALY', 'APJ6JRA9NG5V4');
define ('MARKETPLACE_ID_GERMANY', 'A1PA6795UKMFR9');
define ('MARKETPLACE_ID_SPAIN', 'A1RKKUPIHCS9HS');
define ('MARKETPLACE_ID_UNITED_KINGDOM', 'A1F83G8C2ARO7P');


set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__FILE__)); //add the cwd to the include path for the amazon library to autoload

spl_autoload_register('autoloadMWS',true,true); //the second true flag prepends the autoload function on the stack instead of appending it

function autoloadMWS($className)
{
    $filePath = str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
    $includePaths = explode(PATH_SEPARATOR, get_include_path());
    foreach($includePaths as $includePath){
        if(file_exists($includePath . DIRECTORY_SEPARATOR . $filePath)){
            require_once $filePath;
            return;
        }
    }
}

