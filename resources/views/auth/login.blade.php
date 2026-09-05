<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Login - Sales Visit Report</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5f6f8;
            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            width: 400px;
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo h1 {
            font-size: 25px;
            margin-bottom: 8px;
        }

        .logo p {
            color: #777;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
        }

        input:focus {
            outline: none;
            border-color: #555;
        }

        .remember {
            display: flex;
            gap: 8px;
            align-items: center;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .remember label {
            margin: 0;
            font-weight: normal;
        }

        button {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 8px;
            background: #111;
            color: white;
            font-size: 15px;
            cursor: pointer;
        }

        button:hover {
            opacity: .9;
        }

        .error {
            color: #dc2626;
            font-size: 13px;
            margin-top: 6px;
        }

        .demo {
            margin-top: 25px;
            padding: 15px;
            background: #f5f5f5;
            border-radius: 8px;
            font-size: 12px;
            color: #555;
        }
    </style>
</head>

<body>

    <div class="login-container">

        <div class="logo">
            <h1>Sales Visit Report</h1>
            <p>ADMIN PANEL</p>
        </div>

        <form action="{{ route('login') }}" method="POST">

            @csrf

            <div class="form-group">

                <label for="email">
                    Email
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Masukkan email"
                    required
                >

                @error('email')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="form-group">

                <label for="password">
                    Password
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Masukkan password"
                    required
                >

                @error('password')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="remember">

                <input
                    type="checkbox"
                    id="remember"
                    name="remember"
                    value="1"
                >

                <label for="remember">
                    Ingat saya
                </label>

            </div>

            <button type="submit">
                LOGIN
            </button>

        </form>

        <div class="demo">
            <strong>Akun Demo</strong><br><br>

            Admin:<br>
            admin@local.test / password

            <br><br>

            Sales:<br>
            salvia@local.test / password
        </div>

    </div>

</body>

</html>