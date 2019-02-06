<?php
/**
 * @file Config.php
 * @brief 配置
 * @author sunzhiwei
 * @version 1.1
 * @date 2019-02-02
 */

namespace SzwSuny\QA\Completion;

class Config 
{
    /**
     * @brief 文件后缀
     */
    const TRIE_SUFFIX = 'trie';


    /**
     * @brief 吸收模式 开启后会跳过匹配不到字符
     */
    const ABSORB_MODE = true;
}
