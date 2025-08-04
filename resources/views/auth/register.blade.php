<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Domain Tracker</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #3e507c;
            color: #333;
        }


        .container {
            max-width: 100%;

            margin: 100px 50px;
            /* top-bottom 100px, center horizontally */
            padding: 2rem 3rem;
            background-color: #fff;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.05);
            border-radius: 10px;
        }


        .tracked-domains-section {
            background-color: #fff;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }


        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .header h3 {
            font-size: 1.4rem;
            font-weight: bold;
        }

        .nav-links a {
            margin-left: 20px;
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .nav-links a:hover {
            color: #4c5eff;
        }

        .nav-links a.active {
            color: #4c5eff;
            font-weight: bold;
        }

        .sign-btn {
            background-color: #4c5eff;
            color: #fff;
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            margin-top: 5px;
            margin-left: 20px;
        }

        .sign-btn:hover {
            background-color: #2e3edb;
        }


        .login-box {
            background: white;
            padding: 40px 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            margin: 0px auto;
        }

        .login-box h2 {
            margin-bottom: 25px;
            color: #3e507c;
        }

        .login-box input[type="email"],
        .login-box input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #bbb;
            border-radius: 6px;
        }

        .login-box input[type="text"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #bbb;
            border-radius: 6px;
        }

        .login-box button {
            width: 100%;
            background-color: #3e507c;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        .login-box button:hover {
            background-color: #2d3f6b;
        }

        .login-box .signup-link {
            margin-top: 15px;
            display: block;
        }

        .login-box .signup-link a {
            color: #3e507c;
            text-decoration: none;
            font-weight: bold;
        }

        .login-box .signup-link a:hover {
            text-decoration: underline;
        }

        .hamburger {
            display: none;
            font-size: 26px;
            cursor: pointer;
            user-select: none;
            color: #000000;
        }

        @media (max-width: 900px) {
            .nav-container {
                position: relative;
            }

            .hamburger {
                display: block;
            }

            .nav-links {
                display: none;
                flex-direction: column;
                position: absolute;
                top: 40px;
                right: 0;
                background-color: #fff;
                border-radius: 6px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                padding: 1rem;
                z-index: 1000;
            }

            .nav-links a,
            .nav-links form {
                margin: 0.5rem 0;
                display: block;
            }

            .nav-links.show {
                display: flex;
            }

            .sign-btn {
                margin-left: 0px;
            }

        }

        @media (max-width: 480px) {

            h3 {
                font-size: 24px;
            }

            .container {
                padding: 1.5rem;
            }

            .form-style {
                width: 100%;
            }

            .sign-btn,
            .track-btn {
                width: 100%;
                text-align: center;
            }


            a,
            .sign-btn {
                margin-left: 0;
                margin-right: 10px;
                margin-top: 5px;
            }
        }
    </style>
</head>

<body>

    <div class="tracked-domains-section container">
        <!-- Header -->
        <div class="header">
            <h3>DOMAIN TRACKER</h3>
            <div class="nav-container">
                <div class="hamburger" onclick="toggleMenu()">☰</div>

                <div class="nav-links" id="navLinks">
                    @php $current = (request()->path()); @endphp
                    <a href="/" class="{{ $current == '/' ? 'active' : '' }}">Domain Search</a>
                    <a href="track" class="{{ $current == 'track' ? 'active' : '' }}">Tracked Domains</a>

                    @guest
                        <a href="{{ route('login') }}" class="sign-btn" style="color: #fff;">Login</a>
                    @endguest

                    @auth
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="sign-btn">Logout</button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>

        <div class="login-box">
            <h2>SignUp</h2>

            @if ($errors->any())
                <div style="color: red; margin-bottom: 1rem;">
                    <ul style="padding: 0; list-style: none;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- <form method="POST" action="{{ route('register') }}">
                @csrf
                <input type="email" name="name" placeholder="Name" required autofocus>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="password" placeholder="Confirm Password" required>

                <button type="submit">Sign Up</button>
            </form> --}}


            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mt-4">

                    <input id="name" class="block mt-1 w-full" type="text" name="name" placeholder="Name"
                        value="{{ old('name') }}" required autofocus autocomplete="name">
                    @if ($errors->has('name'))
                        <div class="mt-2 text-red-600">{{ $errors->first('name') }}</div>
                    @endif
                </div>

                <!-- Email Address -->
                <div class="mt-4">

                    <input id="email" class="block mt-1 w-full" type="email" name="email"
                        placeholder="Enter Your Email" value="{{ old('email') }}" required autocomplete="username">
                    @if ($errors->has('email'))
                        <div class="mt-2 text-red-600">{{ $errors->first('email') }}</div>
                    @endif
                </div>

                <!-- Password -->
                <div class="mt-4">

                    <input id="password" class="block mt-1 w-full" type="password" name="password"
                        placeholder="Password" required autocomplete="new-password">
                    @if ($errors->has('password'))
                        <div class="mt-2 text-red-600">{{ $errors->first('password') }}</div>
                    @endif
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">

                    <input id="password_confirmation" class="block mt-1 w-full" type="password"
                        name="password_confirmation" placeholder="Confirm Password" required
                        autocomplete="new-password">
                    @if ($errors->has('password_confirmation'))
                        <div class="mt-2 text-red-600">{{ $errors->first('password_confirmation') }}</div>
                    @endif
                </div>

                <div class="flex items-center justify-end mt-4 signup-link">

                    <button type="submit" style="margin-top: 5px;">
                        {{ __('Register') }}
                    </button>
                </div>

                <div class="signup-link">
                    Already have an account?
                    <a href="{{ route('login') }}">Log In</a>
                </div>
        </div>
    </div>
    <script>
        function toggleMenu() {
            const navLinks = document.getElementById('navLinks');
            navLinks.classList.toggle('show');
        }
    </script>
</body>

</html>
