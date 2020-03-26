<?php

/** static billing user details for testing */

$billing_user   =   "Imran5"; //in tally LEDGER, PARTYNAME, PARTYLEDGERNAME, BASICBASEPARTYNAME, BASICBUYERNAME
$company_name   =   "Mokambika";
$state          =   "Uttar Pradesh"; //in tally STATENAME
$country        =   "India"; //in tally COUNTRYOFRESIDENCE
$taxes  =   array();

//billing details
$amount =   70.8;
$description = "VTS LICENSE FOR 3 VTS";
$invoice_number = "NMS/GEOTRACK/4525";
$date = 20191113;


$taxes = array("Local Sale    18%"=>"60", "Input CGST @9%"=>"5.4", "Input SGST @9%"=>"5.4");
//$taxes = array("SGST"=>"1.8", "CGST"=>"1.8");

foreach($taxes as $x_key => $x_value) {
  $ledger_entry .= "<ALLLEDGERENTRIES.LIST>
          <LEDGERNAME>$x_key</LEDGERNAME> 
          <ISDEEMEDPOSITIVE>No</ISDEEMEDPOSITIVE> 
          <AMOUNT>$x_value</AMOUNT>
        </ALLLEDGERENTRIES.LIST>";
}




//list of ledger query
$listofledgers =<<<XML
<ENVELOPE>
  <HEADER>
    <VERSION>1</VERSION>
    <TALLYREQUEST>Export</TALLYREQUEST>
    <TYPE>Data</TYPE>
    <ID>List of Ledgers</ID>
  </HEADER>
  <BODY>
    <DESC>
      <TDL>
        <TDLMESSAGE>
          <REPORT NAME="List of Ledgers" ISMODIFY="No" ISFIXED="No" ISINITIALIZE="No" ISOPTION="No" ISINTERNAL="No">
            <FORMS>List of Ledgers</FORMS> 
          </REPORT>
          <FORM NAME="List of Ledgers" ISMODIFY="No" ISFIXED="No" ISINITIALIZE="No" ISOPTION="No" ISINTERNAL="No">
            <TOPPARTS>List of Ledgers</TOPPARTS> 
            <XMLTAG>"List of Ledgers"</XMLTAG> 
          </FORM>
          <PART NAME="List of Ledgers" ISMODIFY="No" ISFIXED="No" ISINITIALIZE="No" ISOPTION="No" ISINTERNAL="No">
            <TOPLINES>List of Ledgers</TOPLINES> 
            <REPEAT>List of Ledgers : Collection of Ledgers</REPEAT> 
            <SCROLLED>Vertical</SCROLLED> 
          </PART>
          <LINE NAME="List of Ledgers" ISMODIFY="No" ISFIXED="No" ISINITIALIZE="No" ISOPTION="No" ISINTERNAL="No">
            <LEFTFIELDS>List of Ledgers</LEFTFIELDS> 
          </LINE>
          <FIELD NAME="List of Ledgers" ISMODIFY="No" ISFIXED="No" ISINITIALIZE="No" ISOPTION="No" ISINTERNAL="No">
            <SET>\$Name</SET> 
            <XMLTAG>"LEDGERNAME"</XMLTAG> 
          </FIELD>
          <COLLECTION NAME="Collection of Ledgers" ISMODIFY="No" ISFIXED="No" ISINITIALIZE="No" ISOPTION="No" ISINTERNAL="No">
            <TYPE>Ledger</TYPE> 
          </COLLECTION>
        </TDLMESSAGE>
      </TDL>
    </DESC>
  </BODY>
</ENVELOPE>
XML;

//create a ledger
$voucher_entry =<<<XML
<ENVELOPE>
  <HEADER>
    <VERSION>1</VERSION>
    <TALLYREQUEST>IMPORT</TALLYREQUEST>
    <TYPE>DATA</TYPE>
    <ID>ALL MASTERS</ID>
  </HEADER>
  <BODY>
    <DESC>
    </DESC>
    <REQUESTDATA>
      <!-- Create Ledger named "Cash" if it does not exist -->
      <TALLYMESSAGE xmlns:UDF="TallyUDF">
        <LEDGER NAME="{$billing_user}" ACTION="Create">

          <NAME.LIST>
            <NAME>{$billing_user}</NAME>
          </NAME.LIST>

          <ADDRESS.LIST TYPE="String">
              <ADDRESS>WEA GAli no 25,Karol Bagh</ADDRESS>
              <ADDRESS>New Delhi</ADDRESS>
          </ADDRESS.LIST>

          <LEDSTATENAME>New Delhi</LEDSTATENAME>

          <PINCODE>110005</PINCODE>

          <MAILINGNAME.LIST TYPE="String">
            <MAILINGNAME>nmsmail</MAILINGNAME>
          </MAILINGNAME.LIST>

          <EMAIL>nmsemail@email.com</EMAIL>

          <INCOMETAXNUMBER>LKNBY12345</INCOMETAXNUMBER>

          <COUNTRYNAME>India</COUNTRYNAME>

          <GSTREGISTRATIONTYPE>Regular</GSTREGISTRATIONTYPE>

          <PARENT>Sundry Debtors</PARENT>

          <NARRATION>HNJHSB  KHIIHB IUHIU UIHIH jhg iuhtgb t orthorth uohsoufgthortuh ouhrgtu</NARRATION>

          <COUNTRYOFRESIDENCE>India</COUNTRYOFRESIDENCE>
          <EMAILCC>mysteryman@email.com</EMAILCC>
          <LEDGERPHONE>458923</LEDGERPHONE>
          <LEDGERCONTACT>Mystery Man</LEDGERCONTACT>
          <LEDGERMOBILE>6598765987</LEDGERMOBILE>
          <PARTYGSTIN>ASDF234kl56</PARTYGSTIN>
          <GSTNATUREOFSUPPLY>SEZ</GSTNATUREOFSUPPLY>

          <ISBILLWISEON>No</ISBILLWISEON>
          <AFFECTSSTOCK>No</AFFECTSSTOCK>
          <OPENINGBALANCE>0</OPENINGBALANCE>
          <USEFORVAT>No </USEFORVAT>
          <TAXCLASSIFICATIONNAME/>
          <TAXTYPE/>
          <RATEOFTAXCALCULATION/>

        </LEDGER>
      </TALLYMESSAGE>
    </REQUESTDATA>
  </BODY>
