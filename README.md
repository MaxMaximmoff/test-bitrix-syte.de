Выполнение учебных заданий стажировки Y_LAB

Less1

Создан инфоблок Акции. Использовал для этого фаил миграции Version20220119132211
На портале создан раздел promotions и на основе стандартного компонента bitrix.news добавлены и отображены элемены (Акции)
Кастомный шаблон сделан с минимальными переделками на основе шаблона .default bitrix.news
Пользуясь миграцией Version20220119121250 добавлено свойство Скидка в инфоблок Акции.
При этом кастомные шаблоны news.list и news.detail правились минимально для отображения скидки в процентах
Ссылка на сайт: http://valeri5e.beget.tech/promotions/

Lesson2

Первоначально привел к единому виду площадку разработки. Добавил ИБ "Карты" + свойства.
Сделана миграция Version20220126190053.php на добавление 3-х свойств (Стоимость обслуживания карты в мес. (тип Число), Срок действия карты в мес. (тип Число), Дата окончания действия карты (тип Дата))
На основе компонента ylab:cards.list сделал компонент mylab:cards.list с минимальными изменениями (просто прошел по всем требуемым файлам и заменил ylab на mylab). Добился вывода на экран на дефолтном шаблоне.
Добавил в грид колонки: Стоимость обслуживания карты в мес., Срок действия карты в мес., Дата окончания действия карты, Суммарная стоимости обслуживания карты. Отобразил соответствующие данные.
Добавлены фильтры
Ссылка на сайт: http://valeri5e.beget.tech/lesson2/


Lesson3

В классе Profile (local/modules/mail.manager/lib/profile.php) реализовл недостающие методы (addProfile, updateProfile, deleteProfile)
Создал новую таблицу "y_addresses" (поля произвольные, но не меньше 3-х), описал ОРМ класс для нее
Организовал отношение двух ОРМ (таблиц) y_emails и y_addresses
Доработл компонент ylab:email.manager. Получил данные из y_emails со связанными данными из y_addresses
Вывел требуемые данные на экран через доработанный шаблон компонента ylab:email.manager (сейчас вывод через этот компонент закомментирован)
Сделал новый компонент mylab:emails.list на базе bitrix:main.ui.grid.
Сейчас данные таблиц сейчас выводятся через него, но удалять, редактировать, добавлять элементы в гриде не получилось сделать.
(посмотреть можно здесь: http://valeri5e.beget.tech/lesson3/ 
