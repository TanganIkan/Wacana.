<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../../public/css/output.css" />
    <title>Sign Up</title>
  </head>
  <body>
    <div
      class="w-full min-h-screen flex justify-center items-center bg-[#faf2ef]"
    >
      <main class="p-5 w-96">
        <div class="mb-4">
          <h1 class="text-4xl font-bold capitalize">sign up</h1>
          <p class="text-[#666467] text-sm">
            Create an account to get started.
          </p>
        </div>
        <form action="" method="post" class="flex flex-col gap-3 text-sm">
          <div>
            <label for="username" class="block mb-3 font-semibold capitalize"
              >email</label
            >
            <div class="relative">
              <input
                type="text"
                name="username"
                id="username"
                placeholder="Enter your Email"
                class="border border-black focus:outline-none px-3 py-3 w-full rounded-sm placeholder-[#666467]"
              />

              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
                class="absolute w-4 h-4 transform -translate-y-1/2 top-1/2 right-3"
              >
                <path
                  d="M1.5 8.67v8.58a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V8.67l-8.928 5.493a3 3 0 0 1-3.144 0L1.5 8.67Z"
                />
                <path
                  d="M22.5 6.908V6.75a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3v.158l9.714 5.978a1.5 1.5 0 0 0 1.572 0L22.5 6.908Z"
                />
              </svg>
            </div>
          </div>

          <div>
            <label for="username" class="block mb-3 font-semibold capitalize"
              >username</label
            >
            <div class="relative">
              <input
                type="text"
                name="username"
                id="username"
                placeholder="Create your Username"
                class="border border-black focus:outline-none px-3 py-3 w-full rounded-sm placeholder-[#666467]"
              />

              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
                class="absolute w-4 h-4 transform -translate-y-1/2 top-1/2 right-3"
              >
                <path
                  fill-rule="evenodd"
                  d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                  clip-rule="evenodd"
                />
              </svg>
            </div>
          </div>

          <div>
            <label for="username" class="block mb-3 font-semibold capitalize"
              >password</label
            >
            <div class="relative">
              <input
                type="password"
                name="password"
                id="password"
                placeholder="Create your Password"
                class="border border-black focus:outline-none px-3 py-3 w-full rounded-sm placeholder-[#666467]"
              />

              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
                class="absolute w-4 h-4 transform -translate-y-1/2 top-1/2 right-3"
              >
                <path
                  d="M3.53 2.47a.75.75 0 0 0-1.06 1.06l18 18a.75.75 0 1 0 1.06-1.06l-18-18ZM22.676 12.553a11.249 11.249 0 0 1-2.631 4.31l-3.099-3.099a5.25 5.25 0 0 0-6.71-6.71L7.759 4.577a11.217 11.217 0 0 1 4.242-.827c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113Z"
                />
                <path
                  d="M15.75 12c0 .18-.013.357-.037.53l-4.244-4.243A3.75 3.75 0 0 1 15.75 12ZM12.53 15.713l-4.243-4.244a3.75 3.75 0 0 0 4.244 4.243Z"
                />
                <path
                  d="M6.75 12c0-.619.107-1.213.304-1.764l-3.1-3.1a11.25 11.25 0 0 0-2.63 4.31c-.12.362-.12.752 0 1.114 1.489 4.467 5.704 7.69 10.675 7.69 1.5 0 2.933-.294 4.242-.827l-2.477-2.477A5.25 5.25 0 0 1 6.75 12Z"
                />
              </svg>
            </div>
          </div>

          <div>
            <button
              class="w-full bg-[#ae7aff] text-white py-3 capitalize border-black border rounded-sm hover:shadow-[3px_3px_0_0_black] font-semibold duration-200 mt-3"
            >
              create account
            </button>

            <div class="flex items-center gap-3 my-3">
              <span class="block w-full ml-10 border-t border-black"></span>
              <span>or</span>
              <span class="block w-full mr-10 border-t border-black"></span>
            </div>

            <button
              class="w-full bg-white text-black py-3 capitalize border-black border rounded-sm hover:shadow-[3px_3px_0_0_black] font-semibold duration-200"
            >
              sign in
            </button>
          </div>
        </form>
      </main>
    </div>
  </body>
</html>
