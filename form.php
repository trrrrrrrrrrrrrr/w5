<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Лабораторная работа №5</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600&display=swap" rel="stylesheet">
    <style>
        /* Стили для модального окна */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.6);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 32px;
            max-width: 450px;
            width: 90%;
            text-align: center;
            position: relative;
            box-shadow: 0 20px 35px rgba(0,0,0,0.3);
            animation: fadeIn 0.3s;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
        .modal-content h3 {
            color: #1e3a5f;
            margin-top: 0;
        }
        .modal-content p {
            font-size: 1.1rem;
            margin: 15px 0;
        }
        .modal-content code {
            background: #eef2ff;
            padding: 6px 12px;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: bold;
            display: inline-block;
            margin: 5px 0;
        }
        .close-modal {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 28px;
            cursor: pointer;
            color: #64748b;
            transition: 0.2s;
        }
        .close-modal:hover {
            color: #b91c1c;
        }
        .modal-note {
            font-size: 0.8rem;
            color: #475569;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="form-wrapper">
    <div class="form-card">
        <div class="form-header">
            <h1> Регистрационная анкета</h1>
            <p>Заполните форму – авторизованные пользователи могут редактировать данные</p>
            <?php if ($is_logged_in): ?>
                <p class="logged-in-info"> Вы авторизованы. <a href="logout.php">Выйти</a></p>
            <?php else: ?>
                <p class="login-link"> <a href="login.php">Вход для зарегистрированных пользователей</a></p>
            <?php endif; ?>
        </div>

        <?php if ($success_message): ?>
            <div class="alert success"> <?= htmlspecialchars($success_message) ?></div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="alert error">
                <strong> Исправьте ошибки:</strong>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" action="index.php">
            
            <div class="input-group">
                <label for="full_name">ФИО <span class="required">*</span></label>
                <input type="text" id="full_name" name="full_name" value="<?= htmlspecialchars($form_data['full_name']) ?>" required>
            </div>
            
            <!-- Телефон -->
            <div class="input-group">
                <label for="phone">Телефон <span class="required">*</span></label>
                <input type="tel" id="phone" name="phone" 
                       value="<?= htmlspecialchars($form_data['phone']) ?>" 
                       placeholder="+7 (123) 456-78-90" required>
            </div>

            <!-- Email -->
            <div class="input-group">
                <label for="email">E-mail <span class="required">*</span></label>
                <input type="email" id="email" name="email" 
                       value="<?= htmlspecialchars($form_data['email']) ?>" 
                       placeholder="example@domain.com" required>
            </div>

            <!-- Дата рождения -->
            <div class="input-group">
                <label for="birth_date">Дата рождения <span class="required">*</span></label>
                <input type="date" id="birth_date" name="birth_date" 
                       value="<?= htmlspecialchars($form_data['birth_date']) ?>" required>
            </div>

            <!-- Пол -->
            <div class="input-group">
                <label>Пол <span class="required">*</span></label>
                <div class="radio-group">
                    <label><input type="radio" name="gender" value="male" 
                          <?= $form_data['gender'] === 'male' ? 'checked' : '' ?>> Мужской</label>
                    <label><input type="radio" name="gender" value="female" 
                          <?= $form_data['gender'] === 'female' ? 'checked' : '' ?>> Женский</label>
                </div>
            </div>

            <!-- Языки -->
            <div class="input-group">
                <label for="languages">Любимые языки программирования <span class="required">*</span></label>
                <select id="languages" name="languages[]" multiple size="6" required>
                    <?php foreach ($languages_from_db as $lang): ?>
                        <option value="<?= htmlspecialchars($lang) ?>" 
                            <?= in_array($lang, $form_data['languages']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($lang) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="field-hint">Зажмите Ctrl (Cmd) для выбора нескольких</div>
            </div>

            <!-- Биография -->
            <div class="input-group">
                <label for="biography">Биография</label>
                <textarea id="biography" name="biography" rows="5" 
                          placeholder="Расскажите немного о себе..."><?= htmlspecialchars($form_data['biography']) ?></textarea>
            </div>

            <!-- Чекбокс согласия -->
            <div class="input-group checkbox-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="contract_accepted" value="1" 
                        <?= $form_data['contract_accepted'] ? 'checked' : '' ?>>
                    <span>Я ознакомлен(а) с условиями контракта и принимаю их <span class="required">*</span></span>
                </label>
            </div>

            <button type="submit" class="submit-btn"><?= $is_logged_in ? ' Обновить данные' : ' Сохранить анкету' ?></button>

        </form>

        <div class="footer-links">
            <a href="v.php"> Просмотр сохранённых анкет</a>
            <?php if ($is_logged_in): ?>
                <a href="logout.php"> Выйти</a>
            <?php else: ?>
                <a href="login.php"> Вход</a>
            <?php endif; ?>
            
        </div>
    </div>
</div>

<!-- Модальное окно -->
<?php if ($show_modal): ?>
<div id="credsModal" class="modal" style="display: flex;">
    <div class="modal-content">
        <span class="close-modal" id="closeModalBtn">&times;</span>
        <h3>🎉 Регистрация успешна!</h3>
        <p>Ваши данные для входа в систему:</p>
        <p><strong>Логин:</strong> <code><?= htmlspecialchars($modal_login) ?></code></p>
        <p><strong>Пароль:</strong> <code><?= htmlspecialchars($modal_password) ?></code></p>
        <div class="modal-note">⚠️ Сохраните эти данные, они потребуются для входа. Окно закроется только по крестику.</div>
    </div>
</div>
<script>
    
    document.getElementById('closeModalBtn').onclick = function() {
        document.getElementById('credsModal').style.display = 'none';
    };
    //Запрещаем закрытие по клику вне окна
    document.getElementById('credsModal').onclick = function(e) {
        if (e.target === this) {
            
        }
    };
</script>
<?php endif; ?>

</body>
</html>