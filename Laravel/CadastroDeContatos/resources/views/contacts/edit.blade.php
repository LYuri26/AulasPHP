<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Contato</title>
</head>
<body>
    <h1>Editar Contato</h1>
    <form method="post" action="{{ route('contacts.update', $contact->id) }}">
        @csrf
        @method('PUT')
        <label for="name">Nome:</label>
        <input type="text" name="name" id="name" value="{{ $contact->name }}" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="{{ $contact->email }}" required>
        <br>
        <label for="phone">Telefone:</label>
        <input type="text" name="phone" id="phone" value="{{ $contact->phone }}" required>
        <br>
        <button type="submit">Atualizar Contato</button>
    </form>
</body>
</html>
