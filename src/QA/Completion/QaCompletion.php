<?php
/**
 * @file QaCompletion.php
 * @brief 主程
 * @author sunzhiwei
 * @version 1.1
 * @date 2019-02-02
 */

namespace SzwSuny\QA\Completion;

use SzwSuny\QA\Completion\TrieTree;

class QaCompletion
{
    private $words = [];

    /**
     * @brief 添加一个词
     *
     * @param $words 词
     * @param $sort 排序用，数字越大越靠前
     *
     * @return 
     */
    public function add(string $word,int $sort = 0)
    {
        $this->words[] = ['word'=>$word,'sort'=>$sort];
    }

    /**
     * @brief 批量添加联想词
     *
     * @param $words 格式为 [['词汇1',1],['词汇2','2'],['词汇3','2']...] 词汇 为添加的联想词，数字为排序，越大越靠前。
     *
     * @return 
     */
    public function adds(array $words)
    {
        foreach($words as $word)
        {
           $this->add($word); 
        }
    }

    /**
     * @brief 保存
     *
     * @return bool
     */
    public function save():bool
    {
        $trieTree = new TrieTree();
        $tree = $trieTree->getTree($this->words);
        $filePath = $this->getFilePath();
        $write = serialize($tree);

        $result = file_put_contents($filePath,$write);

        return $result !== false;
    }

    /**
        * @brief 根据内容进行联想查询
        *
        * @param $word 要联想的内容
        * @param $limit 要得到的条数 小于1 为全部
        *
        * @return 
     */
    public function query(string $word,int $limit = 0):array
    {
        if(empty($word))
        {
            return [];
        }
        
        if(preg_match_all("/[\x{4e00}-\x{9fa5}a-zA-Z0-9]+/u", $word, $newWord))
        {
            $word = $newWord[0][0];
        }

        $trieTree = new TrieTree();
        $tree = $this->getTree();
        return $trieTree->query($word,$tree,$limit);
    }

    /**
     * @brief 获得路径
     *
     * @return string
     */
    protected function getFilePath():string
    {
        return __DIR__ . '/trie/completion.'  . Config::TRIE_SUFFIX;
    }

    /**
     * @brief 获得scope下的next
     *
     * @return array
     */
    protected function getTree():array
    {
        $filterPath = $this->getFilePath();

        if(!file_exists($filterPath))
        {
            return [];
        }

        $read = file_get_contents($filterPath);
        $result = unserialize($read);

        return $result;
    }

}
