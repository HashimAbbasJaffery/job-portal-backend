          <x-auth>
            <section id="content">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2" for="email">
                        Email
                        </label>
                        <input name="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="text" placeholder="Email">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 font-bold mb-2" for="password">
                          Password
                        </label>
                        <input style="border: 1px solid red;" class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="******************">
                        <!-- <p class="text-red-500 text-xs italic">Please choose a password.</p> -->
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                      </div>
                      <div class="flex items-center justify-between">
                        <button type="submit" id="login-button" class="text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                          Log in
                        </button>
                        <a class="inline-block align-baseline font-bold hover:text-blue-800" href="#">
                          Forgot Password?
                        </a>
                      </div>
                </form>
            </section>
        </x-auth>

