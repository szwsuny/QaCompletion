<?php
/**
* @file remove.php
* @brief 删除某个词
* @author sunzhiwei
* @version 1.1
* @date 2019-02-03
 */

require __DIR__ . '/../vendor/autoload.php';

use SzwSuny\QA\Completion\QaCompletion;

$qaCompletion = new QaCompletion();
$result = $qaCompletion->remove('孙志伟');

var_dump($result);
