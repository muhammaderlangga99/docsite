@extends('layout.app')

@section('title', 'Login')

@section('content')
<div class="container mx-auto py-16 px-4">
    <div class="max-w-md mx-auto bg-white border border-gray-200 rounded-lg p-8 shadow-sm">
        <h1 class="text-2xl font-semibold mb-6 text-center">Sign in</h1>

        <div class="space-y-4">
            <a href="{{ route('auth.google.redirect') }}"
               class="w-full inline-flex items-center justify-center gap-3 px-4 py-3 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                <svg class="w-5 h-5" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path fill="#EA4335" d="M24 9.5c3.12 0 5.89 1.07 8.09 2.83l6.06-6.06C34.32 2.86 29.47 1 24 1 14.64 1 6.44 6.24 2.63 14l7.56 5.87C11.73 14.26 17.33 9.5 24 9.5z"/>
                    <path fill="#4285F4" d="M46.5 24.5c0-1.64-.15-3.22-.43-4.75H24v9h12.55c-.54 2.7-2.16 4.98-4.58 6.51l7.11 5.53C43.78 36.35 46.5 30.88 46.5 24.5z"/>
                    <path fill="#FBBC05" d="M10.19 28.13c-.5-1.47-.77-3.04-.77-4.63 0-1.59.27-3.16.77-4.63l-7.56-5.87C1.91 15.4 1 19.07 1 23.5s.91 8.1 2.63 11.5l7.56-5.87z"/>
                    <path fill="#34A853" d="M24 46c5.47 0 10.08-1.8 13.44-4.89l-7.11-5.53c-2 1.34-4.56 2.12-7.33 2.12-6.67 0-12.27-4.76-13.81-11.37l-7.56 5.87C6.44 41.76 14.64 47 24 47z"/>
                    <path fill="none" d="M1 1h46v46H1z"/>
                </svg>
                <span>Sign in with Google</span>
            </a>
        </div>
    </div>
</div>
@endsection
