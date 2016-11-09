RGK Notification System
============================

ТЕРМИНОЛОГИЯ
------------

Инициатор уведомления - пользователь, который запускает событие при триггере из модели.
Inbox - класс, который содержит все отправленные уведомления.
Код события - идентификатор события в формате Имя_класса::событие
Код уведомления - название исполняемой функции класса Scripts


МОДУЛИ
------------

Для регистрации и авторизации использовал 'dektrium/yii2-user'.


ИНСТРУКЦИЯ
------------
### Миграция
Вывести список доступных миграций

~~~
yii migrate
~~~

### Подключение новой модели к системе уведомлений

1) В параметрах проекта необходимо прописать название класса

```php
 // допустимые вставки событий
 
    'notification_system' => [
		...
        'class_to_attach' => ['Articles', 'User', 'Profile']
    ]
```
2) Создать новое уведомление
2.1. Создать обработчик события внутри модели ( вызвать метод 'callNotification' класса 'Notifications')

Пример: 
```php
	const EVENT_AFTER_CREATE = 'afterCreate';

    public function init()
    {
        $this->on(self::EVENT_AFTER_CREATE, ['app\models\Notifications', 'callNotification'], 'Articles::EVENT_AFTER_CREATE');
    }
```	
2.2. Прописать триггер в нужном месте, передать instance новой модели в качестве параметра.

Пример:

```php
	$event = new ArticleEvent();
    $event->setArticle($model);

    $model->trigger(Articles::EVENT_AFTER_CREATE, $event);
```
			
2.3. Перейти в "notifications/create"	
2.4. Выбрать доступное событие новой модели
2.5. Создать событие заполнив необходимые поля (Заголовок, Текст, Отправитель, Тип, Получатель)


### Создание новых типов уведомлений

1) В классе 'Scripts' создаем новый protected фунцию, релизуем логику.
 Пример:
 
 ```php
protected function email( $contact, $content){

       $mailer = \Yii::$app->mailer;

       $to = $contact;
       $subject = $content[0];
       $text = $content[1];

       $sender = isset(\Yii::$app->params['adminEmail']) ? \Yii::$app->params['adminEmail'] : 'no-reply@example.com';

       $mailer->compose()
           ->setFrom($sender)
           ->setTo($to)
           ->setSubject($subject)
           ->setTextBody($text)
           ->setHtmlBody('<b>' . $text . '</b>')
           ->send();
    } 
	
```
2) Переходим в notifications-types/index
3) Заполняем поля() и Создаем.


РАЗРАБОТКА
-------------

**ПРИМЕЧАНИЯ:**
- Инициатор уведомления не может получить уведомление. Например: если админ создал новую статью, то он не получает уведомление о новой статье.

- Если указано, что отправитель user1 и получатели все пользователи, user1 тоже получает уведомление. (если user1 не является инициатором уведомления).

- Если пользователь не указал в параметрах данные соответствующего типа (например telegram номер), то для этого пользователя не отправляется уведомление.
