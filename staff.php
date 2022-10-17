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
		<input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab" style="margin-bottom: 20px;">Staff Sign In</label>
		<input id="tab-2" type="radio" name="tab" class="sign-up"><label style="display: none;" for="tab-2" class="tab">Create a new Account</label>
		<div class="login-form">
			<?php
			if(isset($_GET['error'])){
				if($_GET['error'] == 'invalid'){
					echo"<p style='position: relative; top: -28px; color: #f12b51; background: #fff; padding: 3px 10px; border-radius: 15px; font-size: 14px; font-weight: normal; text-align: center;'>Invalid username or password!</p>";
				}
			}
			?>
			<form method="POST" action="server.php">
				<div class="sign-in-htm">
					<div class="group">
						<label for="user" class="label">Enter your Username</label>
						<br>
						<input id="user" type="text" class="input" required="" name="username">
					</div>
					<div class="group">
						<label for="user" class="label">Enter your Password</label>
						<br>
						<input id="user" type="password" class="input" required="" name="password">
					</div>
					<div class="group">
						<input type="submit" class="button" name="staffLogin" value="Sign In">
					</div>
					<div class="hr"></div>
					<div class="foot-lnk">
						<a href="index"><label>CUSTOMER</label></a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- partial -->
  
</body>
</html>
