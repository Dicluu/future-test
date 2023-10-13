<?php

use Dredd\Hooks;

$values = [

];

// Отправляем в тело уникальный контакт. Ожидаем получить 201.
Hooks::before("/notebook > Метод создания нового контакта. > 201 > application/json", function (&$transaction){
    $body = [
        'full_name' => 'Unique name',
        'company_name' => 'Unique company',
        'phone' => '+9-99-99-999-9',
        'email' => 'uniquemail@unique.com',
        'date_of_birth' => '2021-02-17',
        'img_url' => 'https://via.placeholder.com/640x480.png/00ccdd?text=magnam'
    ];

    $transaction->request->body = json_encode($body);
    $transaction->request->headers->Accept = 'application/json';
});

// Отправляем в тело тот же контакт, который уже создали. Получаем 422 код из-за неуникальности.
Hooks::before("/notebook > Метод создания нового контакта. > 422", function (&$transaction){
    $body = [
        'full_name' => 'Unique name',
        'company_name' => 'Unique company',
        'phone' => '+9-99-99-999-9',
        'email' => 'uniquemail@unique.com',
        'date_of_birth' => '2021-02-17',
        'img_url' => 'https://via.placeholder.com/640x480.png/00ccdd?text=magnam'
    ];

    $transaction->request->body = json_encode($body);
    $transaction->request->headers->Accept = 'application/json';
});

// Получаем в теле ответа контакт, выдергиваем от туда ид.
Hooks::after("/notebook > Метод создания нового контакта. > 201 > application/json", function (&$transaction) use (&$values){
    $body = json_decode($transaction->real->body);
    $values['id'] = $body->data->id;
});

// Внедряем в урл запроса ид ранее созданного контакта.
Hooks::before("/notebook/{id} > Метод получения контакта по идентификатору. > 200 > application/json", function (&$transaction) use (&$values){
    $transaction->fullPath = substr($transaction->fullPath, 0, -1);
    $transaction->fullPath .= $values['id'];
});

// Внедряем в урл запроса ид, с отрицательным значением, чтобы получить код 404.
Hooks::before("/notebook/{id} > Метод получения контакта по идентификатору. > 404", function (&$transaction){
    $transaction->fullPath = substr($transaction->fullPath, 0, -1);
    $transaction->fullPath .= -1;
});

// Пытаемся изменить ранее созданный контакт на не уникальное значение email/phone
Hooks::before("/notebook/{id} > Метод обновление контакта по идентификатору. > 422", function (&$transaction) use (&$values){
    $body = [
        'full_name' => 'Unique name',
        'company_name' => 'Unique company',
        'phone' => 'test_phone', // используем заранее не уникальное значение.
        'email' => 'uniquemail@unique.com',
        'date_of_birth' => '2021-02-17',
        'img_url' => 'https://via.placeholder.com/640x480.png/00ccdd?text=magnam'
    ];

    $transaction->request->headers->Accept = 'application/json';
    $transaction->fullPath = substr($transaction->fullPath, 0, -1);
    $transaction->fullPath .= $values['id'];
    $transaction->request->body = json_encode($body);
});

// Пытаемся изменить несуществующий контакт. Получаем код 404.
Hooks::before("/notebook/{id} > Метод обновление контакта по идентификатору. > 404", function (&$transaction) use (&$values){
    $body = [
        'full_name' => 'Unique name',
        'company_name' => 'Unique company',
        'phone' => 'test_unique_phone', // используем новое уникальное тестовое значение
        'email' => 'test_uniquemail@unique.com',
        'date_of_birth' => '2021-02-17',
        'img_url' => 'https://via.placeholder.com/640x480.png/00ccdd?text=magnam'
    ];

    $transaction->request->headers->Accept = 'application/json';
    $transaction->fullPath = substr($transaction->fullPath, 0, -1);
    $transaction->fullPath .= -1;
    $transaction->request->body = json_encode($body);
});

// Удаляем ранее созданный контакт, чтобы последующие запуски тестов могли создать его.
// Изменяем урл с дефолтного с 1-ым идом на ид ранее созданного уникального контакта.
Hooks::before("/notebook/{id} > Метод удаления контакта по идентификатору. > 204", function (&$transaction) use (&$values){
    $id = $values['id'];
    $transaction->fullPath = substr($transaction->fullPath, 0, -1);
    $transaction->fullPath .= $id;
});

// Пытаемся снова удалить уже удаленный контакт, получаем код 404.
Hooks::before("/notebook/{id} > Метод удаления контакта по идентификатору. > 404", function (&$transaction) use (&$values){
    $id = $values['id'];
    $transaction->fullPath = substr($transaction->fullPath, 0, -1);
    $transaction->fullPath .= $id;
});


