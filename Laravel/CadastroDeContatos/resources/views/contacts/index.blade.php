<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Contatos</title>
</head>
<body>
    <h1>Listagem de Contatos</h1>
    <a href="{{ route('contacts.create') }}">Adicionar Contato</a>
    <ul>
        @foreach($contacts as $contact)
            <li>
                {{ $contact->name }} - {{ $contact->email }} - {{ $contact->phone }}
                <a href="{{ route('contacts.edit', $contact->id) }}">Editar</a>
                <form method="post" action="{{ route('contacts.destroy', $contact->id) }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Excluir</button>
                </form>
            </li>
        @endforeach
    </ul>
</body>
</html>
