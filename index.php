<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Goshen Banking</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans:600'>
  <link rel="stylesheet" href="css/style.css">

</head>
<body>
<!-- partial:index.partial.html -->
<div class="login-wrap">
	<div class="login-html">
		<div><center>
			<img src="images/logo.png" style="width:50%;">
		</center></div><br>
		<input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">Sign In</label>
		<input id="tab-2" type="radio" name="tab" class="sign-up"><label style="margin-bottom: 20px;" for="tab-2" class="tab">Create a new Account</label>
		<div class="login-form">
			
			<div class="sign-in-htm">
				<form method="POST" action="server.php">
					<div class="group">
						<label for="user" class="label">Enter your Mobile Phone number</label>
						<br>
						<input type="text" name="phone" class="input" required="" onkeypress="return allowNumbersOnly(event)">
					</div>
					<div class="group">
						<label for="user" class="label">Enter your Mobile Banking PIN</label>
						<br>
						<input type="password" name="mobilepin" class="input" required="" onkeypress="return allowNumbersOnly(event)">
					</div>
					<div class="group">
						<input type="submit" name="memberLogin" class="button" value="Sign In">
					</div>
					<br>
					<a href='forgot.php'><p>Forgot Mobile PIN?</p></a>
				</form>
				<div class="hr"></div>
				<div class="foot-lnk">
					<a href="staff"><label>STAFF</label></a>
				</div>
			</div>
			<?php
				if(isset($_GET['data']) AND $_GET['data'] == 'accountCreated'){
					echo"<p style='position: relative; top: -28px; color: #4cb214; background: #fff; padding: 3px 10px; border-radius: 15px; font-size: 14px; font-weight: normal; text-align: center;'>Acount is created successfully!</p>";
				}
				if(isset($_GET['error']) AND $_GET['error'] == 'duplicateId'){
					echo"<p style='position: relative; top: -28px; color: #f12b51; background: #fff; padding: 3px 10px; border-radius: 15px; font-size: 14px; font-weight: normal; text-align: center;'>ID number entered is actively used!</p>";
				}
				if(isset($_GET['error']) AND $_GET['error'] == 'duplicatePhone'){
					echo"<p style='position: relative; top: -28px; color: #f12b51; background: #fff; padding: 3px 10px; border-radius: 15px; font-size: 14px; font-weight: normal; text-align: center;'>Phone number entered is actively used!</p>";
				}
				if(isset($_GET['error']) AND $_GET['error'] == 'invalid'){
					echo"<p style='position: relative; top: -28px; color: #f12b51; background: #fff; padding: 3px 10px; border-radius: 15px; font-size: 14px; font-weight: normal; text-align: center;'>Invalid Phone number or PIN!</p>";
				}
			?>
			<form method="POST" action="server.php">
				<div class="sign-up-htm">
					<div class="group">
						<label for="user" class="label">Full Name</label>
						<input name="fullname" type="text" class="input" required>
					</div>
					<div class="group">
						<label for="pass" class="label">ID card Number</label>
						<input name="idcard" type="text" class="input" required maxlength="16" minlength="16" onkeypress="return allowNumbersOnly(event)">
					</div>
					<div class="group">
						<label for="pass" class="label">Phone Number</label>
						<input name="phone" type="text" class="input" required maxlength="10" minlength="10" onkeypress="return allowNumbersOnly(event)">
					</div>
					<div class="group">
						<input type="submit" class="button" name="createAccount" value="Create">
					</div>
					<div class="hr"></div>
					<div class="foot-lnk">
						<label for="tab-1">Already Member?</label>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
    function allowNumbersOnly(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
    } 
</script>
  
</body>
</html>
