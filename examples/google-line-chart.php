<?php

require_once __DIR__ . '/../vendor/autoload.php';

$httpFactory = new MilesChou\Psr\Http\Message\HttpFactory();
$httpClient = new Symfony\Component\HttpClient\Psr18Client(null, $httpFactory, $httpFactory);

$target = new Pachart\Drivers\GoogleChart\Line($httpClient, $httpFactory);

$target->size(800, 350);
$target->setData([70, 72, 67, 68, 65, 59, 64, 70, 73, 75, 78, 80]);
$target->setXLabel(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
$target->setXt();
$target->rangePaddingPercent(10);
$target->setGrid(10, 10);

echo $target->buildUri() . PHP_EOL;

(new MilesChou\ImgEcho\ImgEcho())
    ->withWidth('70%')
    ->withImage($target->binary())
    ->send();

$target = new Pachart\Drivers\GoogleChart\Bar($httpClient, $httpFactory);

$target->size(800, 350);
$target->setData([70, 72, 67, 68, 65, 59, 64, 70, 73, 75, 78, 80]);
$target->setXLabel(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
$target->setXt();
$target->rangePaddingPercent(10);
$target->setGrid(10, 10);

echo $target->buildUri() . PHP_EOL;

(new MilesChou\ImgEcho\ImgEcho())
    ->withWidth('70%')
    ->withImage($target->binary())
    ->send();
