<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="assets/reset.css" />
    <link rel="stylesheet" href="assets/style.css" />
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body class="login-page">
    <div id="wrapper" >
      <div class="login" id="login">
        <header class="login-header" style="display: flex">
          <img
            style="margin: 0 auto"
            src="assets/img/logo.png"
            width="60"
            alt=""
          />
          <!-- <div id="logo-detail">    
                        <h1>Techzeme</h1>
                    </div> -->
        </header>
        <section id="content">
          <form method="POST" action="{{ route('store_security_info') }}">
            @csrf

         
            <div class="mb-4">
              <label class="block text-gray-700 font-bold mb-2" for="address">
                Password
              </label>
               <input
                class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                id="password"
                name="password"
                type="password"
                style="{{ ($errors->get('password'))? 'border: 1px solid red' : "" }}"
              />
              <x-input-error :messages="$errors->get('password')" class="mt-2" />
        
            </div>
            <div class="mb-4">
              <label class="block text-gray-700 font-bold mb-2" for="address">
                Confirm Password
              </label>
               <input
                class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                style="{{ ($errors->get('password'))? 'border: 1px solid red' : "" }}"
              >
              <x-input-error :messages="$errors->get('confirm_password')" class="mt-2" />
        
            </div>
            <div class="flex items-center justify-between">
              <button
                style="width: 100%"
                id="login-button"
                class="text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                type="submit"
              >
                Register 
              </button>
            </div>
          </form>
        </section>
      </div>
    </div>
    <script src="assets/js/moving-effect.js"></script>
  </body>
</html>
