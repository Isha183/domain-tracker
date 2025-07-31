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
            width: 91%;
            margin: 100px auto;
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
            margin-left: 120px;
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

        .login-box input[type="text"]{
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
    </style>
</head>

<body>

    <div class="tracked-domains-section container">
        <!-- Header -->
        <div class="header">
            <h3>DOMAIN TRACKER</h3>
            <div class="nav-links">
                @php $current = (request()->path()); @endphp
                <a href="/" class="<?= $current == '/' ? 'active' : '' ?>">Domain Search</a>
                <a href="track"class="<?= $current == 'tracked' ? 'active' : '' ?>">Tracked Domains</a>
                <a href="login" class="sign-btn" style="color: #fff">Log In</a>
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
        <div>
            
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" placeholder="Name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
    
            <x-text-input id="email" placeholder="Enter Your Email"  class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
           

            <x-text-input id="password" class="block mt-1 w-full" type="password" placeholder="Password" 
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">

            <x-text-input id="password_confirmation" class="block mt-1 w-full" placeholder="Confirm Password" 
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            {{-- <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a> --}}

            <button type="submit" >
                {{ __('Register') }}
            </button>
        </div>

            <div class="signup-link">
                Already have an account?
                <a href="{{ route('login') }}">Log In</a>
            </div>
        </div>
    </div>
</body>

</html>





{{-- <x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}
