@extends('layout.dashboard')
@section('title', 'Вход - CRM')
@section('content')
<body class="bg-muted min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-background rounded-lg shadow-lg border border-border p-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-foreground mb-2">Добро пожаловать</h1>
            </div>

            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                @method('post')
                <div class="space-y-2">
                    <label for="email" class="text-sm font-medium text-foreground block">
                        Email
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        required
                        placeholder="example@email.com"
                        class="w-full px-3 py-2 border border-input rounded-md bg-background text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:border-transparent transition-all"
                    />
                    @error('email')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <label for="password" class="text-sm font-medium text-foreground block">
                            Пароль
                        </label>
                    </div>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required
                        placeholder="••••••••"
                        class="w-full px-3 py-2 border border-input rounded-md bg-background text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:border-transparent transition-all"
                    />
                </div>

                <div class="flex items-center">
                    <input 
                        type="checkbox" 
                        id="remember" 
                        name="remember"
                        class="h-4 w-4 rounded border-input text-primary focus:ring-2 focus:ring-ring"
                    />
                    <label for="remember" class="ml-2 text-sm text-foreground">
                        Запомнить меня
                    </label>
                </div>

                <button 
                    type="submit"
                    class="w-full bg-primary text-primary-foreground py-2.5 px-4 rounded-md font-medium hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 transition-all"
                >
                    Войти
                </button>
            </form>
        </div>
    </div>
</body>
@endsection