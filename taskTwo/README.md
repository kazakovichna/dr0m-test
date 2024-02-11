Второе задание 
-
---
Необходимо реализовать клиент для абстрактного (вымышленного) сервиса комментариев "example.com". 
Проект должен представлять класс или набор классов, который будет делать http запросы к серверу.
---

Я решил реализовать данную библиотеку с помощью трех основных классов.


- **CommentClient** - предоставляет интерфейс для взаимодействия с сервисом комментариев.
Этот класс служит в качестве клиента и обеспечивает доступ к методам для работы с комментариями.


- **CommentService** - предоставляет методы для работы с данными комментариев.
Этот класс выполняет бизнес-логику, связанную с комментариями, и использует HttpService для взаимодействия с сервером.

   
- **HttpService** - предоставляет методы для выполнения HTTP-запросов к серверу комментариев.


---
**Сущности и DTO**

- **Comment** - в данном проекте только одна сущность это **Comment**.
Она содержит стандартные поля из ТЗ (id, name, text). Данная сущность используется для того чтобы
CommentService мог создать определенные экземпляры Comment из полученных от сервера данных.


- **CommentClientDTO** - используется для передачи данных от места подключения и использования библиотеки в CommentClient.
Содержит поля (name, text).


- **CommentDTO** - используется для передачи комментариев после выполнения запроса (GET http://example.com/comments) 
и сериализации данных в CommentService из Comment в CommentDTO.


- **CommentResponse** - используется для передачи информации после выполнения запросов (POST http://example.com/comment,
PUT http://example.com/comment/{id}). Содержит поля:
  - **success - bool** успех выполнения запроса или обратное.
  - **message - string** сообщение о результате работы. Может содержать как сообщение ошибки, 
так и сообщение об успехе запроса.
  - **commentId - int** Id комментария возвращается при успешном PUT http://example.com/comment/{id} запросе,
но если бы сервер exapmle.com был настоящем, то я бы использовал commentId как Id комментария при успешном
POST http://example.com/comment запросе.


---
**Валидация**


Валидация данных используется в данной библиотеке в классе CommentService при проверке данных в
POST http://example.com/comment и PUT http://example.com/comment/{id} запросах.


Валидация реализована с помощью трех классов:
- **CommentClientDTOValidator** - класс валидации для сущности CommentClientDTO. Имеет следующие свойства и методы:
  - **array $validationRules** - свойство содержит правила валидации для каждого свойства CommentClientDTO.
  - **метод validate** - принимает в себя массив со свойствами и их значениями и запускает цикл по валидации каждого из них.
  - **метод validateField** - валидирует каждое поле по заданным правилам для поля.


- **ValidationResult** - класс, который содержит результаты валидации и методы для управления этими результатами.
  Имеет следующие свойства и методы:
  - **array $fieldValidationResults** - массив результатов валидации каждого поля.
После завершения валидации в этом массиве содержится данные о валидации каждого поля.
  - **метод addFieldValidationResult** - добавляет в $fieldValidationResults результат о валидации поля.
  - **метод isValid** - возвращает значение true если все элементы в $fieldValidationResults прошли валидацию,
и false если обратное.
  - **метод getFieldValidationResults** - получает массив $fieldValidationResults.
  - **метод getFieldValidationResultsAsString** - получает массив $fieldValidationResults в виде строки.


- **FieldValidationResult** - класс, который содержит информацию о результатах валидации каждого поля.
  Имеет следующие свойства и методы:
  - **bool $isValid** - флаг прошло ли поле валидацию.
  - **array $errorMessages** - сообщение об ошибке если валидацию не прошло.
  - **метод isValid** - возвращает $isValid.
  - **метод getErrorMessages** - возвращает $errorMessages.


---
**Тесты**


Тесты я написал с помощью phpUnit и расположены они в папке tests.
Имя тестового класс содержит имя тестируемоего класса с постфиксом Test.

В каждом тестовом классе проверяются методы этого класса.
Надеюсь я правильно понял идею unit-тестов, так как писал их первый раз в жизни

--- 
**Заключение**
Спасибо, что проверили мое тестовое задание, жду обратной связи =).