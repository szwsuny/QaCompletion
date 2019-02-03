<?php
/**
* @file clear.php
* @brief 清空所有词库
* @author sunzhiwei
* @version 1.1
* @date 2019-02-03
 */

require __DIR__ . '/../vendor/autoload.php';

use SzwSuny\QA\Completion\QaCompletion;

$qaCompletion = new QaCompletion();

$qaCompletion->clear();
