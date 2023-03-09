<?php
include 'ch19.php';
//determine if they need to see the form or not
if (!$_POST) {
	//they need to see the form, so create the form block
	$display_block = <<<END_OF_BLOCK
	<form method="POST" action="$_SERVER[PHP_SELF]">
	
	<p><label for="email">Your E-Mail Address:</label><br/>
	<input type="email" id="email" name="email"
	size="40" maxlenght="150" /></p>
	
	<fieldset>
	<legend>Action:</legend><br/>
	<input type="radio" id="action_sub" name="action"
	value="sub" checked />
	<label for="action_sub">subscribe</label><br/>
	<input type="radio" id="action_unsub" name="action"
	value="unsub" />
	<label for="action_unsub">unsubscribe</label>
	</fieldset>
	
	<button type="'submit" class="button_1 name="submit" value="submit">Submit</button>
	</form>
	END_OF_BLOCK;
} else if (($_POST) && ($_POST['action'] == "sub")) {
	//trying to subscribe; validate email address
	if ($_POST['email'] == "") {
		echo "Go Back And Enter Your Email";
	} else {
		//connect to database
		doDB();
		
		//check that email is in list
		emailChecker($_POST['email']);
		
		//get number of results and do action
		if (mysqli_num_rows($check_res) < 1) {
			//free result
			mysqli_free_result($check_res);
			
			//add record
			$add_sql = $mysqli->prepare("INSERT INTO subscribers (email)
			VALUES(?)");
			$add_sql->bind_param("s", $_POST['email']);
			$add_sql->execute();
			//fetching result will go here, but will be covered later
			$add_sql->close();
			
			$display_block = "<p>Thanks for signing up!</p>";
			
			//close connection to mysql
			mysqli_close($mysqli);
		} else {
			//print failure message
			$display_block = "<p>You're already subscribe!</p>";
		}
	}
} else if (($_POST) && ($_POST['action'] == "unsub")) {
	//trying to unsubscribe; validate email address
	if ($_POST['email'] == "") {
		header("location: manage.php");
		exit;
	} else {
		//connect to database
		doDB();
		
		//check that email is in list
		emailChecker($_POST['email']);
		
		//get number of results and do action
		if (mysqli_num_rows($check_res) < 1) {
			//free result
			mysqli_free_result($check_res);
			
			//print failure message
			$display_block = "<p>Couldn't find your adddress!</p>
			<p>No action was taken.</p>";
		} else {
			//get value of id from result
			while ($row = mysqli_fetch_array($check_res)) {
			$id = $row['id'];
			}
			
			//unsubscribe the address
			$del_sql = "DELETE FROM subscribers
			WHERE id = ".$id;
			$del_res = mysqli_query($mysqli, $del_sql)
			or die(mysqli_error($mysqli));
			$display_block = "<p>You're unsubscribed!</p>";
		}
		mysqli_close($mysqli);
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Subscribe/Unsubscribe to a Mailing List</title>
</head>
<body>
<h1>Subscribe To Our Newsletter</h1>
<?php echo "$display_block"; ?>
</body>
</html>