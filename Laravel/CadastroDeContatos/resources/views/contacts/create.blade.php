<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Contato</title>
</head>
<body>
    <h1>Adicionar Contato</h1>
    <form method="post" action="{{ route('contacts.store') }}">
        @csrf
        <label for="name">Nome:</label>
        <input type="text" name="name" id="name" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <br>
        <label for="phone">Telefone:</label>
        <input type="text" name="phone" id="phone" required>
        <br>
        <button type="submit">Adicionar Contato</button>
    </form>
</body>
</html>
