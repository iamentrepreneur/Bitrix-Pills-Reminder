<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<?php if ($arResult["ERRORS"]): ?>
    <div class="error-messages">
        <?= implode("<br>", $arResult["ERRORS"]) ?>
    </div>
<?php endif; ?>

<?php if ($_GET["success"] == 1): ?>
    <div class="success-message">
        Напоминание успешно добавлено!
    </div>
<?php endif; ?>

<div class="common-form">
    <form method="post">
        <?= bitrix_sessid_post() ?>

        <div class="form-group">
            <label for="name">Название:</label>
            <input type="text" name="UF_MEDICATION_NAME" id="name" required>
        </div>


        <div class="form-group">
            <label for="date_start">Дата начала:</label>
            <input type="date" name="UF_START_DATE" id="date_start" required>
        </div>

        <div class="form-group">
            <label for="date_end">Дата окончания:</label>
            <input type="date" name="UF_END_DATE" id="date_end" required>
        </div>

        <div class="form-group">
            <div class="reminder-times" id="reminder-times">
                <label>Время напоминаний:</label>
                <div class="reminder-time">
                    <input type="time" name="UF_REMINDER_TIMES[]" required>
                    <button type="button" class="remove-time">Удалить</button>
                </div>
            </div>
            <div class="form-addition-actions">
                <button type="button" id="add-time">Добавить время</button>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit">Добавить</button>
        </div>
    </form>
</div>

<script>
    document.getElementById('add-time').addEventListener('click', function () {
        const reminderTimes = document.getElementById('reminder-times');
        const newTimeField = document.createElement('div');
        newTimeField.className = 'reminder-time';
        newTimeField.innerHTML = `
            <input type="time" name="UF_REMINDER_TIMES[]" required>
            <button type="button" class="remove-time">Удалить</button>
        `;
        reminderTimes.appendChild(newTimeField);
    });

    document.getElementById('reminder-times').addEventListener('click', function (event) {
        if (event.target.classList.contains('remove-time')) {
            event.target.parentElement.remove();
        }
    });
</script>