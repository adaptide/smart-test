@extends('layout.dashboard')
@section('title', 'Admin Dashboard')
@section('content')
@use(App\Enums\Ticket\Status)
    <body class="bg-muted min-h-screen">
    <header class="bg-background border-b border-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-primary">Managment Tickets</h1>
            <div class="flex items-center gap-4 text-sm text-muted-foreground">
                <span>{{ auth()->user()->name }}</span>
                <a href="{{ route('logout') }}" class="text-primary hover:underline">Выход</a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-background rounded-lg border border-border p-6 shadow-sm">
                <h3 class="text-sm font-medium text-muted-foreground mb-2">Всего заявок</h3>
                <div class="text-3xl font-bold text-primary">{{ $statistics['total'] }}</div>
            </div>
            <div class="bg-background rounded-lg border border-border p-6 shadow-sm">
                <h3 class="text-sm font-medium text-muted-foreground mb-2">Новые</h3>
                <div class="text-3xl font-bold text-primary">{{ $statistics['new'] }}</div>
            </div>
            <div class="bg-background rounded-lg border border-border p-6 shadow-sm">
                <h3 class="text-sm font-medium text-muted-foreground mb-2">В работе</h3>
                <div class="text-3xl font-bold text-primary">{{ $statistics['in_progress'] }}</div>
            </div>
            <div class="bg-background rounded-lg border border-border p-6 shadow-sm">
                <h3 class="text-sm font-medium text-muted-foreground mb-2">Обработаны</h3>
                <div class="text-3xl font-bold text-primary">{{ $statistics['processed'] }}</div>
            </div>
        </div>

        <div class="bg-background rounded-lg border border-border p-6 shadow-sm mb-8">
            <form action="#" method="GET">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4 mb-4">
                    <div class="space-y-2">
                        <label for="email" class="text-sm font-medium text-foreground block">Email клиента</label>
                        <input 
                            type="text" 
                            id="email" 
                            name="email" 
                            placeholder="email@example.com"
                            class="w-full px-3 py-2 text-sm border border-input rounded-md bg-background text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                        />
                    </div>
                    <div class="space-y-2">
                        <label for="phone" class="text-sm font-medium text-foreground block">Телефон</label>
                        <input 
                            type="text" 
                            id="phone" 
                            name="phone" 
                            placeholder="+7..."
                            class="w-full px-3 py-2 text-sm border border-input rounded-md bg-background text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                        />
                    </div>
                    <div class="space-y-2">
                        <label for="status" class="text-sm font-medium text-foreground block">Статус</label>
                        <select 
                            id="status" 
                            name="status"
                            class="w-full px-3 py-2 text-sm border border-input rounded-md bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                        >
                            <option value="">Все статусы</option>
                            <option value="new">Новый</option>
                            <option value="in_progress">В работе</option>
                            <option value="processed">Обработан</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label for="date_from" class="text-sm font-medium text-foreground block">Дата от</label>
                        <input 
                            type="date" 
                            id="date_from" 
                            name="date_from"
                            class="w-full px-3 py-2 text-sm border border-input rounded-md bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                        />
                    </div>
                    <div class="space-y-2">
                        <label for="date_to" class="text-sm font-medium text-foreground block">Дата до</label>
                        <input 
                            type="date" 
                            id="date_to" 
                            name="date_to"
                            class="w-full px-3 py-2 text-sm border border-input rounded-md bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                        />
                    </div>
                </div>
                <div class="flex gap-3">
                    <button 
                        type="submit"
                        class="px-4 py-2 text-sm font-medium bg-primary text-primary-foreground rounded-md hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-ring transition-all"
                    >
                        🔍 Применить фильтры
                    </button>
                    <a 
                        href="{{ route('admin.tickets.index') }}"
                        class="px-4 py-2 text-sm font-medium bg-secondary text-secondary-foreground rounded-md hover:bg-secondary/80 focus:outline-none focus:ring-2 focus:ring-ring transition-all inline-block"
                    >
                        ✕ Сбросить
                    </a>
                </div>
            </form>
        </div>

        <div class="bg-background rounded-lg border border-border shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-muted border-b border-border">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-muted-foreground uppercase tracking-wider">ID</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-muted-foreground uppercase tracking-wider">Клиент</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-muted-foreground uppercase tracking-wider">Контакты</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-muted-foreground uppercase tracking-wider">Тема</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-muted-foreground uppercase tracking-wider">Статус</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-muted-foreground uppercase tracking-wider">Дата создания</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-muted-foreground uppercase tracking-wider">Действия</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @foreach ($tickets as $ticket)
                        <tr class="hover:bg-muted/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-semibold text-foreground">#{{ $ticket->id }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-foreground">
                                {{ $ticket->customer->name }}
                            </td>
                            <td class="px-6 py-4 text-sm text-foreground">
                                <div>{{ $ticket->customer->email }}</div>
                                <div class="text-muted-foreground">{{ $ticket->customer->phone }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-foreground">
                                {{ $ticket->subject}}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{Status::getBadgeClass($ticket->status)}}">
                                    {{ Status::getLabel($ticket->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-muted-foreground">
                                {{ $ticket->created_at->format('d.m.Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('admin.tickets.show', $ticket) }}" class="text-primary hover:underline font-medium text-sm">
                                    👁 Просмотр
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="flex items-center justify-center gap-2 px-6 py-4 border-t border-border">
                <a href="#" class="px-3 py-2 text-sm border border-border rounded-md text-muted-foreground hover:bg-muted transition-colors">
                    Предыдущая
                </a>
                <a href="#" class="px-3 py-2 text-sm border border-primary bg-primary text-primary-foreground rounded-md">
                    1
                </a>
                <a href="#" class="px-3 py-2 text-sm border border-border rounded-md text-primary hover:bg-muted transition-colors">
                    2
                </a>
                <a href="#" class="px-3 py-2 text-sm border border-border rounded-md text-primary hover:bg-muted transition-colors">
                    3
                </a>
                <a href="#" class="px-3 py-2 text-sm border border-border rounded-md text-muted-foreground hover:bg-muted transition-colors">
                    Следующая
                </a>
            </div>
        </div>
    </main>
</body>
@endsection