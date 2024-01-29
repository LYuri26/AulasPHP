<!-- resources/views/tasks/edit.blade.php -->

<h1>Editar Tarefa</h1>

<form action="{{ route('tasks.update', $task->id) }}" method="POST">
    @csrf
    @method('PUT')
    <label for="title">Título:</label><br>
    <input type="text" id="title" name="title" value="{{ $task->title }}"><br>
    <label for="description">Descrição:</label><br>
    <textarea id="description" name="description">{{ $task->description }}</textarea><br>
    <button type="submit">Atualizar Tarefa</button>
</form>
