<?php
require('helper.php');
$lang_list = array(
);
chdir('../');
$dirs = array(
  'css',
  'js',
);
//需要合并的js列表
$combineJsList = array(
  'tools.js',
  'main.js',
  'url.js',
);
$list = array();
foreach($dirs as $dir){
  $list = array_merge($list,yscanDir($dir));
}
//压缩文件都放到script目录下
is_dir('script') || mkdir('script');
//删除当前压缩文件
foreach(yscanDir('script') as $f){
  is_file($f) && unlink($f);
}
foreach($list as $file){
  $filename = 'script/'.basename($file);
  if(preg_match('{\.min\.js$|\.min\.css$}', $filename)){
      continue;//压缩过的不处理
  }elseif(preg_match('{\.js$}', $filename)){
    if(in_array(basename($file),$combineJsList)){
      $hd = fopen('script/all.min.js','a');
    }else{
      $hd = fopen(str_replace('.js','.min.js',$filename),'w');
    }
    fwrite($hd, JSMin::minify(file_get_contents($file)));
    fclose($hd);
  }elseif(preg_match('{\.css$}', $filename)){
    $hd = fopen(str_replace('.css','.min.css',$filename),'w');
    fwrite($hd, compressCss(file_get_contents($file)));
    fclose($hd);
  }
}
echo 'already compressed all js and css.';