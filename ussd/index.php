<?php

$sessionId   = $_POST["sessionId"];
$phoneNumber = $_POST["msisdn"];
$userinput   = urldecode($_POST["UserInput"]);
$serviceCode = $_POST["serviceCode"];
$networkCode = $_POST['networkCode'];

$dataInput = explode('*', $userinput);

if(isset($dataInput[4])){
    $actionType = $dataInput[4];
    if($actionType == '1'){
        if(isset($dataInput[5])){
            $fullname = $dataInput[5];
        }
        if(isset($dataInput[6])){
            $fullname = $dataInput[5];
            $nid = $dataInput[6];
        }
        if(isset($dataInput[7])){
            $fullname = $dataInput[5];
            $nid = $dataInput[6];
            $phone = $dataInput[7];
        }
    }
    elseif($actionType == '2'){
        if(isset($dataInput[5])){
            $phone = $dataInput[5];
        }
        if(isset($dataInput[6])){
            $phone = $dataInput[5];
            $mpin = $dataInput[6];
        }
    }
    elseif($actionType == '3'){
        if(isset($dataInput[5])){
            $phone = $dataInput[5];
        }
        if(isset($dataInput[6])){
            $phone = $dataInput[5];
            $mpin = $dataInput[6];
        }
        if(isset($dataInput[7])){
            $phone = $dataInput[5];
            $mpin = $dataInput[6];
            $accountno = $dataInput[7];
        }
        if(isset($dataInput[8])){
            $phone = $dataInput[5];
            $mpin = $dataInput[6];
            $accountno = $dataInput[7];
            $amount = $dataInput[8];
        }
    }
    elseif($actionType == '4'){
        if(isset($dataInput[5])){
            $phone = $dataInput[5];
        }
    }
}

if($userinput=="*662*800*9#"){
    $response  = "ANZUZA APP\n\n";
    $response .="1. Account Opening\n2. Check your request\n3. Contact us\n\n";
    $ContinueSession=1;
}

//Account opening
elseif($userinput=="*662*800*9*1#"){
    $response  = "GOSHEN ONLINE BANKING SYSTEM\n\n";
    $response .="Enter your full name\n\n";
    $ContinueSession=1;
}

elseif($userinput=="*662*800*9*1*".$fullname){
    $response  = "GOSHEN ONLINE BANKING SYSTEM\n\n";
    $fullname = substr($fullname, 0, -1);
    $response .="Hello ".$fullname."! Please enter your NID Card number.\n\n";
    $ContinueSession=1;
}

elseif($userinput=="*662*800*9*1*".$fullname."*".$nid){
    $response  = "GOSHEN ONLINE BANKING SYSTEM\n\n";

    $nid = substr($nid, 0, -1);
    $nidlen = strlen($nid);

    if($nidlen == 16){
        if (is_numeric($nid)) {
            $response .="Please enter your phone number.\n\n";
            $ContinueSession=1;
        }else{
            $response .="NID Card number should be only digits.\n\n";
            $ContinueSession=0;
        }
    }else{
        $response .="NID Card number should be 16 digits.\n\n";
        $ContinueSession=0;
    }
}
elseif($userinput=="*662*800*9*1*".$fullname."*".$nid."*".$phone){
    $response  = "GOSHEN ONLINE BANKING SYSTEM\n\n";

    $phone = substr($phone, 0, -1);
    $phonelen = strlen($phone);

    if($phonelen == 10){
        if (is_numeric($phone)) {
            $response .="Your account have been created successfully.\n\nThank you for banking with us.\n\n";
            $accountno = time();
            $mobilepin = rand(1000,9999);

            mysqli_query($connect,"INSERT INTO accounts(accountno, fullname, idcard, phone, mobilepin) VALUES ('$accountno', '$fullname', '$nid', '$phone', '$mobilepin')");
            
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.mista.io/sms',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array('to' => "25".$phone,'from' => 'OBS','unicode' => '0','sms' => "Hello ".$fullname."! Your GOSHEN account number is: ".$accountno." Mobile Banking PIN: ".$mobilepin." Thank you for banking with us. ",'action' => 'send-sms'),
                CURLOPT_HTTPHEADER => array(
                    'x-api-key: 34e3a485-323f-9ba4-8ef8-3f0ddcaa4a7a-bbd67d0a'
                ),
            ));

            $smsresponse = curl_exec($curl);

            curl_close($curl);
        }else{
            $response .="Phone number should be only digits.\n\n";
        }
    }else{
        $response .="Phone number should be 10 digits.\n\n";
    }

    $ContinueSession=0;
}

