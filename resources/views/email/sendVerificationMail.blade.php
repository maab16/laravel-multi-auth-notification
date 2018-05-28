<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Verify Account</title>
</head>
<body>
	<h1>Dear {{$user->name}} ,</h1>												
	<p>Your account created successflly.Please <a href="{{route('verifyEmail',[$user->email,$user->verify_token])}}">Click here</a></p>
</body>
</html>