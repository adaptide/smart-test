<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Форма обратной связи</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            min-height: 100vh;
        }

        .widget-container {
            max-width: 500px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .widget-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 24px;
            text-align: center;
        }

        .widget-header h2 {
            font-size: 24px;
            margin-bottom: 8px;
        }

        .widget-header p {
            opacity: 0.9;
            font-size: 14px;
        }

        .widget-body {
            padding: 24px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s;
            font-family: inherit;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: #667eea;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }

        .file-input-label {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px;
            border: 2px dashed #e0e0e0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .file-input-label:hover {
            border-color: #667eea;
            background: #f8f9ff;
        }

        .file-input {
            position: absolute;
            font-size: 100px;
            opacity: 0;
            right: 0;
            top: 0;
            cursor: pointer;
        }

        .file-list {
            margin-top: 10px;
            font-size: 13px;
            color: #666;
        }

        .file-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px;
            background: #f5f5f5;
            border-radius: 4px;
            margin-top: 5px;
        }

        .remove-file {
            color: #dc3545;
            cursor: pointer;
            font-weight: bold;
        }

        .submit-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
        }

        .submit-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .error-message {
            color: #dc3545;
            font-size: 13px;
            margin-top: 5px;
        }

        .loading {
            text-align: center;
            padding: 20px;
        }

        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #667eea;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div class="widget-container">
        <div class="widget-header">
            <h2>Обратная связь</h2>
            <p>Мы свяжемся с вами в ближайшее время</p>
        </div>

        <div class="widget-body">
            <div id="alertContainer"></div>

            <form id="ticketForm">
                <div class="form-group">
                    <label for="name">Ваше имя *</label>
                    <input type="text" id="name" name="name" required>
                    <div class="error-message" id="error-name"></div>
                </div>

                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" required>
                    <div class="error-message" id="error-email"></div>
                </div>

                <div class="form-group">
                    <label for="phone">Телефон (формат: +77011234567) *</label>
                    <input type="tel" id="phone" name="phone" placeholder="+77011234567" required>
                    <div class="error-message" id="error-phone"></div>
                </div>

                <div class="form-group">
                    <label for="subject">Тема обращения *</label>
                    <input type="text" id="subject" name="subject" required>
                    <div class="error-message" id="error-subject"></div>
                </div>

                <div class="form-group">
                    <label for="description">Сообщение *</label>
                    <textarea id="description" name="description" required></textarea>
                    <div class="error-message" id="error-description"></div>
                </div>

                <div class="form-group">
                    <label>Прикрепить файлы (необязательно)</label>
                    <div class="file-input-wrapper">
                        <label class="file-input-label" for="attachments">
                            📎 Выберите файлы (до 10 МБ)
                        </label>
                        <input type="file" id="attachments" name="attachments[]" class="file-input" multiple 
                               accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx">
                    </div>
                    <div class="file-list" id="fileList"></div>
                    <div class="error-message" id="error-attachments"></div>
                </div>

                <button type="submit" class="submit-btn" id="submitBtn">
                    Отправить заявку
                </button>
            </form>

            <div id="loadingIndicator" class="loading hidden">
                <div class="spinner"></div>
                <p>Отправка...</p>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('ticketForm');
        const submitBtn = document.getElementById('submitBtn');
        const loadingIndicator = document.getElementById('loadingIndicator');
        const alertContainer = document.getElementById('alertContainer');
        const fileInput = document.getElementById('attachments');
        const fileList = document.getElementById('fileList');

        let selectedFiles = [];

        fileInput.addEventListener('change', function(e) {
            selectedFiles = Array.from(e.target.files);
            displayFileList();
        });

        function displayFileList() {
            if (selectedFiles.length === 0) {
                fileList.innerHTML = '';
                return;
            }

            fileList.innerHTML = selectedFiles.map((file, index) => `
                <div class="file-item">
                    <span>${file.name} (${formatFileSize(file.size)})</span>
                    <span class="remove-file" onclick="removeFile(${index})">✕</span>
                </div>
            `).join('');
        }

        function removeFile(index) {
            selectedFiles.splice(index, 1);
            
            const dt = new DataTransfer();
            selectedFiles.forEach(file => dt.items.add(file));
            fileInput.files = dt.files;
            
            displayFileList();
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
        }

        function clearErrors() {
            document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
        }

        function showAlert(message, type = 'success') {
            const alertClass = type === 'success' ? 'alert-success' : 'alert-error';
            alertContainer.innerHTML = `
                <div class="alert ${alertClass}">
                    ${message}
                </div>
            `;

            if (type === 'success') {
                setTimeout(() => {
                    alertContainer.innerHTML = '';
                }, 5000);
            }
        }

        function showErrors(errors) {
            clearErrors();
            
            for (const [field, messages] of Object.entries(errors)) {
                const errorElement = document.getElementById(`error-${field}`);
                if (errorElement) {
                    errorElement.textContent = messages[0];
                }
            }
        }

        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            clearErrors();
            alertContainer.innerHTML = '';
            
            const formData = new FormData();
            formData.append('name', document.getElementById('name').value);
            formData.append('email', document.getElementById('email').value);
            formData.append('phone', document.getElementById('phone').value);
            formData.append('subject', document.getElementById('subject').value);
            formData.append('description', document.getElementById('description').value);

            selectedFiles.forEach((file, index) => {
                formData.append(`attachments[${index}]`, file);
            });

            form.classList.add('hidden');
            loadingIndicator.classList.remove('hidden');
            submitBtn.disabled = true;

            try {
                const response = await fetch('/api/v1/tickets', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok) {
                    showAlert('Ваша заявка успешно отправлена! Мы свяжемся с вами в ближайшее время.', 'success');
                    form.reset();
                    selectedFiles = [];
                    displayFileList();
                } else if (response.status === 422) {
                    showErrors(data.errors);
                    showAlert('Пожалуйста, исправьте ошибки в форме', 'error');
                } else if (response.status === 429) {
                    const hours = data.remaining_hours || 24;
                    showAlert(`${data.message}. Повторите попытку через ${hours} ч.`, 'error');
                } else {
                    showAlert('Произошла ошибка при отправке заявки. Попробуйте позже.', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('Произошла ошибка при отправке заявки. Проверьте подключение к интернету.', 'error');
            } finally {
                form.classList.remove('hidden');
                loadingIndicator.classList.add('hidden');
                submitBtn.disabled = false;
            }
        });
    </script>
</body>
</html>