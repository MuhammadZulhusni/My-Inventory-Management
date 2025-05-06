<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Login | Family Mart Inventory</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Inventory Management System Dashboard" name="description" />
    <link rel="shortcut icon" href="https://cdn-icons-png.flaticon.com/128/754/754822.png">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-[#f4f8f6] h-screen flex items-center justify-center">

    <div class="w-full max-w-md px-4">
        <div class="bg-white rounded-2xl shadow-lg p-8 sm:p-10 border border-gray-200">
            <!-- Logo Header -->
            <div class="text-center mb-8">
                <img src="{{ asset('uploads/familymart-logo.png') }}"
                     alt="FamilyMart Logo" class="w-32 mx-auto mb-4">
                <h2 class="text-2xl font-bold text-gray-800">Inventory Login</h2>
                <p class="text-gray-500 text-sm mt-1">Authorized Staff Only</p>
            </div>

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Username Input -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                    <input type="text" name="name"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none"
                           placeholder="e.g., admin123" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Input -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none"
                           placeholder="••••••••" required>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-3 rounded-lg transition duration-300 ease-in-out shadow-md">
                    <i class="fas fa-sign-in-alt mr-2"></i> Login
                </button>
            </form>

            <!-- Optional Footer -->
            <div class="text-center mt-6 text-sm text-gray-400">
                &copy; {{ date('Y') }} Inventory System • FamilyMart Style
            </div>
        </div>
    </div>

</body>
</html>
