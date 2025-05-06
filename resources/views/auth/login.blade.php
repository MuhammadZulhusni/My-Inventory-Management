<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Login | Inventory Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Inventory Management System Dashboard" name="description" />
    <link rel="shortcut icon" href="{{asset('https://cdn-icons-png.flaticon.com/128/754/754822.png')}}">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center bg-cover bg-center" 
      style="background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url({{ asset('uploads/warehouse-bg.jpg') }});">
    
    <div class="w-full max-w-md px-4">
        <div class="bg-white rounded-xl shadow-2xl p-8 sm:p-10 transition-all duration-300 hover:shadow-3xl">
            <!-- Logo Header -->
            <div class="text-center mb-8">
                <div class="mb-6">
                    <i class="fas fa-warehouse text-4xl text-purple-600"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Inventory Control System</h2>
                <p class="text-gray-500 font-medium flex items-center justify-center gap-2">
                    <i class="fas fa-user-shield"></i> Restricted Admin Access
                </p>
            </div>

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Username Input -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user-tie text-gray-400"></i>
                        </div>
                        <input type="text" 
                               name="name"
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition-all"
                               placeholder="Admin username"
                               required>
                    </div>
                    @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Input -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" 
                               name="password"
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition-all"
                               placeholder="••••••••"
                               required>
                    </div>
                    @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-300 transform hover:scale-[1.02] shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                    <i class="fas fa-unlock-alt"></i>
                    Secure Login
                </button>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>