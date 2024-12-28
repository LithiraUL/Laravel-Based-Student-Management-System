<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student</title>
</head>
<body>
    <h1>Update Student Info</h1>

    @if($errors->any())
        <div style="color: red;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('students.update', $student->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="{{ old('name', $student->name) }}" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="{{ old('email', $student->email) }}" required><br><br>

        <label for="age">Age:</label>
        <input type="number" name="age" id="age" value="{{ old('age', $student->age) }}" required><br><br>

        <button type="submit">Update</button>
    </form>

    <a href="{{ route('students.index') }}">Back to Students List</a>
</body>
</html>
