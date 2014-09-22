<!--<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 
defined('IN_MET') or exit('No permission');
echo <<<EOT
-->
<script src="{$_M[url][pub]}js/seajs/seajs/2.2.0/sea.js?{$jsrand}"></script>
<script>
// seajs 的简单配置
seajs.config({
  base: pubjspath+"js/",
  alias: {
    "jquery": "jquery/jquery/1.11.1/jquery.js",
    "common": "examples/met/include/common.js"
  }
})
// 加载入口模块
seajs.use("examples/met/include/min");
</script>
</body>
</html>
<!--
EOT;
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved..
?>-->