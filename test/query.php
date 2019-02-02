<?php
/**
* @file query.php
* @brief 查询
* @author sunzhiwei
* @version 1.1
* @date 2019-02-02
 */

require __DIR__ . '/../vendor/autoload.php';

use SzwSuny\QA\Completion\QaCompletion;

$start = getMillisecond();

$qaCompletion = new QaCompletion();
$result = $qaCompletion->query('[孙]');

$end = getMillisecond();
var_dump($result);

echo ($end - $start)/1000 . PHP_EOL;

function getMillisecond() {
    list($s1, $s2) = explode(' ', microtime());
    return (float)sprintf('%.0f', (floatval($s1) + floatval($s2)) * 1000);
}

