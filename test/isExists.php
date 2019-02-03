<?php
/**
* @file isExists.php
* @brief 某个词是否存在
* @author sunzhiwei
* @version 1.1
* @date 2019-02-03
 */

require __DIR__ . '/../vendor/autoload.php';

use SzwSuny\QA\Completion\QaCompletion;

$qaCompletion = new QaCompletion();

$result = $qaCompletion->isExists('孙大为');

var_dump($result);
