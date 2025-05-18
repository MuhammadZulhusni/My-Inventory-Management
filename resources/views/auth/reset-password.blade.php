<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="shortcut icon" href="{{ asset('uploads/icon.jpeg') }}">
  <title>Reset Password</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen px-4">
  <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-lg">
    <h1 class="text-3xl font-extrabold text-gray-900 mb-6 text-center">
      Reset Your Password
    </h1>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
      @csrf
      <!-- Password Reset Token -->
      <input type="hidden" name="token" value="{{ $request->route('token') }}" />

      <!-- Email Address -->
      <div>
        <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
        <input
          id="email"
          type="email"
          name="email"
          value="{{ old('email', $request->email) }}"
          required
          autofocus
          autocomplete="username"
          placeholder="you@example.com"
          class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
        />
        @error('email')
          <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <!-- Password -->
      <div>
        <label for="password" class="block text-gray-700 font-medium mb-2">New Password</label>
        <input
          id="password"
          type="password"
          name="password"
          required
          autocomplete="new-password"
          placeholder="********"
          class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
        />
        @error('password')
          <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <!-- Confirm Password -->
      <div>
        <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">Confirm Password</label>
        <input
          id="password_confirmation"
          type="password"
          name="password_confirmation"
          required
          autocomplete="new-password"
          placeholder="********"
          class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
        />
        @error('password_confirmation')
          <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <button
        type="submit"
        class="w-full py-3 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 transition"
      >
        Reset Password
      </button>
    </form>
  </div>
</body>
</html>
