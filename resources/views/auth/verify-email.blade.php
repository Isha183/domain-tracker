<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Email Verification</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #3e507c;
            color: #333;
        }


        .container {
            max-width: 100%;
            width: 84%;
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
            margin-top: 15px
        }

        .header h3 {
            font-size: 1.4rem;
            font-weight: bold;
        }


        .text-sm {
            font-size: 0.875rem;
        }

        .text-gray {
            color: #555;
        }

        .text-green {
            color: #16a34a;
            font-weight: 500;
        }

        .mail-button {
            background-color: #4c5eff;
            color: white;
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            margin-left: 250px;
        }

        .mail-button:hover {
            background-color: #2e3edb;
        }

        .link-btn {
            background: none;
            border: none;
            color: #555;
            text-decoration: underline;
            cursor: pointer;
            font-size: 0.875rem;
        }

        .flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
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
            font-size: 15px;
        }

        .sign-btn:hover {
            background-color: #2e3edb;
        }
    </style>
</head>

<body>
    <div class="container tracked-domains-section">
        <div class="header">
            <h3>DOMAIN TRACKER</h3>

            <div class="nav-links">

                @php $current = (request()->path()); @endphp
                <a href="/" class="<?= $current == '/' ? 'active' : '' ?>">Domain Search</a>
                <a href="track"class="<?= $current == 'tracked' ? 'active' : '' ?>">Tracked Domains</a>

                @guest
                    <!-- If user is NOT logged in -->
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
        <div style="text-align: center;">
            <h2 class="text-xl">Verify Your Email Address</h2>
            <div class="mb-4 text-sm text-gray">
                Thanks for signing in! You need verify your email if you want to track more than 3 domains. Clicking on the
                link to verify your email! If you didn’t receive the email, we will gladly send you another.
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 text-sm text-green">
                    A new verification link has been sent to the email address you provided during registration.
                </div>
            @endif

            <div class="flex" style="align-items: center">
                <form method="POST" action="{{ route('verification.send')}}">
                    @csrf
                    <button type="submit" class="mail-button">Resend Verification Email</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>




{{-- <x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout> --}}
