@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-2xl max-w-md mx-auto mt-10 transform transition duration-300 hover:shadow-3xl">
    <h2 class="text-2xl font-semibold text-center text-blue-700 mb-6">Login</h2>
    @if (session('success'))
    @endif
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror" required>
        </div>
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" id="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror" required>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300">Masuk</button>
        </div>
    </form>
    <p class="text-center mt-4 text-gray-600">Belum punya akun? <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Daftar di sini</a></p>
</div>
@endsection