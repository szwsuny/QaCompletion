<?php
/**
* @file index.php
* @brief 测试
* @author sunzhiwei
* @version 1.1
* @date 2019-02-02
 */

require __DIR__ . '/../vendor/autoload.php';

use SzwSuny\QA\Completion\QaCompletion;

$qaCompletion = new QaCompletion();

var_dump($qaCompletion);