//Check Balance
elseif($userinput=="*662*800*9*2#"){
    $response  = "GOSHEN ONLINE BANKING SYSTEM\n\n";
    $response .="Enter your phone number\n\n";
    $ContinueSession=1;
}

elseif($userinput=="*662*800*9*2*".$phone){
    $response  = "GOSHEN ONLINE BANKING SYSTEM\n\n";
    $response .="Enter your mobile banking PIN\n\n";
    $ContinueSession=1;
}

elseif($userinput=="*662*800*9*2*".$phone."*".$mpin){

    $mpin = substr($mpin, 0, -1);
    $query_account = mysqli_query($connect,"SELECT * FROM accounts WHERE phone='$phone' AND mobilepin='$mpin'");
    $data_account = mysqli_fetch_array($query_account);

    $fullname = $data_account['fullname'];
    $balance = $data_account['balance'];
    $response  = "GOSHEN ONLINE BANKING SYSTEM\n\n";
    $response .="Hello ".$fullname."! Your account actual balance is ".$balance."Frw\n\nThank you for banking with us.\n\n";
    $ContinueSession=0;
}

//Transfer Money
elseif($userinput=="*662*800*9*3#"){
    $response  = "GOSHEN ONLINE BANKING SYSTEM\n\n";
    $response .="Enter your phone number\n\n";
    $ContinueSession=1;
}

elseif($userinput=="*662*800*9*3*".$phone){
    $response  = "GOSHEN ONLINE BANKING SYSTEM\n\n";
    $response .="Enter your mobile banking PIN\n\n";
    $ContinueSession=1;
}

elseif($userinput=="*662*800*9*3*".$phone."*".$mpin){

    $mpin = substr($mpin, 0, -1);
    $query_account = mysqli_query($connect,"SELECT * FROM accounts WHERE phone='$phone' AND mobilepin='$mpin'");
    $data_account = mysqli_fetch_array($query_account);

    $fullname = $data_account['fullname'];
    $response  = "GOSHEN ONLINE BANKING SYSTEM\n\n";
    $response .="Hello ".$fullname."! Enter account number to receive.\n\n";
    $ContinueSession=1;
}

elseif($userinput=="*662*800*9*3*".$phone."*".$mpin."*".$accountno){

    $response  = "GOSHEN ONLINE BANKING SYSTEM\n\n";
    $response .="Enter amount.\n\n";
    $ContinueSession=1;
}

elseif($userinput=="*662*800*9*3*".$phone."*".$mpin."*".$accountno."*".$amount){

    $query_account = mysqli_query($connect,"SELECT * FROM accounts WHERE accountno='$accountno'");
    $data_account = mysqli_fetch_array($query_account);

    $amount = substr($amount, 0, -1);
    $response  = "GOSHEN ONLINE BANKING SYSTEM\n\n";
    $response .="You are going to send ".$amount."Frw to ".$data_account['fullname']." whose account number is ".$accountno."\n\n";
    $response .="1. Confirm\n2. Cancel\n\n";
    $ContinueSession=1;
}

