<!DOCTYPE html> <html lang="en"> <head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Document</title>
<link rel="stylesheet" href="/assets/reset.css">
<link rel="stylesheet" href="/assets/style.css">
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="login-page">
    <div id="wrapper" class="h-full">
        <div class="login" id="login">
            <header class="login-header" style="display: flex;">
                <img style="margin: 0 auto;" src="/assets/img/logo.png" width="60" alt="">
                <!-- <div id="logo-detail">    
                        <h1>Techzeme</h1>
                    </div> -->
            </header>
            <x-auth-session-status class="mb-4" :status="session('status')" />
            <section id="content">
                <form method="POST" action="{{ route('password.email') }}">
                    <p style="margin-bottom: 10px;">
                        <i>
                            Forgot Password? Provide us your email associated to your account to recover your
                            password
                        </i>    
                    </p>
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2" for="email">
                            Email
                        </label>
                        <input name="email"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="email" type="text" placeholder="Email">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div class="flex items-center justify-between">
                        <button type="submit" id="login-button"
                            class="text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            type="button">
                            {{ __('Email Password Reset Link') }}
                        </button>
                    </div>
                </form>
            </section>
        </div>
    </div>
    <script src="/assets/js/moving-effect.js"></script>
</body>

</html>