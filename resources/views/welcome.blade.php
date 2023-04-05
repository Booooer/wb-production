<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/css/app.css">
    <script src="https://code.jquery.com/jquery-3.6.4.slim.js" integrity="sha256-dWvV84T6BhzO4vG6gWhsWVKVoa4lVmLnpBOZh/CAHU4=" crossorigin="anonymous"></script>
    <title>Обновление WB</title>
</head>
<body>
    <div class="content">
        <p id="table-name">Обновление данных</p>
        <select name="data" class="switch-table-name">
            <option value="storage">Склад</option>
            <option value="realizations">Реализация</option>
            <option value="sales">Продажи</option>
            <option value="orders">Заказы</option>
        </select>
        <form class="field-api" action="{{ route('update.storage') }}" method="post" id="form-api">
            @csrf   
            <input type="date" name="dateFrom" placeholder="Начальная дата">
            <input type="date" name="dateTo" placeholder="Конечная дата">        
            <button type="submit">Отправить</button>
        </form>
        <div class="wb-tats">
            <p>Данные по продажам</p>
            <select name="data" class="switch-table-name" onchange="location = this.value;">
                <option>{{ $range }}</option>
                <option value="/">Сегодня</option>
                <option value="/yesterday">Вчера</option>
                <option value="/week">Неделя</option>
                <option value="/month">Месяц</option>
            </select>
            <table>
                <tr>
                    <th>Продажи(руб.)</th>
                    <th>Продажи(шт.)</th>
                    <th>Возвраты(шт.)</th>
                </tr>
                <tr>
                    <th>{{ $sum }}</th>
                    <th>{{ $count }}</th>
                    <th>{{ $refund }}</th>
                </tr>
            </table>
        </div>
    </div>
<script src="/js/app.js"></script>    
</body>
</html>