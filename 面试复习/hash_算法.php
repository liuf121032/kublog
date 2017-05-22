<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2017/5/22
 * Time: 10:14
 *
 * 哈希算法和取摸算法，在命中上的区别。
 * 比如N台服务器
 *
 * 1. 取摸算法：  如果服务器减少剩N台服务器，命中率降为到了 1/N，
 *
 * 如果服务器由N变为N-1台服务器，
 * （N*N-1） 最小公倍数 到 [0，N-1]的落点（值）没变。
 * 每N*N-1个key,只有N个key的模没变。 命中率 变成了 N-1/(N*N-1)=1/N
 *
 *
 * 2.一致性哈希算法：
 *  比如有5台服务器 a,b,c,d,e
 * 思路：引入虚拟节点 a1-a100,b1-b100等，各虚拟100台出来。然后将虚拟的节点尽量均匀分布到一个圆环上。
 *        这样其中如果某台服务器down掉之后，影响的只是下一个节点的缓存数据，且如果足够均匀，被down服务器的数据，在寻找下个节点的命中上被影响的数据只是1/N.
 * 命中率是 （N-1）/N
 *
 * 3,memcached 缓存失效的机制：惰性删除，与LRU最近最少使用记录删除。LRU算法
 *
 * 4.单台服务器春晚高峰期访问量每秒最高4M的流量介入，最多是4000000，假设每个请求访问量是100Byte，那么QPS可以理解成是4W，每秒处理的请求数量是4W。
 */
interface hash{
    public function _hash($str); //哈希算法 crc();
}
interface distribution{
    public function lookup($key);   //查找节点
    public function addNode($node); // 增加节点
}

Class Consistent implements hash,distribution{
    protected $_postion=array(); //虚拟节点数组
    protected $_num=64;  //虚拟量

    public function _hash($str){
        return sprintf("%u",crc32());  //把字符串转换成32位符号整数
    }

    public function lookup($key)
    {
        $point=$this->_hash($key);
        $node=current($this->_postion);
        foreach($this->_postion as $k=>$v){
            if($point<=$k){    //$k对应节点，$v对应的服务器
                $node=$v;
                break;
            }
        }
        return $node;
    }
    public function addNode($node)
    {
        for($i=0;$i<$this->_num;$i++){
            $this->_postion[$this->_hash($node."_".$i)]=$node;
        }
        $this->_sortNode();
    }

    public function delNode($node){
        foreach($this->_postion as $k=>$v){
            if($v==$node){
                unset($this->_postion[$k]);
            }
        }
    }

    public function _sortNode(){//对新增后的节点排序
        ksort($this->_postion,SORT_REGULAR);
    }
}


/*  2.统计命中率，memcached.exe -m 4 -p 11211 ,statis 查看memcache的状态。
 *
 *
 * */


























