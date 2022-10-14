<?php session_start();
include('connector.php');

if (isset($_POST['staffLogin'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];


	$query = mysqli_query($connect,"SELECT * FROM admin WHERE username='$username' AND password='$password'");
	$data = mysqli_num_rows($query);

	if ($data > 0) {
		$query = mysqli_query($connect,"SELECT * FROM admin WHERE username='$username' AND password='$password'");
		$row = mysqli_fetch_array($query);
		$_SESSION['gb_staff'] = $row['id'];
		$_SESSION['gb_staff_admin'] = $row['id'];

		echo"<script>window.location='panel/';</script>";
	} else {
		$query = mysqli_query($connect,"SELECT * FROM users WHERE email='$username' AND password='$password'");
		$data = mysqli_num_rows($query);

		if ($data > 0) {
			$query = mysqli_query($connect,"SELECT * FROM users WHERE email='$username' AND password='$password'");
			$row = mysqli_fetch_array($query);
			$_SESSION['gb_staff'] = $row['userid'];

			echo"<script>window.location='panel/';</script>";
		} else {
			echo"<script>window.location='staff.php?error=invalid';</script>";
		}
	}
}

if (isset($_POST['memberLogin'])) {
	$phone = $_POST['phone'];
	$mobilepin = $_POST['mobilepin'];

	$query = mysqli_query($connect,"SELECT * FROM accounts WHERE phone='$phone' AND mobilepin='$mobilepin'");
	$data = mysqli_num_rows($query);

	if ($data > 0) {
		$query = mysqli_query($connect,"SELECT * FROM accounts WHERE phone='$phone' AND mobilepin='$mobilepin'");
		$row = mysqli_fetch_array($query);
		$_SESSION['gb_member'] = $row['accountno'];

		echo"<script>window.location='member/';</script>";
	} else {
		echo"<script>window.location='index.php?error=invalid';</script>";
	}
}

if (isset($_POST['addNewUser'])) {
	$fullname = $_POST['fullname'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	
	mysqli_query($connect,"INSERT INTO users(fullname, phone, email, password) VALUES ('$fullname', '$phone', '$email', '$password')");
	echo"<script>window.location='panel/usersList.php?data=success';</script>";
}

if (isset($_GET['deleteUser'])) {
	$userid = $_GET['deleteUser'];
	
	$query = mysqli_query($connect,"UPDATE users SET deleted = 1 WHERE userid = '$userid'");
	echo"<script>window.location='panel/usersList.php?data=deleted';</script>";
}

if (isset($_POST['editUser'])) {
	$userid = $_POST['userid'];
	$fullname = $_POST['fullname'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];

	
	$query = mysqli_query($connect,"UPDATE users SET fullname = '$fullname', phone = '$phone', email = '$email' WHERE userid = '$userid'");
	echo"<script>window.location='panel/editUser.php?data=edited&userId=".$userid."';</script>";
}

if (isset($_POST['createAccount'])) {
	$fullname = $_POST['fullname'];
	$phone = $_POST['phone'];
	$idcard = $_POST['idcard'];

	$accountno = time();
	$mobilepin = rand(1000,9999);

	$query_id = mysqli_query($connect,"SELECT * FROM accounts WHERE idcard='$idcard'");
	$data_id = mysqli_num_rows($query_id);
	$query_phone = mysqli_query($connect,"SELECT * FROM accounts WHERE phone='$phone'");
	$data_phone = mysqli_num_rows($query_phone);

	if($data_id > 0){
		echo"<script>window.location='index.php?error=duplicateId';</script>";
	}elseif($data_phone > 0){
		echo"<script>window.location='index.php?error=duplicatePhone';</script>";
	}else{
		mysqli_query($connect,"INSERT INTO accounts(accountno, fullname, idcard, phone, mobilepin) VALUES ('$accountno', '$fullname', '$idcard', '$phone', '$mobilepin')");

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
		    'x-api-key: a02c7aaa-48a7-974d-901d-d6476d221271-152d9ab3'
		  ),
		));

		$response = curl_exec($curl);

		echo $response;

		curl_close($curl);

		echo"<script>window.location='index.php?data=accountCreated';</script>";
	}
}

