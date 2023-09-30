!['1'](https://github.com/Gavan4eg/cashalot-laravel/blob/main/art/ukraine.png)

# Cashalot API Laravel

`Фискализация чеков в налоговой с помощью программы cashalot`
#### Laravel 7 или выше, php8 или выше

## Устанвока 

```
composer require gavan4eg/cashalotapi
```
#### Опубликовать config (cashalot.php)

```
php artisan vendor:publish
```

#### Остальное

> Сертефикат .crt и приват ключ .pfx должны быть в формате base64 (https://www.base64encode.org/enc/certificate/)

>Получение сертификата для приват24 https://acsk.privatbank.ua/certificates/clients


## Примеры использования

`# Запросить статус рро`
```php
$cashalot = new CashalotService();
var_dump($cashalot->transactionsRegistrarState());
```
`# Успешный ответ`
```
  "ShiftState" => 1
  "ShiftId" => 30709815
  "OpenShiftFiscalNum" => "1384524792"
  "ZRepPresent" => false
  "Testing" => false
  "Name" => "Тестовий платник 4 (Тест)"
  "SubjectKeyId" => "9453d76f39229104e9a64da46752040e0081a64ff6c755fdc986cf4dd418dfba"
  "FirstLocalNum" => 283
  "NextLocalNum" => 286
  "LastFiscalNum" => "1384554129"
  "OfflineSupported" => true
  "ChiefCashier" => true
  "OfflineSessionId" => 299988
  "OfflineSeed" => 584709474973155
  "OfflineNextLocalNum" => 1
  "OfflineSessionDuration" => 0
  "OfflineSessionsMonthlyDuration" => 0
  "Closed" => false
  "OfflineDocumentsPresent" => false
  "TaxObject" => null
  "ErrorCode" => "Ok"
  "ErrorMessage" => null
```

`# Открытие смены`
```php
$cashalot = new CashalotService();
var_dump($cashalot->openShift());
```
`# Успешный ответ`
```
  "NumFiscal" => "1384590380"
  "NumLocal" => 288
  "OrderDateTime" => "2023-09-30T14:52:43.9713919+03:00"
  "Offline" => false
  "ErrorCode" => "Ok"
  "ErrorMessage" => null
```

`# Закрытие смены`
```php
//Формировать Z-Отчет по закартию смены true/false
$zrep = true;

$cashalot = new CashalotService();
var_dump($cashalot->closeShift($zrep));
```
`# Успешный ответ`
```
  "ZRepAutoInfo" => array:6 [
    "NumFiscal" => "1384622746"
    "NumLocal" => 290
    "OrderDateTime" => "2023-09-30T14:59:31.8089189+03:00"
    "Offline" => false
    "ErrorCode" => "Ok"
    "ErrorMessage" => null
  ]
  "NumFiscal" => "1384622754"
  "NumLocal" => 291
  "OrderDateTime" => "2023-09-30T14:59:31.9714893+03:00"
  "Offline" => false
  "ErrorCode" => "Ok"
  "ErrorMessage" => null
]
```

`# Создание чека`
```php
$cashalot = new CashalotService();
$array = $cashalot->registerCheck([
            "CHECKHEAD" => [
                "DOCTYPE" => "SaleGoods",
                "DOCSUBTYPE" => "CheckGoods"
            ],
            "CHECKTOTAL" => [
                "SUM" => 99.99
            ],
            "CHECKPAY" => [
                [
                    "PAYFORMCD" => 1,
                    "PAYFORMNM" => "Банківська картка",
                    "SUM" => 99.99,
                    "PAYSYS" => [
                        [
                            "TAXNUM" => "UA2020",
                            "NAME" => "LiqPay",
                            "SUM" => "99.99",
                            "COMMISSION" => "0"
                        ]
                    ],
                ],
            ],
            "CHECKBODY" => [
                [

                    "NAME" => "Оплата за услуги клинки",
                    "UNITCD" => 138,
                    "UNITNM" => "л",
                    "AMOUNT" => 1.000,
                    "PRICE" => 99.99,
                    "COST" => 99.99
                ]
            ],
        ]);
        dd($array);
```
`# Успешный ответ`
```
  "QrCode" => null
  "Url" => "https://cabinet.tax.gov.ua/cashregs/check?fn=4000146829&id=1384600901&date=20230930&time=145454&sm=99.99"
  "NumFiscal" => "1384600901"
  "NumLocal" => 289
  "OrderDateTime" => "2023-09-30T14:54:54.8878813+03:00"
  "Offline" => false
  "ErrorCode" => "Ok"
  "ErrorMessage" => null
```


