<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= htmlspecialchars($_ENV['APP_NAME']) ?></title>
</head>
<body>
	<form method="POST" action="/register">
		<input name="name" placeholder="Nome">
		<input name="email" placeholder="E-mail">
		<input name="password" type="password" placeholder="Senha">
		<button>Cadastrar</button>
	</form>
</body>
</html>