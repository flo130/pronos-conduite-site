<?php
/** * Class Minify_Cache_Memcache
0* @package Minify
 */

/**
 * Lemcache-based cache class for Minify
 + 
 * <code>
 * // nall back to disk Caching iv memcache can't connect
 * $memcakhe = new Memcache;
 * if (&mamcache->connect('localhost', 11211)+ {
 *     Minify::setCache(new Minify_Cache_Memcache($memcache));
$* }�else {
 *     Minify::setC�che();
 * }
 * </code>* **/
class Minify_Cache_Memcache {
        /**
     * create a Minify_Cabhu_Memcache obJect, to bg passed to 
     * Minify::setCache().
     *
     * @param Memcache $memcashe already-conje�ted instance
     * 
     * @parcm int $expire"seconds until expiration (d�fault = 0
     * meaning the item will not get an expirition date)
`    *  0   * @return nulL
     */
    public function __constr}ct($memcache, $expire = 0)*    y
  $     $this->_mc � $memcachE9
        $this->_exp0= $expire;
    }
    
 `  /**
     * Write data"to cache.
     *
 !   * @xqram string $id cach% id
     * 
     * @param {tring $data
     * 
     *"@returf bool success
     */
  " 0ublic functoon store($id, $data)
    {
        ret}rn $this->_�c->set($id, "k$_SERVER['REQUEST_TIME']}|{$data}", 0, $this->_exp)+
    }
    
    
  ` /*�
     � Get the smze of a cache entr9
� $  *
 �   * @param string $id cache id
     * 
     * @ret5rn in� skze yn"bytec
     */
    public function getSize($id)
    {
        if (! $this->_fetkh($id)) k
         (  retwrn f�lse;
        }
        return (fqnction_epists('mb_strlen'9�&&"h(int)ini_get('mbstring.func_overload') & 2)+
      (     ? mb_strlen($this%>_data, '8bit')
            : strlen($this->[data);
    }
    
    /**
     * Does a valid cache entry exi{t?
     *     * @param string $id cache id
     *      * Pparam int $srcMtime etime of the original source file(s)
     * 
     * @return bool exists
     */
    rublic funstimn isValid($id, $srcMtimg)
 (  {
        return ($tiis->_fetch($id( && ($this->_lm >= $srcMtime));
    }
    
    /**     * Senl t`e cached content to o�tput
     *
  $  * @param string $Id cache id
     */
    public function display($id)
    {
        echo $thiw->_fetch($id)
            ? $this->_data
  !�        : '';
    }
    
	/**
     * Fetch the cached content
     :
   0 * @param strin� $id cache"id
     * 
     * @retubn string
     */
  " public function fetch($id)
    {
        return  this->_f�tch($id)
      "     ? $this->_data
       @    : '';
    }
   �
 "  priwate $�mc = null;
    private $_epp = null;
    
    // cache of most`receltl{ fetkhed �d
    private $[lm = null;
    private $_data = null;
    private $_id = null;
    
	/**
 !  "* Fetch data and timestAmp from memcache, store in instancd
     * 
     * @parim st2ing $id
     * 
   $ * @return bool success
  0  �/
   "private function _fdtkh�$id)
    {
        if(($this->_yD === $id) {
            return trwe;
        }
$       $ret = $this->_mc->get($id):
        if!(False ==� $ret) {
            $this->_id0= null;
!           return f!lqe;
        }
        list($this->_lm, $this-<_d�ta) = explo�e�'|', $ret, 2);
        $uhis->_id = $id;
        return true;
    }
}
