# Мини-CRM для обработки заявок

Современная CRM-система для сбора и обработки заявок с сайта через универсальный виджет.

## 🚀 Технологии

- **PHP 8.3**
- **Laravel 12**
- **Spatie Laravel Media Library** 
- **Spatie Laravel Permission**
- **Spatie Enum**
- **Spatie DTO**

### Шаги установки

```bash
# 1. Клонирование
git clone <repository-url>
cd smart-test

# 2. Установка зависимостей
composer install

# 3. Настройка окружения
cp .env.example .env
php artisan key:generate

# 4. Настройка БД в .env
DB_DATABASE=crm_tickets
DB_USERNAME=root
DB_PASSWORD=secret

# 5. Миграции и сиды
php artisan migrate --seed

# 6. Создание симлинка для файлов
php artisan storage:link

# 7. Запуск сервера
php artisan serve
```

## 🔑 Тестовые данные

После выполнения `php artisan db:seed` будут созданы:

### Пользователи

| Роль | Email | Пароль |
|------|-------|--------|
| Менеджер | manager@gmail.com | asdasdasd |


## 🔌 API Documentation

### Создание заявки

**POST** `/api/v1/tickets`

**Headers:**
```
Content-Type: multipart/form-data
Accept: application/json
```

**Body:**
```json
{
  "name": "Иван Иванов",
  "email": "ivan@example.com",
  "phone": "+77011234567",
  "subject": "Вопрос по услуге",
  "description": "Подробное описание вопроса",
  "attachments[]": "file1.pdf, file2.jpg"
}
```


## 🎯 Админ-панель

Доступна по адресу: `/admin/tickets`

## 🔒 Валидация

- **Телефон**: строгая проверка формата E.164 (`^\\+[1-9]\\d{1,14}$`)
- **Email**: стандартная валидация Laravel
- **Файлы**: максимум 10 МБ, форматы: jpg, jpeg, png, gif, pdf, doc, docx
