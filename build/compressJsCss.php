<?php
require('helper.php');
$lang_list = array(
    'zh_cn',
);
chdir('../');
$dirs = array_merge(array(
  'css',
  'js',
));
//压缩js和css
$list = array();
foreach($dirs as $dir){
  $list = array_merge($list,yscanDir($dir));
}
//压缩文件都放到script目录下
is_dir('script') || mkdir('script');
foreach($list as $file){
  $filename = 'script/'.basename($file);
  if(preg_match('{\.min\.js$|\.min\.css$}', $filename)){
      continue;//压缩过的不处理
  }elseif(preg_match('{\.js$}', $filename)){
    $hd = fopen(str_replace('.js','.min.js',$filename),'w');
    fwrite($hd, JSMin::minify(file_get_contents($file)));
    fclose($hd);
  }elseif(preg_match('{\.css$}', $filename)){
    $hd = fopen(str_replace('.css','.min.css',$filename),'w');
    fwrite($hd, compressCss(file_get_contents($file)));
    fclose($hd);
  }
}
echo 'already compressed all js and css.';