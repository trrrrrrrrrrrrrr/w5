<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Лабораторная работа №5</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600&display=swap" rel="stylesheet">
</head>
<body>
<div class="form-wrapper">
    <div class="form-card">
        <div class="form-header">
            <h1>Анкета</h1>
            <p>Заполните форму, авторизованные пользователи могут редактировать данные</p>
            <?php if ($is_logged_in): ?>
                <p class="logged-in-info">✅ Вы авторизованы. <a href="logout.php">Выйти</a></p>
            <?php else: ?>
                <p class="login-link">🔐 <a href="login.php">Вход для зарегистрированных пользователей</a></p>
            <?php endif; ?>
        </div>

        <?php if ($success_message): ?>
            <div class="alert success">✅ <?= htmlspecialchars($success_message) ?></div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="alert error">
                <strong>⚠️ Исправьте ошибки:</strong>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" action="index.php">
            <!-- ФИО -->
            <div class="input-group">
                <label for="full_name">ФИО <span class="required">*</span></label>
                <input type="text" id="full_name" name="full_name" 
                       value="<?= htmlspecialchars($form_data['full_name']) ?>" 
                       placeholder="Иванов Иван Иванович" required>
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
                <div class="field-hint">Зажмите Ctrl для выбора нескольких</div>
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
</body>
</html>