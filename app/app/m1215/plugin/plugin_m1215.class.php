<?php

/* 
 * 插件
 * @date 2014-09-29
 * @author komiles<komiles@163.com>
 */
defined('IN_MET') or exit('No permission');//保持入口文件，每个应用模板都要添加
class plugin_m1215 {
    
    public function doadmin() {
        echo "后台插件部分";
    }
    /**
     * doweb 前端插件调用
     * $_M['html_plugin']['head_script']  调用一个js文件，输出一段文字
     * $_M['html_plugin']['top_script'][]  在顶部增加一段html代码
     */
    public function doweb() {
        global $_M;
        $_M['html_plugin']['head_script'].="<script src = \"{$_M['url'][own]}web/js/index.js\" type=\"text/javascript\"></script>";
        $_M['html_plugin']['top_script'][] = "<a href='http://www.metinfo.cn/'>metinfo</a>";
                
    }
}