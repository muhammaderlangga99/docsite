@extends('layout.dashboard')

@section('title', 'Dashboard')

@section('dashboard-content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Dashboard</h1>
            <p class="text-sm text-slate-500">Welcome back, {{ auth()->user()->name }}. Here’s a quick snapshot.</p>
        </div>
        <div class="inline-flex items-center gap-2 px-3 py-2 bg-slate-100 text-slate-700 rounded-lg text-sm">
            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
            Connected with Google
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="p-4 border border-slate-200 rounded-xl shadow-[0_10px_40px_-24px_rgba(15,23,42,0.4)] bg-gradient-to-br from-white to-slate-50">
            <p class="text-xs uppercase tracking-wide text-slate-500 mb-1">Docs viewed</p>
            <p class="text-2xl font-semibold text-slate-900">128</p>
        </div>
        <div class="p-4 border border-slate-200 rounded-xl shadow-[0_10px_40px_-24px_rgba(15,23,42,0.4)] bg-gradient-to-br from-white to-slate-50">
            <p class="text-xs uppercase tracking-wide text-slate-500 mb-1">Favorites</p>
            <p class="text-2xl font-semibold text-slate-900">12</p>
        </div>
        <div class="p-4 border border-slate-200 rounded-xl shadow-[0_10px_40px_-24px_rgba(15,23,42,0.4)] bg-gradient-to-br from-white to-slate-50">
            <p class="text-xs uppercase tracking-wide text-slate-500 mb-1">Alerts</p>
            <p class="text-2xl font-semibold text-slate-900">3</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 p-6 border border-slate-200 rounded-xl bg-white shadow-[0_10px_40px_-24px_rgba(15,23,42,0.4)]">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-slate-900">Recent activity</h2>
                <a href="#" class="text-sm text-blue-600 hover:text-blue-700">View all</a>
            </div>
            <ul class="divide-y divide-slate-100">
                <li class="py-3 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-900">Updated “Payment Webhook”</p>
                        <p class="text-xs text-slate-500">2 hours ago</p>
                    </div>
                    <span class="text-xs px-2 py-1 rounded-full bg-emerald-50 text-emerald-700">Published</span>
                </li>
                <li class="py-3 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-900">Commented on “CashPortal API”</p>
                        <p class="text-xs text-slate-500">Yesterday</p>
                    </div>
                    <span class="text-xs px-2 py-1 rounded-full bg-slate-100 text-slate-600">Note</span>
                </li>
                <li class="py-3 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-900">Bookmarked “Settlement Guide”</p>
                        <p class="text-xs text-slate-500">2 days ago</p>
                    </div>
                    <span class="text-xs px-2 py-1 rounded-full bg-amber-50 text-amber-700">Saved</span>
                </li>
            </ul>
        </div>

        <div class="p-6 border border-slate-200 rounded-xl bg-white shadow-[0_10px_40px_-24px_rgba(15,23,42,0.4)]">
            <h2 class="text-lg font-semibold text-slate-900 mb-4">Account</h2>
            <div class="space-y-3">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-slate-600">Name</span>
                    <span class="font-medium text-slate-900">{{ auth()->user()->name }}</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-slate-600">Email</span>
                    <span class="font-medium text-slate-900">{{ auth()->user()->email }}</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-slate-600">Provider</span>
                    <span class="font-medium text-emerald-700">Google</span>
                </div>
            </div>
        </div>
    </div>
@endsection
