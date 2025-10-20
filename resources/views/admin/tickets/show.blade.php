<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Заявка #{{ $ticket->id }} - CRM</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f5f7fa;
            color: #333;
        }

        .header {
            background: white;
            padding: 20px 40px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 24px;
            color: #667eea;
        }

        .back-link {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .alert {
            padding: 16px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            padding: 24px;
            margin-bottom: 24px;
        }

        .card-header {
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 16px;
            margin-bottom: 20px;
        }

        .card-header h2 {
            font-size: 20px;
            color: #333;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 24px;
        }

        .info-item {
            padding: 16px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .info-label {
            font-size: 13px;
            color: #666;
            margin-bottom: 6px;
            font-weight: 500;
        }

        .info-value {
            font-size: 15px;
            color: #333;
            font-weight: 600;
        }

        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            display: inline-block;
        }

        .status-new { background: #e3f2fd; color: #1976d2; }
        .status-in_progress { background: #fff3e0; color: #f57c00; }
        .status-processed { background: #e8f5e9; color: #388e3c; }

        .message-box {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #667eea;
            margin-bottom: 24px;
        }

        .attachments-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 16px;
        }

        .attachment-item {
            padding: 16px;
            background: #f8f9fa;
            border-radius: 8px;
            text-align: center;
        }

        .attachment-icon {
            font-size: 40px;
            margin-bottom: 10px;
        }

        .attachment-name {
            font-size: 13px;
            color: #333;
            margin-bottom: 8px;
            word-break: break-all;
        }

        .attachment-size {
            font-size: 12px;
            color: #666;
            margin-bottom: 12px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }

        .btn-primary {
            background: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background: #5568d3;
        }

        .btn-success {
            background: #28a745;
            color: white;
        }

        .btn-success:hover {
            background: #218838;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #555;
        }

        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            font-family: inherit;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        .action-buttons {
            display: flex;
            gap: 12px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📋 Заявка #{{ $ticket->id }}</h1>
        <a href="{{ route('admin.tickets.index') }}" class="back-link">← Назад к списку</a>
    </div>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h2>Информация о клиенте</h2>
            </div>
            
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Имя</div>
                    <div class="info-value">{{ $ticket->customer->name }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $ticket->customer->email }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Телефон</div>
                    <div class="info-value">{{ $ticket->customer->phone }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Дата создания</div>
                    <div class="info-value">{{ $ticket->created_at->format('d.m.Y H:i') }}</div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>Детали заявки</h2>
            </div>

            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Тема</div>
                    <div class="info-value">{{ $ticket->subject }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Статус</div>
                    <div class="info-value">
                        <span class="status-badge status-{{ $ticket->status }}">
                            {{ $ticket->status }}
                        </span>
                    </div>
                </div>
                @if($ticket->assignedManager)
                <div class="info-item">
                    <div class="info-label">Менеджер</div>
                    <div class="info-value">{{ $ticket->assignedManager->name }}</div>
                </div>
                @endif
                @if($ticket->manager_responded_at)
                <div class="info-item">
                    <div class="info-label">Дата ответа</div>
                    <div class="info-value">{{ $ticket->manager_responded_at->format('d.m.Y H:i') }}</div>
                </div>
                @endif
            </div>

            <div class="form-group">
                <div class="info-label">Сообщение клиента</div>
                <div class="message-box">
                    {{ $ticket->description }}
                </div>
            </div>

            @if($ticket->manager_response)
            <div class="form-group">
                <div class="info-label">Ответ менеджера</div>
                <div class="message-box" style="border-left-color: #28a745;">
                    {{ $ticket->manager_response }}
                </div>
            </div>
            @endif
        </div>

        @if($ticket->media->count() > 0)
        <div class="card">
            <div class="card-header">
                <h2>Прикрепленные файлы ({{ $ticket->media->count() }})</h2>
            </div>

            <div class="attachments-grid">
                @foreach($ticket->media as $media)
                <div class="attachment-item">
                    <div class="attachment-icon">
                        @if(str_starts_with($media->mime_type, 'image/'))
                            🖼️
                        @elseif($media->mime_type === 'application/pdf')
                            📄
                        @else
                            📎
                        @endif
                    </div>
                    <div class="attachment-name">{{ $media->file_name }}</div>
                    <div class="attachment-size">{{ number_format($media->size / 1024, 2) }} KB</div>
                    <a href="{{ $media->getUrl() }}" class="btn btn-primary" download>
                        ⬇ Скачать
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h2>Управление заявкой</h2>
            </div>

            <form method="POST" action="{{ route('admin.tickets.update-status', $ticket) }}">
                @csrf
                @method('PATCH')
                
                <div class="form-group">
                    <label for="status">Изменить статус</label>
                    <select name="status" id="status">
                        <option value="new" {{ $ticket->status === 'new' ? 'selected' : '' }}>Новый</option>
                        <option value="in_progress" {{ $ticket->status === 'inProgress' ? 'selected' : '' }}>В работе</option>
                        <option value="processed" {{ $ticket->status === 'processed' ? 'selected' : '' }}>Обработан</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Обновить статус</button>
            </form>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>Ответить клиенту</h2>
            </div>

            <form method="POST" action="{{ route('admin.tickets.add-response', $ticket) }}">
                @csrf
                
                <div class="form-group">
                    <label for="response">Ваш ответ</label>
                    <textarea name="response" id="response" required placeholder="Введите ответ для клиента..."></textarea>
                </div>

                <button type="submit" class="btn btn-success">Отправить ответ</button>
            </form>
        </div>
    </div>
</body>
</html>