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

$words = ['孙志伟','孙志','孙志问'];

$qaCompletion->adds($words);

$qaCompletion->upSort('孙志伟',10);
