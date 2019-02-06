<?php
/**
* @file trieTree.php
* @brief trie字典树
* @author sunzhiwei
* @version 1.1
* @date 2019-02-02
 */

namespace SzwSuny\QA\Completion;

use SzwSuny\QA\Completion\Config;

class TrieTree
{
    public function getTree(array $words,array $tree = []):array
    {
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

    public function remove(string $word,array $tree):array
    {
        $nodes = [];
        $len = mb_strlen($word);
        $isEnd = false;
        $nowTree = $tree;
        //第一次寻找并将节点存到 nodes数组中，isEnd表示十分完结，如果为false表示没找到词。那么就不改变
        for($i = 0; $i < $len; $i++)
        {
            $char = mb_substr($word,$i,1);
            if(!isset($nowTree[$char]))
            {
                break;
            }

            $isEnd = $nowTree[$char]['end']; //正常结束的应该为 true；
            $nowTree = $nowTree[$char];
            $nodes[$char] = $nowTree;
        }

        if($isEnd) //表示词已经找到了
        {
            $oTree = &$tree;
            $isEnd = false;
            for($i = 0; $i < $len; $i++)
            {
                $char = mb_substr($word,$i,1);
                $nowTree = $nodes[$char]; //节点中去掉end sort 判断是否有其他词使用此点
                unset($nowTree['end']);
                unset($nowTree['sort']);
                if(empty($nowTree)) //如果没有词用直接删除，退出循环
                {
                    unset($oTree[$char]);
                    break;

                }
               
                if(($i == $len -1) && !empty($nowTree)) //如果有其他节点在用。那么久将end的true 转为 false；
                {
                   $oTree[$char]['end'] = false; 
                   break;
                }

                $oTree = &$oTree[$char];
            }
        }

        return $tree;
    }

    public function exists(string $word,array $tree):bool
    {
        $len = mb_strlen($word);
        $isEnd = false;

        $nowTree = $tree;
        for($i = 0; $i < $len; $i++)
        {
            $char = mb_substr($word,$i,1);
            if(!isset($nowTree[$char]))
            {
                $isEnd = false;
                break;
            }

            $isEnd = $nowTree[$char]['end'];

            $nowTree = $nowTree[$char];
        }

        return $isEnd;
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

            if(isset($nowTree[$char]))
            {
                $prefix = $prefix . $char;
                $nowTree = $nowTree[$char];
                if($i == ($len - 1))
                {
                    $isFind = true;
                }
            }
            else {
                $isFind = Config::ABSORB_MODE; //开启吸收模式
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
        $result = [];

        if($nowTree['end'])
        {
            $result[$prefix] = $nowTree['sort'];
        }

        unset($nowTree['end']);
        unset($nowTree['sort']);

        if(empty($nowTree))
        {
            return $result;
        }
        
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
