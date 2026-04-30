<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= htmlspecialchars($_ENV['APP_NAME'] ?? 'SecureAuth PHP') ?></title>
</head>
<body>
	<form action="/login" method="POST">
		<input type="email" name="email" id="email">
		<input type="password" name="password" id="password">
		<button type="submit">Entrar</button>
	</form>
</body>
</html>