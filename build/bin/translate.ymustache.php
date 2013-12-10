<?php
$lang_list = array(
    {{#site.langs}}
        '{{.}}',
    {{/site.langs}}
);
// 翻译
chdir("../build/translator");
require_once 'run.php';