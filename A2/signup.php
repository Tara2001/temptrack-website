<?php
// database connection code
// $con = mysqli_connect('localhost', 'database_user', 'database_password','database');

$con = mysqli_connect('localhost', 'root', '','signup');

if (mysqli_connect_errno()) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// get the post records
$Email = $_POST['email'];
$Password = $_POST['password'];
$Password = $_POST['password'];


// Now we check if the data was submitted, isset() function will check if the data exists.
if (!isset($Name, $Password, $Password)) {
	// Could not get the data that should have been sent.
	exit('Please complete the registration');
}
// Make sure the submitted registration values are not empty.
if (empty($Email) || empty($Password) || empty($Password)) {
	// One or more values are empty.
	exit('Please complete the registration');
}


// We need to check if the account with that username exists.
if ($stmt = $con->prepare('SELECT id, password FROM content WHERE email = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
	$stmt->bind_param('s', $Email);
	$stmt->execute();
	$stmt->store_result();
	// Store the result so we can check if the account exists in the database.
	if ($stmt->num_rows > 0) {
		// Username already exists
		echo 'Already registered, try another mail!';
	} else {
		// Insert new account
	}
	$stmt->close();
} else {
	// Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
	echo 'Could not prepare statement!';
}
$con->close();

// Username doesnt exists, insert new account
if ($stmt = $con->prepare('INSERT INTO content (email, password, password, activation_code) VALUES (?, ?, ?, ?)'))  {
	// We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
	$password = password_hash($Password, PASSWORD_DEFAULT);
    $uniqid = uniqid();
    $stmt->bind_param('ssss', $Email, $password, $password, $uniqid);
	$stmt->execute();
    $from    = 'noreply@yourdomain.com';
    $subject = 'content Activation Required';
    $headers = 'From: ' . $from . "\r\n" . 'Reply-To: ' . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
    // Update the activation variable below
    $activate_link = 'http://yourdomain.com/phplogin/activate.php?email=' . $Email . '&code=' . $uniqid;
    $message = '<p>Please click the following link to activate your account: <a href="' . $activate_link . '">' .
    $activate_link . '</a></p>';
    mail($Email, $subject, $message, $headers);
    echo 'Please check your email to activate your account!';
} 
else {
	// Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
	echo 'Could not prepare statement!';
}

if ($stmt = $con->prepare('SELECT id, password FROM content WHERE email = ?')) {
    if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        exit('Email is not valid!');
    }
    if (preg_match('/^[a-zA-Z0-9]+$/', $Password) == 0) {
        exit('Password is not valid!');
    }
    if (strlen($Password) > 20 || strlen($Password) < 8) {
        exit('Password must be between 8 and 20 characters long!');
    }
}


?>