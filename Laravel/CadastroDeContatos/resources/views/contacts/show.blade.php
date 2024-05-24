<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Contato</title>
</head>
<body>
    <h1>Detalhes do Contato</h1>
    <p><strong>Nome:</strong> {{ $contact->name }}</p>
    <p><strong>Email:</strong> {{ $contact->email }}</p>
    <p><strong>Telefone:</strong> {{ $contact->phone }}</p>
    <a href="{{ route('contacts.index') }}">Voltar</a>
</body>
</html>
