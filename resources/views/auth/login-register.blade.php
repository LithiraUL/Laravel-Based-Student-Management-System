<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register</title>
    <style>
        .form-toggle {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .form-toggle button {
            margin: 0 10px;
            padding: 10px 20px;
            border: none;
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }
        .form-toggle button.active {
            background-color: #0056b3;
        }
        .form-container {
            display: none;
            text-align: center;
        }
        .form-container.active {
            display: block;
        }
        form {
            display: inline-block;
            text-align: left;
        }
        input {
            display: block;
            width: 100%;
            margin: 10px 0;
            padding: 8px;
            font-size: 14px;
        }
        button {
            padding: 10px 20px;
            font-size: 14px;
            cursor: pointer;
        }
        .success-message {
            color: green;
            margin-bottom: 20px;
        }
        .error-message {
            color: red;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1><center>Welcome to the Student Management System Portal</center></h1>

    @if (session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    @if ($errors->has('login'))
        <p style="color:red">{{ $errors->first('login') }}</p>
    @endif

    <div class="form-toggle">
        <button id="login-btn" onclick="toggleForm('login')" class="active">Login</button>
        <button id="register-btn" onclick="toggleForm('register')">Register</button>
    </div>

    <!-- Login Form -->
    <div id="login-form" class="form-container active">
        <h2>Login</h2>
        @if ($errors->has('email') || $errors->has('password'))
            <p class="error-message">Invalid credentials. Please try again.</p>
        @endif
        <form action="{{ route('login-register') }}" method="POST">
            @csrf
            <input type="hidden" name="action" value="login"> <!-- Explicitly specify the action for login -->
            <label for="email">Email:</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            <button type="submit">Login</button>
        </form>
    </div>

    <!-- Registration Form -->
    <div id="register-form" class="form-container">
        <h2>Register</h2>
        @if ($errors->any())
            <p class="error-message">Please fix the errors below and try again.</p>
        @endif
        <form action="{{ route('login-register') }}" method="POST">
            @csrf
            <input type="hidden" name="action" value="register"> <!-- Explicitly specify the action for registration -->
            <label for="name">Name:</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
            @error('name')
                <p class="error-message">{{ $message }}</p>
            @enderror

            <label for="email">Email:</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <p class="error-message">{{ $message }}</p>
            @enderror

            <label for="password">Password:</label>
            <input type="password" name="password" required>
            @error('password')
                <p class="error-message">{{ $message }}</p>
            @enderror

            <label for="password_confirmation">Confirm Password:</label>
            <input type="password" name="password_confirmation" required>
            @error('password_confirmation')
                <p class="error-message">{{ $message }}</p>
            @enderror

            <button type="submit">Register</button>
        </form>
    </div>

    <script>
        function toggleForm(formType) {
            
            document.getElementById('login-form').classList.remove('active');
            document.getElementById('register-form').classList.remove('active');
            document.getElementById(`${formType}-form`).classList.add('active');

            // Update the button active state
            document.getElementById('login-btn').classList.remove('active');
            document.getElementById('register-btn').classList.remove('active');
            document.getElementById(`${formType}-btn`).classList.add('active');
        }

        
    </script>
</body>
</html>
