<form action="{{ route('courses.store') }}" method="POST">
    @csrf
    <div>
        <label for="title">Título:</label>
        <input type="text" name="title" id="title" required>
    </div>
    <div>
        <label for="description">Descripción:</label>
        <textarea name="description" id="description" required></textarea>
    </div>
    <div>
        <label for="learnings">Aprendizajes:</label>
        <input type="text" name="learnings[]" required>
    </div>
    <button type="submit">Crear curso</button>
</form>
