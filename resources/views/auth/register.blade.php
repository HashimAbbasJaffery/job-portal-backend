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
    <div id="wrapper" class="h-full">
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
          <form method="POST" action="{{ route('register') }}">
            @csrf

            <div style="display: flex">
              <div class="mb-4" style="width: 48%; margin-right: 4%">
                <label
                  class="block text-gray-700 font-bold mb-2"
                  for="first_name"
                >
                  First name
                </label>
                <input
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                  id="first_name"
                  type="text"
                  name="name"
                  style="{{ ($errors->get('name'))? 'border: 1px solid red' : "" }}"
                  placeholder="First name"
                />
                
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
        
              </div>
              <div class="mb-4" style="width: 48%">
                <label
                  class="block text-gray-700 font-bold mb-2"
                  for="last_name"
                >
                  Last name
                </label>
                <input
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                  id="last_name"
                  type="text"
                  name="last_name"
                  placeholder="Last name"
                style="{{ ($errors->get('last_name'))? 'border: 1px solid red' : "" }}"
                />
                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
        
              </div>
            </div>
            <div class="mb-4">
              <label class="block text-gray-700 font-bold mb-2" for="email">
                Email
              </label>
              <input
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="email"
                type="text"
                name="email"
                placeholder="Email"
                style="{{ ($errors->get('password'))? 'border: 1px solid red' : "" }}"
              />
              <x-input-error :messages="$errors->get('email')" class="mt-2" />
        
            </div>
            <div class="mb-4">
              <label class="block text-gray-700 font-bold mb-2" for="address">
                Address
              </label>
              <textarea
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="address"
                type="text"
                name="address"
                placeholder="Address"
                style="{{ ($errors->get('address'))? 'border: 1px solid red' : "" }}"
              ></textarea>
              <x-input-error :messages="$errors->get('address')" class="mt-2" />
        
            </div>
            <div>
              <label class="block text-gray-700 font-bold mb-2" for="password">
                Password
              </label>
              <input
                class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                id="password"
                name="password"
                type="password"
                style="{{ ($errors->get('password'))? 'border: 1px solid red' : "" }}"
              />
              
              <!-- <p class="text-red-500 text-xs italic">Please choose a password.</p> -->
            </div>
            <div class="mb-6">
              <label
                class="block text-gray-700 font-bold mb-2"
                for="confirm_pass"
              >
                Confirm Password
              </label>
              <input
                class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                id="confirm_pass"
                name="password_confirmation"
                type="password"
                style="{{ ($errors->get('password'))? 'border: 1px solid red' : "" }}"
              />
              <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
        
              <!-- <p class="text-red-500 text-xs italic">Please choose a password.</p> -->
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
