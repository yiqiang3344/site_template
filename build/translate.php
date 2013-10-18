<?php
$lang_list = explode(',', $argv[1]);
// 翻译
chdir("../translator");
require_once 'run.php';