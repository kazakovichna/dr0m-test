Первое задание
-
---
Есть список директорий неизвестно насколько большой вложенности
В директории может быть файл count
Нужно пройтись по всем директориям и вернуть сумму всех чисел из файла count (файлов count может быть много)
---


Решение
-

**Шаг 1**

Для начала в переменной **$directoryPath** я задал текущую директорию с помощью магической константы **__ DIR __**.

Затем в переменной **$fileName** я определил имя файла в котором будут находиться искомые числа (имя файла без расширения)
```php
$directoryPath = __DIR__;
$fileName = "count";
```

---
**Шаг 2**

Затем я вызываю метод getSumFromFiles() и сразу вывожу его результат, так как это и есть ответ на задачу.
```php
echo "Sum of numbers in count files: " . getSumFromFiles($directoryPath, $fileName);
```

---
**Шаг 3**

Функция getSumFromFiles()
```php
// Первый аргумент - текущая директория, второй аргумент - имя файла для поиска чисел без расширения
function getSumFromFiles(string $dir, $fileName): float
{
// Получаем все файлы в текущей директории и в подкатегориях.
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

//  Это текущая сумма всех найденных чисел 
    $sum = 0;
    
//  Используем цикл для перебора найденных файлов
    foreach ($files as $file) {

//      Проверка на что $file является файлом, а не директорией например
//      И также проверка регулярным выражением, на то что файл называется как $fileName.* (* - любое расширение)
        if ($file->isFile()
            && preg_match('/^' . preg_quote($fileName, '/') . '\..+$/', $file->getFilename())) {
            
//          Получаем содержимое файла в виде строки
            $content = file_get_contents($file->getRealPath());

//          Проверяем на что это действительно строка,
//          а не false (false - будет если файл будет пустой или если он не был правильно прочитан)
            if (is_string($content)) {
            
//              Прибавляем к переменной $sum результат выполнения следующей функции countSumInCurrentFile()
//              Давайте теперь рассмотрим ее
                $sum += countSumInCurrentFile($content);
            }
        }
    }

//  Возвращаем сумму всех чисел во всех файлах
    return $sum;
}
```

---
**Шаг 4**

Функция countSumInCurrentFile()
```php
// Аргумент - строка которую мы считали из файла ранее
function countSumInCurrentFile(string $content): int
{
//  С помощью регулярного выражения собираем все числа в массив $numbers
//  Например из строки "test1PhpFile23фцвфцвфцв 23 e" мы получим вот такой массив $numbers = [["1", "23", "23"], ...]
    preg_match_all('/\d+/', $content, $numbers);

//  Возвращает сумму всех чисел из массива $numbers[0]
//  array_map с помощью функции intval преобразует элементы массива $numbers[0] в целые числа
//  array_sum вычисляет сумму всех элементов $numbers[0], которые уже были преобразованы в целые числа
    return array_sum(array_map('intval', $numbers[0]));
}
```

---
**Шаг 5**

После выполнения функций getSumFromFiles, countSumInCurrentFile, их результат вернется в эту строку
```php
echo "Sum of numbers in count files: " . getSumFromFiles($directoryPath, $fileName);
```
И выполнение программы будет завершено

---
P.S. 
В репозитории к первому заданию представлена тестовая директория для проверки работы программы
- dir0
  - dir1
    - dir2
      - dir4
        - count.txt
    - dir3
      - count.txt
    - count.txt
  - count.php

Сумма чисел во всех файлов равно 50

---
**Заключение**

Спасибо за проверку тестового задания, жду обратной связи =)