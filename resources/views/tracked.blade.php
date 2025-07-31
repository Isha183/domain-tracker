<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Domain Tracker</title>
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

        .tracked-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .tracked-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .tracked-table th,
        .tracked-table td {
            text-align: center;
            padding: 12px 16px;
            border-bottom: 1px solid #ccc;
            font-size: 15px;
        }

        .tracked-table th {
            font-weight: bold;
            color: #333;
        }

        .tracked-table td .remove-icon {
            cursor: pointer;
            color: red;
            font-size: 18px;
            margin-left: 8px;
        }

        .tracked-table td .remove-icon:hover {
            color: darkred;
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

        .btn-3 {
            background: red;
            color: #fff;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-3:hover {
            background: darkred;
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
            font-size: 15px
        }

        .sign-btn:hover {
            background-color: #2e3edb;
        }
    </style>
</head>

<body>

    <div class="tracked-domains-section container">
        <div class="header">
            <h3>DOMAIN TRACKER</h3>
            <div class="nav-links">
                @php $current = (request()->path()); @endphp
                {{-- <a href="{{ route('dashboard') }}" > Dashboard </a> --}}
                <a href="/" class="{{ $current == '/' ? 'active' : '' }}">Domain Search</a>
                <a href="track" class="{{ $current == 'track' ? 'active' : '' }}">Tracked Domains</a>
                
                @guest
                    <!-- If user is NOT logged in -->
                    <a href="{{ route('login') }}" class="sign-btn" style="color: #fff;">Login</a>
                @endguest

                @auth
                    <!-- If user IS logged in -->
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="sign-btn">Logout</button>
                    </form>
                @endauth
            </div>

        </div>
    

    @if (session('success'))
        <p style="color: green; text-align:center;">{{ session('success') }}</p>
    @endif

    @if ($tracked->isEmpty())
        <p style="text-align:center; font-style: italic;">No domain to track</p>
    @else
        <table class="tracked-table">
            <thead>
                <tr>
                    <th>Tracked Domain</th>
                    <th>Email</th>
                    <th>Expiry Date</th>
                    <th>Notify Before</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tracked as $item)
                    <tr>
                        <td>{{ $item->domain }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->expiry)->toFormattedDateString() }}</td>
                        <td>{{ $item->notifyDays }} days</td>
                        <td>
                            <form method="POST" action="/untrack/{{ $item->domain }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-3">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    </div>

    <script src="js/app.js"></script>
</body>

</html>
