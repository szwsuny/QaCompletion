# QaCompletion - 查询联想补全
Query Auto Completion
------
使用trie字典树进行前缀联想补全，可以用于输入框下拉提示，搜索下拉提示，根据添加词汇时候的sort值进行降序排序。

------
### 依赖

    * PHP >= 7

------

### 使用方式

    * 可以参考test目录

引入项目

    require __DIR__ . '/../vendor/autoload.php'; //注意调整所在目录位置

    use SzwSuny\QA\Completion\QaCompletion;

声明对象

    $qaCompletion = new QaCompletion();

添加词

    $qaCompletion->adds($words); //$words是数组 格式为 [['词汇',2],['词汇1',2]] 数字为排序使用，越大越靠前 
    $qaCompletion->add($word,10); //$word是词汇  10 是排序值 你可以给任何数，越大值此词在结果中越靠前

更新排序值

    $qaCompletion->upSort($word,10); //$word是词汇，10 是排序值，如果词汇不存在则失败。 

清空所有联想词汇

    $qaCompletion->clear(); //将会清空所有词，无法撤销，慎用。

补全联想

    $qaCompletion->query('孙',10); //第一参数是要进行联想的字符串，第二个参数为返回联想到的条数，如果不填返回全部联想。

### 版本号说明

    xx.xx.0 最后一位为0是正式版
    xx.xx.1-99 这种属于测试版本

------
### 更新

    2019年02月3日 1.1.0
        发布正式版本

    2019年02月06日 1.1.3
        吸收模式，能够跳过匹配不到的字符继续进行匹配，在Config中设置开启,1.1.3默认开启。

    2019年02月14日 1.1.4
        修正remove反馈不正常


sunzhiwei
2019-2-3
