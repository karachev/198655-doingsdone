-- Добавляет пару пользователей
INSERT INTO user (date_registration, email, name, password)
VALUES  ('22.01.2019', 'zenit@gmail.com', 'Зенит', '$2y$10$gkQc0JMu9DFVoZLBWMuGXOcvl51r.svT3NlxEZnVzCgOOT8Qos6cm'),
        ('26.01.2019', 'vlada@gmail.com', 'Влада', '$2y$10$MC9hXOH4/pGsqxSpZKgEP.BjrKUqZBcldEttZ4JEEuQmM7vqYbUjC'),
        ('29.01.2019', 'anton@gmail.com', 'Антон', '$2y$10$tH3YDCZ.825gs2bKxtaJweXWIp4XP24MUTCMiMMspbcQoWBwJQDRa');

-- Добавляет существующий список проектов
INSERT INTO project (name, author_id) VALUES ('Входящие', 1), ('Учеба', 2), ('Работа', 3), ('Домашние дела', 1), ('Авто', 2);

-- Добавляет существующий список задач
INSERT INTO task (date_create, date_done, status, name, file, deadline, project_id)
VALUES  (null, null, 0, 'Собеседование в IT компании', 'Home.psd', '01.12.2019', 3),
        (null, null, 0, 'Выполнить тестовое задание', 'Home.psd', '25.12.2019', 3),
        (null, '21.01.2019', 1, 'Сделать задание первого раздела', 'Home.psd', '21.12.2019', 2),
        (null, null, 0, 'Встреча с другом', 'Home.psd', '22.12.2019', 1),
        (null, null, 0, 'Купить корм для кота', 'Home.psd', null, 4),
        (null, null, 0, 'Заказать пиццу', 'Home.psd', null, 4);

-- Получить список из всех проектов для одного пользователя
SELECT * FROM project WHERE author_id = 1;

-- Получить список из всех задач для одного проекта
SELECT * FROM task WHERE project_id = 2;

-- Пометить задачу как выполненную
UPDATE task SET status = 1 WHERE id = 5;

-- Обновить название задачи по её идентификатору
UPDATE task SET name = 'Заказать пиццу и напитки' WHERE id = 6;

-- Добавляет для проверки еще несколько проектов
INSERT INTO project (name, author_id) VALUES ('Учеба', 1), ('Работа', 1);

-- Добавляет для проверки несколько задач
INSERT INTO task (date_create, date_done, status, name, file, deadline, project_id)
VALUES  (null, null, 0, 'Проверить список задач', 'Home.psd', '01.12.2019', 6),
        (null, null, 0, 'проверить список проектов', 'Home.psd', '25.12.2019', 7);
