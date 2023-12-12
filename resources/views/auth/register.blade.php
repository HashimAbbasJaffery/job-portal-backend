<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Register</title>
    
        <link rel="icon" type="image/x-icon" href="/assets/logo.png">
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
          <form method="POST" action="{{ route('check_uuid') }}">
            @csrf

         
            <div class="mb-4">
              <label class="block text-gray-700 font-bold mb-2" for="address">
                Registration Code
              </label>
               <input
                class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                id="registration_code"
                name="registration_code"
                type="text"
                style="{{ ($errors->get('registration_code'))? 'border: 1px solid red' : "" }}"
              />
              <x-input-error :messages="$errors->get('registration_code')" class="mt-2" />
        
            </div>
            <div class="flex items-center justify-between">
              <button
                style="width: 100%"
                id="login-button"
                class="text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                type="submit"
              >
                Next 
              </button>
            </div>
          </form>
        </section>
      </div>
    </div>
    <script src="assets/js/moving-effect.js"></script>
  </body>
</html>
