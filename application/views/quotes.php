<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Quotes - User Dashboard</title>
	<link rel="stylesheet" href="/assets/style.css">
</head>
<body>

	<div class="header">
		<h2 class="welcomeMsg">Welcome <?= $userdata['name'] ?>!</h2>
		<a href="logout">Logout</a>
	</div>
	<div class="allQuotes">
		<h3>Quotes you may like:</h3>
		<?php foreach ($quotes as $quote) { ?>
			<div class="quote">
				<p><b><?= $quote['origin'] ?></b><?= $quote['quote'] ?></p>
				<p>Posted by <?= $quote['posted_by'] ?></p>
				<form action="favorite/quote" method="post">
					<input type="hidden" name="user_id" value="<?= $userdata['id'] ?>">
					<input type="hidden" name="quote_id" value="<?= $quote['quote_id'] ?>">
					<input type="submit" value="Add to my list">
				</form>
			</div>
		<?php } ?>
	</div>
	<div class="favQuotes">
		<h3>Quotes on your list:</h3>
		<?php foreach ($favedQuotes as $quote) { ?>
			<div class="quote">
				<p><?= $quote['quote'] ?></p>
				<p>Posted by <?= $quote['posted_by'] ?></p>
				<form action="delete/quote" method="post">
					<input type="hidden" name="user_id" value="<?= $userdata['id'] ?>">
					<input type="hidden" name="quote_id" value="<?= $quote['quote_id'] ?>">
					<input type="submit" value="Remove from my list">
				</form>
			</div>
		<?php } ?>
	</div>
	<div class='addQuote'>
		<h4>Contribute a Quote</h4>
		<form action="add" method="post">
			<p>
				<label>Quoted By:</label>
				<input type='text' name="origin">
			</p>
			<p>
				<label>Quote:</label>
				<input type="textarea" name="quote">
			</p>
			<input type="submit" value="Submit">
		</form>
	</div>
</body>
</html>