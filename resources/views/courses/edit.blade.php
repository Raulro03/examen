<form action="{{ route('courses.update', $course) }}" method="POST">
    @csrf
    @method('PUT')
    <div>
        <label for="title">Título:</label>
        <input type="text" name="title" value="{{ $course->title }}" required>
    </div>
    <div>
        <label for="description">Descripción:</label>
        <textarea name="description" required>{{ $course->description }}</textarea>
    </div>
    <div>
        <label for="learnings">Aprendizajes:</label>
        <input type="text" name="learnings[]" value="{{ implode(',', $course->learnings) }}" required>
    </div>
    <button type="submit">Editar curso</button>
</form>