elseif($userinput=="*662*800*9*3*".$phone."*".$mpin."*".$accountno."*".$amount."*1#"){

    $query_account = mysqli_query($connect,"SELECT * FROM accounts WHERE accountno='$accountno'");
    $data_account = mysqli_fetch_array($query_account);
    $ob_rec = $data_account['balance'];
    $nb_rec = $ob_rec + $amount;

    $trdate = time();
    $dateTime = date('d/m/Y H:i', $trdate);

    mysqli_query($connect,"INSERT INTO transactions(type, account, ob, amount, balance, trdate) VALUES ('in', '$accountno', '$ob_rec', '$amount', '$nb_rec', '$trdate')");
    $query = mysqli_query($connect,"UPDATE accounts SET balance = '$nb_rec' WHERE accountno = '$accountno'");

    $curl = curl_init();

    $phone_rec = $data_account['phone'];
    $fullname = $data_account['fullname'];

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.mista.io/sms',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => array('to' => "25".$phone_rec,'from' => 'OBS','unicode' => '0','sms' => "Hello ".$fullname."! Your GOSHEN account has been credited with ".$amount."Frw, Your new balance is ".$nb_rec."Frw, Transaction Date/Time: ".$dateTime." Thank you for banking with us. ",'action' => 'send-sms'),
      CURLOPT_HTTPHEADER => array(
        'x-api-key: 34e3a485-323f-9ba4-8ef8-3f0ddcaa4a7a-bbd67d0a'
      ),
    ));

    $smsresponse = curl_exec($curl);

    curl_close($curl);

    $query_account = mysqli_query($connect,"SELECT * FROM accounts WHERE phone='$phone'");
    $data_account = mysqli_fetch_array($query_account);
    $account = $data_account['accountno'];
    $ob_send = $data_account['balance'];
    $nb_send = $ob_send - $amount;

    mysqli_query($connect,"INSERT INTO transfers(fromacc, toacc, ob, amount, balance, tdatetime) VALUES ('$account', '$accountno', '$ob_send', '$amount', '$nb_send', '$trdate')");
    $query = mysqli_query($connect,"UPDATE accounts SET balance = '$nb_send' WHERE accountno = '$account'");

    $phone_rec = $data_account['phone'];
    $fullname = $data_account['fullname'];

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.mista.io/sms',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => array('to' => "25".$phone_rec,'from' => 'OBS','unicode' => '0','sms' => "Hello ".$fullname."! You have transfered ".$amount."Frw to account: ".$accountno.", Your new balance is ".$nb_send."Frw, Transaction Date/Time: ".$dateTime." Thank you for banking with us. ",'action' => 'send-sms'),
      CURLOPT_HTTPHEADER => array(
        'x-api-key: 34e3a485-323f-9ba4-8ef8-3f0ddcaa4a7a-bbd67d0a'
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    $response  = "GOSHEN ONLINE BANKING SYSTEM\n\n";
    $response .="Hello ".$fullname."! You have transfered ".$amount."Frw to account: ".$accountno.", Your new balance is ".$nb_send."Frw, Transaction Date/Time: ".$dateTime." Thank you for banking with us.";
    $ContinueSession=0;
}

elseif($userinput=="*662*800*9*3*".$phone."*".$mpin."*".$accountno."*".$amount."*2#"){

    $response  = "GOSHEN ONLINE BANKING SYSTEM\n\n";
    $response .="Money Transfer canceled by the user.";
    $ContinueSession=0;
}

//Recover password
elseif($userinput=="*662*800*9*4#"){
    $response  = "GOSHEN ONLINE BANKING SYSTEM\n\n";
    $response .="Enter your phone number\n\n";
    $ContinueSession=1;
}

elseif($userinput=="*662*800*9*4*".$phone){
    $phone = substr($phone, 0, -1);

    $response  = "GOSHEN ONLINE BANKING SYSTEM\n\n";

    $query_account = mysqli_query($connect,"SELECT * FROM accounts WHERE phone='$phone'");
    $data_account = mysqli_num_rows($query_account);

    if($data_account > 0){
        $query_account = mysqli_query($connect,"SELECT * FROM accounts WHERE phone='$phone'");
        $data_account = mysqli_fetch_array($query_account);
        $fullname = $data_account['fullname'];
        $mobilepin = $data_account['mobilepin'];

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.mista.io/sms',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => array('to' => "25".$phone,'from' => 'OBS','unicode' => '0','sms' => "Hello ".$fullname."! Your GOSHEN Mobile Banking PIN is ".$mobilepin." Thank you for banking with us. ",'action' => 'send-sms'),
          CURLOPT_HTTPHEADER => array(
            'x-api-key: 34e3a485-323f-9ba4-8ef8-3f0ddcaa4a7a-bbd67d0a'
          ),
        ));

        $smsresponse = curl_exec($curl);

        curl_close($curl);
    
        $response .="Hello ".$fullname."! Your password has been recovered!\n\nThank you for banking with us.\n\n";
        $ContinueSession=0;
    }else{
        $response .="Your phone number is not registered.\n\n";
        $ContinueSession=0;
    }
}

$resp = array("sessionId"=>$sessionId,"message"=>$response,"ContinueSession"=>$ContinueSession);

echo json_encode($resp); 

?>