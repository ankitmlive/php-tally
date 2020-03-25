<?php

Class TallyIntegration
{

    public $tallyHost;
   
    function __construct($host)
    {
        $this->tallyHost = $host;
    }

    // main function to execute xml code
    function xml_execute($xml_request)
    {
        $url = $this->tallyHost;
        $res_str = $xml_request;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS,"xmlRequest=" . $res_str);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
        $data = curl_exec($ch);
        //echo '<pre>';
        //var_dump($data);die;
        curl_close($ch);
        // get the result array
        $object = (array) simplexml_load_string( $data );
        return $object;
    }

    //get all the ledger from selected company
    function getAllLedger()
    {
        //list of ledger xml query
        $listOfLedger =<<<XML
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
        $ledgerList = $this->xml_execute($listOfLedger);
        return $ledgerList["LEDGERNAME"];
    }

    // create ledger 
    function CreateLedger($create_ledger_params)
    {
        if( count($create_ledger_params) == 0) {
          return "params are not available";
        }

        $ledger_name    = $create_ledger_params["ledger_name"];
        $state_name     = $create_ledger_params["state_name"];
        $pin_code       = $create_ledger_params["pin_code"];
        $email          = $create_ledger_params["email"];
        $ledger_address = $create_ledger_params["ledger_address"];
        $email_cc       = $create_ledger_params["email_cc"];
        $ledger_phone   = $create_ledger_params["ledger_phone"];
        $ledger_mobile  = $create_ledger_params["ledger_mobile"];
        $ledger_website = $create_ledger_params["ledger_website"];
        $ledger_contact = $create_ledger_params["ledger_contact"];
        $income_tax_number = $create_ledger_params["income_tax_number"];
        $country         = $create_ledger_params["country"];
        $ledger_city        = $create_ledger_params["ledger_city"];
        $parent             = $create_ledger_params["parent"];
        $ledger_description = $create_ledger_params["ledger_description"];
        $party_gstin          = $create_ledger_params["party_gstin"];
        $gst_nature_of_supply = $create_ledger_params["gst_nature_of_supply"];
        $opening_balance      = $create_ledger_params["opening_balance"];
        $is_affect_stock      = $create_ledger_params["is_affect_stock"];
        $is_bill_wise_on      = $create_ledger_params["is_bill_wise_on"];

        //conditions for ledger in tally-- more will be added later.
        if ($ledger_name == ""){return "please provide ledger name";}
        if ($parent  == ""){return "please provide ledger parent";}
        if ($ledger_description == ""){return "please provide ledger description";}
        if ($ledger_name == ""){return "please provide ledger name";}
        if ($country == ""){return "please provide ledger country";}

        //default value for some attributes
        $is_affect_stock = ($is_affect_stock !== NULL) ? $is_affect_stock : 'NO'; 
        $opening_balance = ($opening_balance !== NULL) ? $opening_balance : 0;
        $is_bill_wise_on = ($is_bill_wise_on !== NULL) ? $is_bill_wise_on : 'NO';
        $use_for_vat     = ($use_for_vat !== NULL) ? $use_for_vat : 'NO';

 
        //create a ledger xml structure
        $ledgerCreateXML =<<<XML
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
                <TALLYMESSAGE xmlns:UDF="TallyUDF">
                    <LEDGER NAME="{$ledger_name}" ACTION="Create">

                        <NAME.LIST>
                            <NAME>{$ledger_name}</NAME>
                        </NAME.LIST>

                        <ADDRESS.LIST TYPE="String">
                            <ADDRESS>{$ledger_address}</ADDRESS>
                            <ADDRESS>{$ledger_city}</ADDRESS>
                        </ADDRESS.LIST>

                        <LEDSTATENAME>{$state_name}</LEDSTATENAME>
                        <PINCODE>{$pin_code}</PINCODE>

                        <MAILINGNAME.LIST TYPE="String">
                            <MAILINGNAME>{$ledger_name}</MAILINGNAME>
                        </MAILINGNAME.LIST>

                        <EMAIL>{$email}</EMAIL>

                        <COUNTRYNAME>{$country}</COUNTRYNAME>

                        <GSTREGISTRATIONTYPE>Regular</GSTREGISTRATIONTYPE>

                        <PARENT>{$parent}</PARENT>

                        <NARRATION>{$ledger_description}</NARRATION>

                        <COUNTRYOFRESIDENCE>{$country}</COUNTRYOFRESIDENCE>

                        <EMAILCC>{$email_cc}</EMAILCC>

                        <LEDGERPHONE>{$ledger_phone}</LEDGERPHONE>

                        <LEDGERCONTACT>{$ledger_contact}</LEDGERCONTACT>

                        <LEDGERMOBILE>{$ledger_mobile}</LEDGERMOBILE>

                        <PARTYGSTIN>{$party_gstin}</PARTYGSTIN>

                        <GSTNATUREOFSUPPLY>{$gst_nature_of_supply}</GSTNATUREOFSUPPLY>

                        <ISBILLWISEON>{$is_bill_wise_on}</ISBILLWISEON>

                        <AFFECTSSTOCK>{$is_affect_stock}</AFFECTSSTOCK>

                        <OPENINGBALANCE>{$opening_balance}</OPENINGBALANCE>

                        <USEFORVAT>{$use_for_vat}</USEFORVAT>

                        <TAXCLASSIFICATIONNAME/>
                        <TAXTYPE/>
                        <RATEOFTAXCALCULATION/>
                    </LEDGER>
                </TALLYMESSAGE>
            </REQUESTDATA>
        </BODY>
        </ENVELOPE>
XML;

       // echo $ledgerCreateXML;die();
        $ledgerCreated = $this->xml_execute($ledgerCreateXML);
        return $ledgerCreated;
    }

    // Incompleted..
    //developmnet is on progress..
    function VoucherEntry($voucher_entry_params) 
    {
        if( count($voucher_entry_params) == 0) {
            return "params are not available";
          }

          $vocher_date = $voucher_entry_params["date"];
          $party_name  = $voucher_entry_params["party_name"]; //billing user as a party name
          $state_name  = $voucher_entry_params["state_name"];
          $invoice_number = $voucher_entry_params["invoice_number"];
          $amount       = $voucher_entry_params["amount"];
          $refference  = $voucher_entry_params["refference"];
          $country_of_residence = $voucher_entry_params["country_of_residence"];
          $description = $voucher_entry_params["description"];
          $vocher_type = $voucher_entry_params["vocher_type"]; //sales or purchase
          $taxes       = $voucher_entry_params["taxes"]; //taxes array
          
          //set taxes in to voucher entry xml
          if (count($taxes) !== 0 ) 
          {
            //proces taxes as a legder
            foreach($taxes as $x_key => $x_value) {
                $ledger_entry .= "<ALLLEDGERENTRIES.LIST>
                        <LEDGERNAME>$x_key</LEDGERNAME> 
                        <ISDEEMEDPOSITIVE>No</ISDEEMEDPOSITIVE> 
                        <AMOUNT>$x_value</AMOUNT>
                    </ALLLEDGERENTRIES.LIST>";
            }
          }

          //Vocher XML Structure
          $VocherEntryXML = <<<XML
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
                            <DATE>{$vocher_date}</DATE>
                            <NARRATION>{$description}</NARRATION>
                            <STATENAME>{$state_name}</STATENAME>
                            <COUNTRYOFRESIDENCE>{$country_of_residence}</COUNTRYOFRESIDENCE>
                            <PARTYNAME>{$billing_user}</PARTYNAME>
                            <VOUCHERTYPENAME>{$vocher_type}</VOUCHERTYPENAME>
                            <REFERENCE>{$refference}</REFERENCE>
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

    //echo $VocherEntryXML;die();
    $VocherCreated = $this->xml_execute($VocherEntryXML);
    return $VocherCreated;
    
    }


}// class closed



?>