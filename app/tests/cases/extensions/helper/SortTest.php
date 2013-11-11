<?php

namespace app\tests\cases\extensions\helper;

use app\extensions\helper\Sort;

class SortTest extends \lithium\test\Unit {

    private $_sortsFields;
    private $_sorts;

    public function setUp() {
        $this->_sortsFields = ['showed', 'hit', 'remain', 'created', 'price'];
        $this->_sorts = Sort::$orderBy;

    }
    public function tearDown() {}

    public function testSort() {

        $index  = 'products';

        $sortsFields = array_keys($this->_sorts[$index]);
        $this->assertEqual($sortsFields, $this->_sortsFields, 'products可用的排序字段');

        $orderByList = Sort::sort($index);
        $sortFields = array_keys($this->_sorts[$index]);
        $orderBy = '<a href="/'.$index.'/index/?orderby='.$sortFields[0].'&sort=asc" class="SortCur">'.$this->_sorts[$index][$sortFields[0]].'</a>';
        $this->assertTrue(in_array($orderBy, $orderByList), '默认列表');

        $order = 'created';
        $sort  = 'desc';
        $orderByList = Sort::sort($index, $order, $sort);
        $htmlSort = $sort == 'desc' ? 'asc' : 'desc';
        $orderBy = '<a href="/'.$index.'/index/?orderby='.$order.'&sort='.$htmlSort.'" class="SortCur">'.$this->_sorts[$index][$order].'</a>';
        $this->assertTrue(in_array($orderBy, $orderByList), '指定created desc排序');

    }
}
