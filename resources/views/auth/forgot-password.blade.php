<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="shortcut icon" href="{{ asset('uploads/icon.jpeg') }}">
  <title>Forgot Password</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen px-4">
  <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-lg">
    <h1 class="text-3xl font-extrabold text-gray-900 mb-6 text-center">
      Forgot Your Password?
    </h1>
    <p class="text-gray-600 mb-8 text-center">
      No worries! Just enter your email below, and we’ll send you a link to reset your password.
    </p>

    <!-- Session status message placeholder -->
    <div id="statusMessage" class="hidden mb-4 text-center text-green-600 font-medium"></div>

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
      @csrf
      <div>
        <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
        <input
          id="email"
          name="email"
          type="email"
          required
          autofocus
          placeholder="you@example.com"
          class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
        />
        <!-- Error message placeholder -->
        <p class="mt-2 text-sm text-red-600" id="emailError"></p>
      </div>

      <button
        type="submit"
        class="w-full py-3 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 transition"
      >
        Send Password Reset Link
      </button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-500">
      Remember your password? <a href="/login" class="text-indigo-600 hover:underline">Login here</a>.
    </p>
  </div>
</body>
</html>
