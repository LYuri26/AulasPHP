<!DOCTYPE html>
<html>
<head>
    <title>Lista de Compras</title>
</head>
<body>
    <h1>Lista de Compras</h1>
    <ul>
        @foreach($items as $item)
            <li>{{$item->name}} @if($item->bought) (Comprado) @endif
                <form method="post" action="{{ route('shopping.markAsBought', $item->id) }}" style="display: inline;">
                    @csrf
                    @method('PUT')
                    <button type="submit">Marcar como comprado</button>
                </form>
                <form method="post" action="{{ route('shopping.destroy', $item->id) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Remover</button>
                </form>
            </li>
        @endforeach
    </ul>
    <h2>Adicionar Item</h2>
    <form method="post" action="{{ route('shopping.store') }}">
        @csrf
        <input type="text" name="name" placeholder="Nome do item">
        <button type="submit">Adicionar</button>
    </form>
</body>
</html>