</ENVELOPE>
XML;

//echo $voucher_entry;die();

$voucher_entry=<<<XML
<ENVELOPE>
    <HEADER>
        <VERSION>1</VERSION>
        <TALLYREQUEST>Import</TALLYREQUEST>
        <TYPE>Data</TYPE>
        <ID>Vouchers</ID>
    </HEADER>

    <BODY>
        <DESC>
        </DESC>
        <DATA>
            <TALLYMESSAGE>
                <VOUCHER>
                    <DATE>{$date}</DATE>
                    <NARRATION>{$description}</NARRATION>
                    <STATENAME>{$state}</STATENAME>
                    <COUNTRYOFRESIDENCE>{$country}</COUNTRYOFRESIDENCE>
                    <PARTYNAME>{$billing_user}</PARTYNAME>
                    <VOUCHERTYPENAME>SALES</VOUCHERTYPENAME>
                    <REFERENCE>{$invoice_number}</REFERENCE>
                    <VOUCHERNUMBER>{$invoice_number}</VOUCHERNUMBER>
                    <PARTYLEDGERNAME>{$billing_user}</PARTYLEDGERNAME>
                    <BASICBASEPARTYNAME>{$billing_user}</BASICBASEPARTYNAME>

                    <ALLLEDGERENTRIES.LIST> 
                        <LEDGERNAME>{$billing_user}</LEDGERNAME>
                        <ISDEEMEDPOSITIVE>Yes</ISDEEMEDPOSITIVE>
                        <AMOUNT>-{$amount}</AMOUNT>
                    </ALLLEDGERENTRIES.LIST>

                    {$ledger_entry}
                
                </VOUCHER>
            </TALLYMESSAGE>
        </DATA>
    </BODY>
</ENVELOPE>
XML;





  $url = "10.1.30.95:9000";

  // function to execute xml code
  function xml_execute($host, $xml_request)
  {
    $url = $host;
    $res_str = $xml_request;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    // Following line is compulsary to add as it is:
    curl_setopt($ch, CURLOPT_POSTFIELDS,"xmlRequest=" . $res_str);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
    $data = curl_exec($ch);
    //echo '<pre>';
    //var_dump($data);die;
    curl_close($ch);
    // get the xml object 
    $object = (array) simplexml_load_string( $data );
    return $object;
  }

  //execute function
  $xml = xml_execute($url, $listofledgers);
  $a = $xml["LEDGERNAME"];

  // check ledger is avvailable in tally or not
  if (in_array("$billing_user", $a))
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
    echo "Match not found";
    echo "Creating New Ledger";

    $vcentry = xml_execute($url, $voucher_entry);

    print_r($vcentry);
  }


//print_r( $res );

die();







   // $xml1 =  $xml->BODY->DATA->COLLECTION;
   // print_r( $xml );





    die();
    foreach($xml->DATA->COLLECTION->LEDGER as $item)
    {
        echo (string)$item->NAME;

    }




  
  
	
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Tally</title>

    <!-- Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    
	
	<div class="container">
	
		<div class="col-md-6 col-md-offset-3" style="margin-top:20px">
			<?php if(isset($msg) && $msg) :?>
			<div class="alert alert-success" role="alert"><?=$msg?></div>
			<?php endif;?>
			
			<h3>Tally Item List <div class="pull-right"><a href="item.php">Add item</a></div></h3>
			<hr>
			
			<table class="table table-bodered">
				<tr>
					<th>Item Name</th>
					<th>Item Quantity</th>
					<th>Item Rate</th>
				</tr>
				<?php $i = 0;?>
				<?php foreach($object->DSPACCNAME as $value) :?>
				<tr>
					<td><?=$value->DSPDISPNAME?></td>
					<td><?=$object->DSPSTKINFO[$i]->DSPSTKCL->DSPCLQTY?></td>
					<td><?=$object->DSPSTKINFO[$i]->DSPSTKCL->DSPCLRATE?></td>
				</tr>
				<?php $i++;?>
				<?php endforeach;?>
			</table>

		</div>
	</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </body>
</html>