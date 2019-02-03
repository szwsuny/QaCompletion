<?php
/**
* @file add.php
* @brief 添加测试
* @author sunzhiwei
* @version 1.1
* @date 2019-02-02
 */

require __DIR__ . '/../vendor/autoload.php';

use SzwSuny\QA\Completion\QaCompletion;

$qaCompletion = new QaCompletion();

$words = ['孙志伟','孙二维','孙志同','欧米茄'];

$qaCompletion->adds($words);
$qaCompletion->add('孙大为',1);

$qaCompletion->upSort('孙志伟',10);
