## Краткое руководство
> Важно! Необходимо сначала запустить очередь, после сборки.<br>Так же, для Linux'а потребуется сделать файлы `docker`, `exec-queue`, `exec-sent` и `exec-sent`, исполняемыми.

### Запустить сборку
```console
bash docker
```

### Очередь RabbitMQ и запись в MariaDB
```console
bash exec-queue
```

### Отправка записей в очередь RabbitMQ
```console
bash exec-sent
```

### Получение данных
```console
bash exec-select
```

|Строк за минуту|Минута группировки|Средняя длинна|Время первого сообщения|Время последнего сообщения|
| - | -- | ----------- | ------------------- | ------------------- |
| 3 | 41 | 38015.3333  | 2023-09-14 14:41:01 | 2023-09-14 14:41:40 |
| 4 | 42 | 517950.7500 | 2023-09-14 14:42:09 | 2023-09-14 14:42:54 |
| 2 | 43 | 105369.5000 | 2023-09-14 14:43:15 | 2023-09-14 14:43:42 |
| 1 | 44 | 366109.0000 | 2023-09-14 14:44:10 | 2023-09-14 14:44:10 |