<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="css/app.css">
    <script src="https://code.jquery.com/jquery-3.6.4.slim.js" integrity="sha256-dWvV84T6BhzO4vG6gWhsWVKVoa4lVmLnpBOZh/CAHU4=" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
    <select name="data">
        <option value="Склад">Склад</option>
        <option value="Реализация">Реализация</option>
        <option value="Продажи">Продажи</option>
        <option value="Заказы">Заказы</option>
    </select>
    <form class="field-api" action="{{ route('update.sales') }}" method="post">
        @csrf
        <p>Без fetch</p>   
        <input type="date" name="dateFrom" placeholder="Начальная дата">
        <input type="date" name="dateTo" placeholder="Конечная дата">        
        <button type="submit">Отправить</button>
    </form>
<script src="js/app.js"></script>    
</body>
</html>