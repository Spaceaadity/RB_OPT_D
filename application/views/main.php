<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>The Glove Compartment</title>
	<link rel="stylesheet" href="/assets/style.css">
</head>
<body>
	<div class="header">
		<h2>Welcome!</h2>
	</div>
	<div class="flashdata">
		<p><?= $this->session->flashdata('errors') ?></p>
		<p><?= $this->session->flashdata('success') ?></p>

	</div>
	<div class="register">
		<form action="register" method="post">
			<fieldset>
				<legend>Register</legend>
				<p>
					<label>Name:</label>
					<input type="text" name="name">
				</p>
				<p>
					<label>Alias:</label>
					<input type="text" name="alias">
				</p>
				<p>
					<label>Email:</label>
					<input type="text" name="email">
				</p>
				<p>
					<label>Password:</label>
					<input type="password" name="password">
				</p>
				<p>
					<label>Confirm Password:</label>
					<input type="password" name="pass_conf">
				</p>
				<p>
					<label>Date of Birth</label>
					<input type="date" name="dob">
				</p>
				<input type="submit" value="Register">
			</fieldset>
		</form>
	</div>
	<div class="login">
		<form action="login" method="post">
			<fieldset>
				<legend>Login</legend>
				<p>
					<label>Email:</label>
					<input type="text" name="email">
				</p>
				<p>
					<label>Password:</label>
					<input type="password" name="password">
				</p>
				<input type="submit" value="Login">
			</fieldset>
		</form>
	</div>
</body>
</html>