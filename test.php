<?php

//use TallyPHP\TallyIntegration;
require_once("src/tallyIntegration.php");

$host = "10.1.30.95:9000";
$tally = new TallyIntegration($host);

echo $tally;die();

//parametrs from application
$billing_user = "Imran2222";


$aa = array();
$aa["state_name"] = "New Delhi";
$aa["ledger_name"] = $billing_user ;
$aa["parent"] = "Sundry Debtors";
$aa["ledger_description"] = "aaaa bbbb cccc dddd eee  ffff  gggg hhhh jjjjjj";
$aa["ledger_address"] = "14 wea, karol bagh";
$aa["ledger_city"] = "New Delhi";
$aa["pin_code"] = "110006";
$aa["country"] = "India";
$aa["is_affect_stock"] = "Yes";
$aa["ledger_contact"] = "Imraan";


$res = $tally->getAllLedger();

//print_r($res);

if ($res !== NULL){
  // check ledger is avvailable in tally or not
  if (in_array("$billing_user", $res))
  {
    //enter a voucher
    echo "Match found";
    //echo $voucher_entry;die();
    $vcentry = xml_execute($url, $voucher_entry);
    print_r($vcentry);
  }
  else
  {
    // create ledger
    // enter a voucher
    echo "Match not found...";
    echo "Creating New Ledger...";

    $ledger = $tally->CreateLedger($aa);

    print_r($ledger);


  }
}


?>