if (isset($_POST['addNewTransaction'])) {
	$account = $_POST['account'];
	$type = $_POST['type'];
	$amount = $_POST['amount'];

	$query_account = mysqli_query($connect,"SELECT * FROM accounts WHERE accountno='$account'");
	$data_account = mysqli_fetch_array($query_account);
	if($data_account['deleted'] == 1){
		echo"<script>window.location='panel/addNewTransaction.php?data=adis';</script>";
	}else{
		$amaountvalidation = is_numeric($amount);

		if($amaountvalidation == 1){
			$trdate = time();
			$trdatealt = date('Y-m-d');
			$dateTime = date('d/m/Y H:i', $trdate);

			$query_account = mysqli_query($connect,"SELECT * FROM accounts WHERE accountno='$account'");
			$data_account = mysqli_fetch_array($query_account);
			$ob = $data_account['balance'];
			$fullname = $data_account['fullname'];
			$phone = $data_account['phone'];
			
			if($type == 'in'){
				$nb = $ob + $amount;
				mysqli_query($connect,"INSERT INTO transactions(type, account, ob, amount, balance, trdate, trdatealt) VALUES ('$type', '$account', '$ob', '$amount', '$nb', '$trdate', '$trdatealt')");
				$query = mysqli_query($connect,"UPDATE accounts SET balance = '$nb' WHERE accountno = '$account'");

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
				  CURLOPT_POSTFIELDS => array('to' => "25".$phone,'from' => 'OBS','unicode' => '0','sms' => "Hello ".$fullname."! Your GOSHEN account has been credited with ".$amount."Frw, Your new balance is ".$nb."Frw, Transaction Date/Time: ".$dateTime." Thank you for banking with us. ",'action' => 'send-sms'),
				  CURLOPT_HTTPHEADER => array(
				    'x-api-key: a02c7aaa-48a7-974d-901d-d6476d221271-152d9ab3'
				  ),
				));

				$response = curl_exec($curl);

				curl_close($curl);

				echo"<script>window.location='panel/transaction.php?data=success';</script>";
			}elseif($type == 'out'){
				if($amount > $ob){
					echo"<script>window.location='panel/transaction.php?data=neb';</script>";
				}else{
					$nb = $ob - $amount;
					mysqli_query($connect,"INSERT INTO transactions(type, account, ob, amount, balance, trdate, trdatealt) VALUES ('$type', '$account', '$ob', '$amount', '$nb', '$trdate', '$trdatealt')");
					$query = mysqli_query($connect,"UPDATE accounts SET balance = '$nb' WHERE accountno = '$account'");

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
					  CURLOPT_POSTFIELDS => array('to' => "25".$phone,'from' => 'OBS','unicode' => '0','sms' => "Hello ".$fullname."! Your GOSHEN account has been debited with ".$amount."Frw, Your new balance is ".$nb."Frw, Transaction Date/Time: ".$dateTime." Thank you for banking with us. ",'action' => 'send-sms'),
					  CURLOPT_HTTPHEADER => array(
					    'x-api-key: a02c7aaa-48a7-974d-901d-d6476d221271-152d9ab3'
					  ),
					));

					$response = curl_exec($curl);

					curl_close($curl);

					echo"<script>window.location='panel/transaction.php?data=success';</script>";
				}
			}
		}else{
			echo"<script>window.location='panel/addNewTransaction.php?data=anv';</script>";
		}
	}
}

if (isset($_POST['recover'])) {
	$phone = $_POST['phone'];
	
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
		    'x-api-key: a02c7aaa-48a7-974d-901d-d6476d221271-152d9ab3'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
	
		echo"<script>window.location='forgot.php?data=success';</script>";
	}else{
		echo"<script>window.location='forgot.php?error=pna';</script>";
	}
}

if (isset($_POST['editMember'])) {
	$accountno = $_POST['accountno'];
	$fullname = $_POST['fullname'];
	$idcard = $_POST['idcard'];
	$phone = $_POST['phone'];

	
	$query = mysqli_query($connect,"UPDATE accounts SET fullname = '$fullname', phone = '$phone', idcard = '$idcard' WHERE accountno = '$accountno'");
	echo"<script>window.location='panel/editMember.php?data=edited&account=".$accountno."';</script>";
}

if (isset($_GET['deleteAccount'])) {
	$account = $_GET['deleteAccount'];
	
	$query = mysqli_query($connect,"UPDATE accounts SET deleted = 1 WHERE accountno = '$account'");
	echo"<script>window.location='panel/membersList.php?data=deleted';</script>";
}

