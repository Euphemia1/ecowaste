<div class="space-y-6">
    <div>
        <h2 class="text-center text-3xl font-extrabold text-gray-900">
            Welcome Back
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            Sign in to your EcoWaste account
        </p>
    </div>

    <form class="space-y-6" action="/login" method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
        
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">
                Email Address
            </label>
            <div class="mt-1 relative">
                <input id="email" name="email" type="email" autocomplete="email" required 
                       class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"
                       placeholder="Enter your email">
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <i class="fas fa-envelope text-gray-400"></i>
                </div>
            </div>
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">
                Password
            </label>
            <div class="mt-1 relative">
                <input id="password" name="password" type="password" autocomplete="current-password" required 
                       class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"
                       placeholder="Enter your password">
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                    <button type="button" class="text-gray-400 hover:text-gray-600 focus:outline-none" onclick="togglePassword('password')">
                        <i id="password-icon" class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input id="remember_me" name="remember_me" type="checkbox" value="1"
                       class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                    Remember me
                </label>
            </div>

            <div class="text-sm">
                <a href="/forgot-password" class="font-medium text-green-600 hover:text-green-500">
                    Forgot your password?
                </a>
            </div>
        </div>

        <div>
            <button type="submit" 
                    class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                    <i class="fas fa-sign-in-alt text-green-500 group-hover:text-green-400"></i>
                </span>
                Sign In
            </button>
        </div>

        <div class="text-center">
            <span class="text-sm text-gray-600">Don't have an account?</span>
            <a href="/register" class="font-medium text-green-600 hover:text-green-500 ml-1">
                Sign up here
            </a>
        </div>
    </form>
</div>

<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '-icon');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>