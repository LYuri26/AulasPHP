<!-- resources/views/tasks/create.blade.php -->

<h1>Adicionar Nova Tarefa</h1>

<form action="{{ route('tasks.store') }}" method="POST">
    @csrf
    <label for="title">Título:</label><br>
    <input type="text" id="title" name="title"><br>
    <label for="description">Descrição:</label><br>
    <textarea id="description" name="description"></textarea><br>
    <button type="submit">Adicionar Tarefa</button>
</form>