if (isset($_GET['activateAccount'])) {
	$account = $_GET['activateAccount'];
	
	$query = mysqli_query($connect,"UPDATE accounts SET deleted = 0 WHERE accountno = '$account'");
	echo"<script>window.location='panel/membersList.php?data=activated';</script>";
}

if (isset($_POST['addNewTranfer'])) {
	$accountnumber = $_POST['accountnumber'];
	$amount = $_POST['amount'];
	
	$query_account = mysqli_query($connect,"SELECT * FROM accounts WHERE accountno='$accountnumber'");
	$data_account = mysqli_fetch_array($query_account);
	
	echo"<script>window.location='member/addNewTransfer?account=".$accountnumber."&amount=".$amount."&accountname=".$data_account['fullname']."';</script>";
	
}

if (isset($_GET['confirmTransfer'])) {
	$account= $_SESSION['gb_member'];
	$accountnumber = $_GET['accountnumber'];
	$amount = $_GET['amount'];
	
	$query_account = mysqli_query($connect,"SELECT * FROM accounts WHERE accountno='$accountnumber'");
	$data_account = mysqli_fetch_array($query_account);
	$ob_rec = $data_account['balance'];
	$nb_rec = $ob_rec + $amount;

	$trdate = time();
	$dateTime = date('d/m/Y H:i', $trdate);

	mysqli_query($connect,"INSERT INTO transactions(type, account, ob, amount, balance, trdate) VALUES ('in', '$accountnumber', '$ob_rec', '$amount', '$nb_rec', '$trdate')");
	$query = mysqli_query($connect,"UPDATE accounts SET balance = '$nb_rec' WHERE accountno = '$accountnumber'");

	$curl = curl_init();

	$phone = $data_account['phone'];
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
	  CURLOPT_POSTFIELDS => array('to' => "25".$phone,'from' => 'OBS','unicode' => '0','sms' => "Hello ".$fullname."! Your GOSHEN account has been credited with ".$amount."Frw, Your new balance is ".$nb_rec."Frw, Transaction Date/Time: ".$dateTime." Thank you for banking with us. ",'action' => 'send-sms'),
	  CURLOPT_HTTPHEADER => array(
	    'x-api-key: a02c7aaa-48a7-974d-901d-d6476d221271-152d9ab3'
	  ),
	));

	$response = curl_exec($curl);

	curl_close($curl);

	$query_account = mysqli_query($connect,"SELECT * FROM accounts WHERE accountno='$account'");
	$data_account = mysqli_fetch_array($query_account);
	$ob_send = $data_account['balance'];
	$nb_send = $ob_send - $amount;

	mysqli_query($connect,"INSERT INTO transfers(fromacc, toacc, ob, amount, balance, tdatetime) VALUES ('$account', '$accountnumber', '$ob_send', '$amount', '$nb_send', '$trdate')");
	$query = mysqli_query($connect,"UPDATE accounts SET balance = '$nb_send' WHERE accountno = '$account'");

	$phone = $data_account['phone'];
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
	  CURLOPT_POSTFIELDS => array('to' => "25".$phone,'from' => 'OBS','unicode' => '0','sms' => "Hello ".$fullname."! You have transfered ".$amount."Frw to account: ".$accountnumber.", Your new balance is ".$nb_send."Frw, Transaction Date/Time: ".$dateTime." Thank you for banking with us. ",'action' => 'send-sms'),
	  CURLOPT_HTTPHEADER => array(
	    'x-api-key: a02c7aaa-48a7-974d-901d-d6476d221271-152d9ab3'
	  ),
	));

	$response = curl_exec($curl);

	curl_close($curl);

	echo"<script>window.location='member/transfers?data=success';</script>";
	
}

if (isset($_POST['changePassword'])) {
	$current = $_POST['current'];
	$new = $_POST['new'];

	$query_user = mysqli_query($connect,"SELECT * FROM users WHERE password = '$current' AND userid = '".$_SESSION['gb_staff']."'");
	$data_user = mysqli_num_rows($query_user);

	if($data_user > 0){
		$query = mysqli_query($connect,"UPDATE users SET password = '$new' WHERE userid = '".$_SESSION['gb_staff']."'");
		echo"<script>window.location='panel/change?data=changed';</script>";
	}else{
		echo"<script>window.location='panel/change?data=wcp';</script>";
	}
}
?>