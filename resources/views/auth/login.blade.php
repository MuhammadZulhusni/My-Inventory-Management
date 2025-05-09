<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Login | Family Mart Inventory</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="FamilyMart Inventory Management System" name="description" />
    <link rel="shortcut icon" href="{{ asset('uploads/icon.jpeg') }}">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        familymart: {
                            DEFAULT: '#ED1C24',
                            light: '#FF6B6B',
                            dark: '#C81010'
                        },
                        accent: '#FFD700'
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    },
                    boxShadow: {
                        'soft': '0 10px 30px -15px rgba(0, 0, 0, 0.1)',
                        'hard': '0 4px 20px -5px rgba(237, 28, 36, 0.2)'
                    }
                }
            }
        }
    </script>
    <style>
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }
        .bg-auth {
            background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ed1c24' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E"),
                        linear-gradient(to bottom right, #f8f9fa, #ffffff);
        }
        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(237, 28, 36, 0.15);
        }
    </style>
</head>

<body class="font-sans bg-auth min-h-screen flex items-center justify-center p-4">
    <!-- Decorative Elements -->
    <div class="fixed top-10 left-10 w-32 h-32 rounded-full bg-familymart-light opacity-10 -z-10 animate-float"></div>
    <div class="fixed bottom-20 right-20 w-40 h-40 rounded-full bg-familymart-light opacity-10 -z-10 animate-float" style="animation-delay: 2s;"></div>
    <div class="fixed top-1/3 right-1/4 w-24 h-24 rounded-full bg-accent opacity-10 -z-10 animate-float" style="animation-delay: 4s;"></div>

    <div class="w-full max-w-md">
        <!-- Login Card -->
        <div class="bg-white rounded-xl shadow-hard overflow-hidden transition-all duration-300 hover:shadow-xl">
            <!-- Brand Header -->
            <div class="bg-familymart py-4 px-6 text-center">
                <img src="{{ asset('uploads/familymart-logo.png') }}" 
                     alt="FamilyMart Logo" 
                     class="h-12 mx-auto filter brightness-0 invert">
                <h1 class="text-white text-xl font-bold mt-2">Inventory Portal</h1>
            </div>
            
            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="p-6 space-y-6">
                @csrf

                <!-- Username Field -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-user-circle mr-1 text-familymart"></i> Username
                    </label>
                    <div class="relative">
                        <input type="text" name="name" required
                               class="w-full px-4 py-3 pl-10 border border-gray-200 rounded-lg input-focus transition-all duration-200
                                      focus:border-familymart focus:ring-1 focus:ring-familymart-light"
                               placeholder="Enter your username">
                        <i class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-lock mr-1 text-familymart"></i> Password
                    </label>
                    <div class="relative">
                        <input type="password" name="password" required
                               class="w-full px-4 py-3 pl-10 border border-gray-200 rounded-lg input-focus transition-all duration-200
                                      focus:border-familymart focus:ring-1 focus:ring-familymart-light"
                               placeholder="••••••••">
                        <i class="fas fa-key absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <!-- <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" 
                               class="h-4 w-4 text-familymart focus:ring-familymart-light border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">
                            Remember me
                        </label>
                    </div>
                    <div class="text-sm">
                        <a href="#" class="font-medium text-familymart hover:text-familymart-dark">
                            Forgot password?
                        </a>
                    </div>
                </div> -->

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full bg-familymart hover:bg-familymart-dark text-white font-semibold 
                               py-3 px-4 rounded-lg transition duration-300 ease-in-out transform 
                               hover:scale-[1.02] active:scale-[0.98] shadow-md flex items-center justify-center">
                    <i class="fas fa-sign-in-alt mr-2"></i> Sign In
                </button>
            </form>

            <!-- Footer -->
            <div class="bg-gray-50 px-6 py-4 text-center border-t border-gray-100">
                <p class="text-xs text-gray-500">
                    <i class="fas fa-shield-alt mr-1 text-familymart"></i> Secure login
                    &bull; 
                    <span class="text-familymart font-medium">v{{ config('app.version', '1.0.0') }}</span>
                </p>
                <p class="text-xs text-gray-400 mt-1">
                    &copy; {{ date('Y') }} FamilyMart Inventory System. All rights reserved.
                </p>
            </div>
        </div>

        <!-- System Status -->
        <div class="mt-4 text-center">
            <div class="inline-flex items-center text-xs text-gray-500 bg-white rounded-full px-3 py-1 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-green-500 mr-2 animate-pulse"></span>
                System status: Operational
            </div>
        </div>
    </div>
</body>
</html>