<?php
namespace app\extensions\helper;

class ResLoader extends \lithium\template\Helper {

    /**
     * 简化加载js文件
     *
     *
     * @param $name js文件名
     *
     * @return void
     **/
    public function script($name){

        return '<script src="/js/'.$name.'"></script>'; 
    }

    /**
     * 简化加载css文件
     *
     *
     * @param $name css文件名
     *
     * @return void
     **/
    public function css($name){

        return '<link rel="stylesheet" href="/css/'.$name.'"></link>';
    }

}
