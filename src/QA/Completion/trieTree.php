<?php
/**
* @file trieTree.php
* @brief trie字典树
* @author sunzhiwei
* @version 1.1
* @date 2019-02-02
 */

namespace SzwSuny\QA\Completion;

class TrieTree
{
    public function getTree(array $words):array
    {
        $tree = [];
        foreach($words as $wd)
        {
            $word = $wd['word'];
            $sort = $wd['sort'];
            $len = mb_strlen($word);
            $nowTree = &$tree;
            for($i = 0; $i < $len; $i++)
            {
                $char = mb_substr($word,$i,1);
                if(isset($nowTree[$char]))
                {
                    if($i == ($len - 1))
                    {
                        $nowTree[$char]['sort'] = $sort;
                        $nowTree[$char]['end'] = true;
                    }
                } else 
                {
                    if($i == ($len - 1))
                    {
                        $nowTree[$char]['sort'] = $sort;
                        $nowTree[$char]['end'] = true;
                    } else
                    {
                        $nowTree[$char]['end'] = false;
                    }
                }

                $nowTree = &$nowTree[$char];
            }
        }

        return $tree;
    }

    public function query(string $word,array $tree,int $limit = 0):array
    {
        $len = mb_strlen($word);
        $isFind = false;
        $nowTree = $tree;
        $prefix = '';
        for($i = 0; $i < $len; $i++)
        {
            $char = mb_substr($word,$i,1);
            $prefix = $prefix . $char;
            if(isset($nowTree[$char]))
            {
                $nowTree = $nowTree[$char];
                if($i == ($len - 1))
                {
                    $isFind = true;
                }
            }
            else {
                $isFind = false;
            }
        }

        if(!$isFind || empty($nowTree))
        {
            return [];
        }

        $words = $this->trieForeach($prefix,$nowTree);
        arsort($words,SORT_NUMERIC);
        $words = array_keys($words);
        if($limit < 1)
        {
            return $words;
        }

        return array_slice($words,0,$limit);
    }

    private function trieForeach(string $prefix,array $nowTree):array
    {
        if($nowTree['end'])
        {
            return [$prefix=>$nowTree['sort']];
        }

        $result = [];
        foreach($nowTree as $char=>$tree)
        {
            if(!is_array($tree))
            {
                continue;
            }

            $result = array_merge($result,$this->trieForeach($prefix . $char,$tree));
        }

        return $result;
    }
}
