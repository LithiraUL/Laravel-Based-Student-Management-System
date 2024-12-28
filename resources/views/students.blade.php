<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students</title>
    <style>
        .button {
            margin: 10px;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .button-danger {
            background-color: #FF4F4F;
        }

        .button-danger:hover {
            background-color: #FF1C1C;
        }

        .input-group {
            margin-bottom: 20px;
        }

        input[type="text"] {
            padding: 5px;
            width: 200px;
        }

        button {
            padding: 5px 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 3px;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Students</h1>

    <!-- Add Student Button -->
    <a href="{{ route('students.create') }}" class="button">Add Student</a>

    <!-- Search by ID Form -->
    <form method="GET" action="{{ route('students.index') }}" class="input-group">
        <label for="search_id">Search by ID: </label>
        <input type="text" name="search_id" id="search_id" placeholder="Enter Student ID" value="{{ request('search_id') }}">
        <button type="submit">Search</button>
    </form>

    <!-- Search Results -->
    @if (request('search_id'))
        <h2>Search Results for ID: {{ request('search_id') }}</h2>
        @if (!empty($students))
            <table border="1" style="margin-bottom: 20px;">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Age</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td>{{ $student['name'] }}</td>
                            <td>{{ $student['email'] }}</td>
                            <td>{{ $student['age'] }}</td>
                            <td>
                                <!-- Update Button -->
                                <a href="{{ route('students.edit', $student->id) }}" class="button">Update</a>

                                <!-- Delete Button - Only Visible to Admin -->
                                @if(Auth::user()->role === 'admin')
                                    <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this student?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="button button-danger">Delete</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No student found with the provided ID.</p>
        @endif
    @endif

    <!-- Display All Students -->
    <h2>All Students</h2>
    @if (!empty($students))
        <table border="1">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Age</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr>
                        <td>{{ $student['name'] }}</td>
                        <td>{{ $student['email'] }}</td>
                        <td>{{ $student['age'] }}</td>
                        <td>
                            <!-- Update Button -->
                            <a href="{{ route('students.edit', $student->id) }}" class="button">Update</a>

                            <!-- Delete Button - Only Visible to Admin -->
                            @if(Auth::user()->role === 'admin')
                                <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this student?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="button button-danger">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No students found.</p>
    @endif
</body>
</html>




