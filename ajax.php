<?php
$query = $type = $city = $street = $region = '';
$functions = array('findCity','findCityByRegion','findStreet','getHouses','findSubject','findRegionBySubject','getCityByCode');
error_reporting(E_ALL);

$type = isset($_GET['cmd'])?$_GET['cmd']:'not found';
if( !in_array($type,$functions )){
  header('HTTP/1.1 404 Not Found');
exit();
}


$query     = isset($_GET['q'])      ? $_GET['q']      : '' ;
$code      = intval( isset($_GET['code'])   ? $_GET['code']   : '' );
$city      = intval( isset($_GET['city'])   ? $_GET['city']   : '' );
$street    = intval( isset($_GET['street']) ? $_GET['street'] : '' );
$region    = intval( isset($_GET['region']) ? $_GET['region'] : '' );
$subject   = intval( isset($_GET['subject']) ? $_GET['subject'] : '' );


require_once(dirname(__FILE__).'/address.php');



$db = new mysqli('127.0.0.1','ma','bE5tWFv2kpd8vJq');
if(!$db) echo ' --- '.$db->connect_error,"\n\n";
$db->select_db('ma_kladr');
$db->query('set names utf8');



$result = null;

switch($type){
  case 'findSubject':
    $result = AddressHelper::findSubject($db,$query);
    break;
  case 'findRegionBySubject':
    $result = AddressHelper::findRegionBySubject($db,$query,$subject);
    break;
  case 'findCity':
    $result = AddressHelper::findCity($db,$query);
    break;
  case 'getCityByCode':
    $result = AddressHelper::getCityByCode($db,$code);
    break;
  case 'findCityByRegion':
    $result = AddressHelper::findCityByRegion($db,$query,$region);
    break;
  case 'findStreet':
    $result = AddressHelper::findStreet($db,$city,$query);
    break;
  case 'getHouses':
    $result = AddressHelper::getHouses($db,$street);
    break;
  default:
    header('HTTP/1.1 404 Not Found');
    exit();
}

header('Content-Type: text/plain; charset=utf-8');
echo json_encode($result);
exit;

