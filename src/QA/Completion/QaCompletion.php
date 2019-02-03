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
     * @return bool
     */
    public function add(string $word,int $sort = 1):bool
    {
        return $this->save([['word'=>$word,'sort'=>$sort]]);
    }

    /**
     * @brief 批量添加联想词
     *
     * @param $words 格式为 [['词汇1',1],['词汇2','2'],['词汇3','2']...] 词汇 为添加的联想词，数字为排序，越大越靠前。
     *
     * @return bool
     */
    public function adds(array $words):bool
    {
        $addWords = [];

        foreach($words as $word)
        {
            if(!is_array($word))
            {
                $addWords[] = ['word'=>$word,'sort'=>0];
            } else 
            {
                $addWords[] = ['word'=>$word[0],'sort'=>$word[1]];
            }
        }

        return $this->save($addWords);
    }

    /**
     * @brief 更新某个词的排序
     *
     * @param $word 要更新的词
     * @param $sort 排序
     *
     * @return bool
     */
    public function upSort(string $word,$sort):bool
    {
        if($this->isExists($word)) {
            return $this->add($word,$sort); //没错就是用的add
        }

        return false;
    }


    /**
     * @brief 判断某个词是否存在
     *
     * @param $word 词
     *
     * @return bool
     */
    public function isExists(string $word):bool
    {
        $query = $this->query($word);

        if(count($query) != 1)
        {
            return false;
        }

        return $query[0] === $word;
    }

    /**
     * @brief 清空全部
     *
     * @return 
     */
    public function clear()
    {
        $filePath = $this->getFilePath();
        if(file_exists($filePath))
        {
            unlink($filePath);
        }
    }

    /**
     * @brief 获得树
     *
     * @return array
     */
    public function getTrie():array
    {
        return $this->getTree();
    }


    /**
     * @brief 移除指定的词
     *
     * @param $word
     *
     * @return 
     */
    public function remove(string $word):bool
    {
        $tree = $this->getTree();

        $trieTree = new TrieTree();
        $tree = $trieTree->remove($word,$tree);

        return $this->setTree($tree);
    }

    /**
     * @brief 保存
     *
     * @return bool
     */
    protected function save(array $words):bool
    {
        $tree = $this->getTree();

        $trieTree = new TrieTree();
        $tree = $trieTree->getTree($words,$tree);

        return $this->setTree($tree);
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

    /**
     * @brief 保存设定树
     *
     * @param $tree
     *
     * @return 
     */
    protected function setTree(array $tree):bool
    {
        $filePath = $this->getFilePath();
        $write = serialize($tree);

        $result = file_put_contents($filePath,$write);

        return $result !== false;

    }

}
