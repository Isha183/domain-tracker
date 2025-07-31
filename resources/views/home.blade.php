{{-- <h1>domain tracker</h1>
@foreach ($domains as $domain)
<h2>{{$domain['Domain']}}</h2>
@endforeach --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Domain Tracker</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
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
            margin-top: 15px
        }

        .header h3 {
            font-size: 1.4rem;
            font-weight: bold;
        }

        .domain-form {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
        }

        #domain-input {
            width: 400px;
            padding: 14px 20px;
            font-size: 16px;
            border: 2px solid #adc6ff;
            border-radius: 30px 0 0 30px;
            outline: none;
            background-color: #e3ecff;
        }

        .search-btn {
            padding: 14px 20px;
            background-color: #3e507c;
            border: 2px solid #3e507c;
            color: white;
            font-size: 18px;
            border-radius: 0 30px 30px 0;
            cursor: pointer;
            transition: background 0.3s;
        }

        .search-btn:hover {
            background-color: #2c3e6e;
        }

        .results-section h2 {
            font-size: 1.2rem;
            font-weight: bold;
        }

        .results-table {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem 2rem;
            padding: 1rem;
            background-color: #fdfdfd;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .results-table div {
            margin: 0.2rem 0;
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

        .track-btn {
            background-color: #4c5eff;
            color: #fff;
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            margin-top: 5px;
            margin-left: auto%;
        }

        .track-btn:hover {
            background-color: #2e3edb;
        }

        .line {
            height: 1px;
            background-color: #aaa;
            margin: 1rem 0;
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

        .modal {
            display: none;
            position: fixed;
            z-index: 10;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 50px;
            border-radius: 10px;
            width: 300px;
            text-align: center;
            position: relative;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .close {
            position: absolute;
            top: 10px;
            right: 15px;
            cursor: pointer;
            font-size: 20px;
        }

        .display {
            display: flex;
        }

        .form-style{
            margin-bottom: 15px;
            border:1px solid;
            border-radius:5px;
            margin-top:5px
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


        <!-- Search Section -->
        <div>
            <form id="form" class="domain-form" method="GET" action="/">
                <input type="text" name="domain" id="domain-input" placeholder="Search for a Domain" required />
                <button type="submit" class="search-btn">🔍</button>
            </form>

        </div>

        <!-- Results Section -->
        <div class="results-section">
            <h2><strong>Search Results</strong></h2>
            <div class="line"></div>
            <div class="display">
                <div>
                    @if (isset($error))
                        <p class="error">{{ $error }}</p>
                    @elseif(isset($domain))
                        <h3><strong>Results for: </strong>{{ $domain }}</h3>
                        <ul>
                            <li><strong>Created: </strong> {{ $created ?? 'N/A' }}</li>
                            <li><strong>Expires: </strong> {{ $expires ?? 'N/A' }}</li>
                            <li><strong>Updated: </strong> {{ $updated ?? 'N/A' }}</li>
                            <li><strong>Owner: </strong> {{ $owner ?? 'N/A' }}</li>
                            <li><strong>Registrar: </strong> {{ $registrar ?? 'N/A' }}</li>
                        </ul>
                    @endif
                </div>
                @if (isset($domain))
                    @guest
                        <div style="margin-left: 30%">
                            <button class="track-btn" onclick="window.location.href='{{ route('login') }}'">Track
                                Domain</button>
                        </div>
                    @endguest

                    @auth
                        <div style="margin-left: 30%">
                            <button class="track-btn"
                                onclick="openModal('{{ $domain }}', '{{ $expires }}')">Track Domain</button>
                        </div>
                    @endauth
                @endif
            </div>
        </div>


        <div id="trackModal" class="modal" action="{{ route('track.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h2 style="margin-bottom: 15px">Track Domain Expiry</h2>
                <form id="trackForm" action="{{ route('track.store') }}" method="POST">
                    @csrf
                    <input type="hidden" id="trackDomainHidden" name="domain" value="{{ $domain ?? '' }}">
                    <input type="hidden" id="trackExpiryHidden" name="expiry" value="{{ $expires ?? '' }}">
                    <input class="form-style" type="email" id="email" name="email" placeholder=" Your Email" required value="{{ Auth::check() ? Auth::user()->email : '' }}">
                    <input class="form-style" type="number" id="notifyDays" name="days" placeholder=" Notify Before (e.g. 30)" required><br>
                    <button class="track-btn" type="submit">Start Tracking</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openModal(domain, expiry) {

            document.getElementById('trackDomainHidden').value = domain;
            document.getElementById('trackExpiryHidden').value = expiry;
            document.getElementById('trackModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('trackModal').style.display = 'none';
        }
    </script>
</body>

</html>
