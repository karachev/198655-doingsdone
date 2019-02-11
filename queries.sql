-- Добавляет существующий список проектов
INSERT INTO project (name, author_id) VALUES ('Входящие', 1), ('Учеба', 2), ('Работа', 3), ('Домашние дела', 1), ('Авто', 2);

-- Добавляет существующий список задач
INSERT INTO task (date_create, date_done, status, name, file, deadline, author_id, project_id,)
VALUES  (null, null, 0, 'Собеседование в IT компании', 'Home.psd', '01.12.2019', 1, 3),
        (null, null, 0, 'Выполнить тестовое задание', 'Home.psd', '25.12.2019', 2, 3),
        (null, '21.01.2019', 1, 'Сделать задание первого раздела', 'Home.psd', '21.12.2019', 3, 2),
        (null, null, 0, 'Встреча с другом', 'Home.psd', '22.12.2019', 1, 1),
        (null, null, 0, 'Купить корм для кота', 'Home.psd', null, 2, 4),
        (null, null, 0, 'Заказать пиццу', 'Home.psd', null, 3, 4);

-- Добавляет пару пользователей
INSERT INTO user (date_registration, email, name, password)
VALUES ('22.01.2019', 'ivanivanov2019@gmail.com', 'Ваня Иванов', 'qwerty'),
VALUES ('26.01.2019', 'petrov2019@gmail.com', 'Петр Сергеевич', 'ytrewq'),
VALUES ('29.01.2019', 'sidorov2019@gmail.com', 'Толик', 'qazwsxedc');


-- Получить список из всех проектов для одного пользователя
SELECT * FROM project WHERE author_id = 1;

-- Получить список из всех задач для одного проекта
SELECT * FROM task WHERE project_id = 2;

-- Пометить задачу как выполненную
UPDATE task SET status = 1 WHERE id = 5;

-- Обновить название задачи по её идентификатору
UPDATE task SET name = 'Заказать пиццу и напитки' WHERE id = 6;
