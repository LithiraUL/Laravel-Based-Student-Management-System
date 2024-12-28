<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students List</title>
    <style>
        /* Styling for the table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        /* Button styles */
        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
        }

        .button:hover {
            background-color: #0056b3;
        }

        .button-danger {
            background-color: #dc3545;
        }

        .button-danger:hover {
            background-color: #c82333;
        }

        .search-form {
            margin-bottom: 20px;
        }

        .search-form input {
            padding: 8px;
            font-size: 16px;
            width: 200px;
        }

        .search-form button {
            padding: 8px 20px;
            font-size: 16px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-form button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h1>Welcome, {{ Auth::user()->name }}</h1>

    <h2>Students List</h2>

    <!-- Search Form -->
    <form action="{{ route('students.search') }}" method="GET" class="search-form">
        <label for="student_id">Find Student by ID:</label>
        <input type="number" name="student_id" id="student_id" placeholder="Enter Student ID" required>
        <button type="submit">Search</button>
    </form>

    <!-- Search Result -->
    @if(isset($searchResult))
        @if($searchResult)
            <div style="margin-top: 20px; padding: 10px; border: 1px solid #ddd; border-radius: 5px; background-color: #f9f9f9;">
                <h3>Search Result:</h3>
                <p><strong>ID:</strong> {{ $searchResult->id }}</p>
                <p><strong>Name:</strong> {{ $searchResult->name }}</p>
                <p><strong>Email:</strong> {{ $searchResult->email }}</p>
                <p><strong>Age:</strong> {{ $searchResult->age }}</p>
            </div>
        @else
            <p style="color: red;">No student found with the given ID.</p>
        @endif
    @endif

    <!-- Success Message -->
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif
    <!--Error Message-->
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    @if($students->isEmpty())
        <p>No students available.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Age</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr>
                        <td>{{ $student->id }}</td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->age }}</td>
                        <td>
                            <!-- Update Button -->
                            <a href="{{ route('students.edit', $student->id) }}" class="button">Update</a>

                            <!-- Delete Button -->
                            <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this student?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="button button-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Add New Student Button -->
    <a href="{{ route('students.create') }}" class="button">Add New Student</a>

    <!-- Logout Button -->
    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="button button-danger">Logout</a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</body>
</html>
