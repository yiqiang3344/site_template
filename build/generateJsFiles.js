var hogan = require('hogan.js');
var fs = require('fs');
var helper = require('./helper');
var lang_list = [
    ];

process.chdir('../protected/');
helper.scanDir('./views',false,true).forEach(function(file){
    if(helper.isDir('./views/'+file) && file!='.' && file!='..'){
        generateJsFiles(file);
    }
});
//从dev/template中读取子模板编译为js方法后保存为js文件：公用模板保存到[lang]/js/helper.min.js 局部模板保存为[lang]/js/[controller]_sub_template.min.js
process.chdir('../');
lang_list.forEach(function(lang){
    var made_js_map = {};
    helper.scanDir(lang+'/template',true).forEach(function(file){
        var basename=helper.baseName(file,true);
        if(helper.isFile(file) && basename.indexOf('_')==0){//子模板命名都以下划线开头
            //读取文件编译为字符串
            var name = '';
            basename.substring(1).split('_').forEach(function(v){
                name += v.substring(0,1).toUpperCase()+v.substring(1);
            });
            name = name.substring(0,1).toLowerCase()+name.substring(1);
            var ss ='var '+name+'=new Hogan.Template();'+name+'.r ='+hogan.compile(fs.readFileSync(file,'utf8'),{asString:true})+';',
                dir = file.match(new RegExp('^'+lang+'/template/(.*)/'))[1],
                mode;
            if(dir == 'public_sub_template'){
                fd = fs.openSync(lang+'/js/'+'helper.min.js', 'a+');
            }else{
                if(!made_js_map[dir]){
                    mode = 'w';//覆盖方式写文件
                }else{
                    made_js_map[dir] = 1;
                    mode = 'a+';//添加方式写文件
                }
                fd = fs.openSync(lang+'/js/'+dir+'_sub_template.min.js', mode);
            }
            fs.writeSync(fd, ss);
            fs.closeSync(fd);
        }
    });
});

console.log('finish generate js files.');

//从views文件夹的翻译视图中提取js文件码,压缩后生成js文件
function generateJsFiles(dir){
    lang_list.forEach(function(lang){
        if(helper.isDir('./views/'+dir+'/'+lang)){
            helper.scanDir('./views/'+dir+'/'+lang,false,true).forEach(function(file){
                if(m = file.match(/(.*)\.php$/)){
                    var res = jsExtract(fs.readFileSync('./views/'+dir+'/'+lang+'/'+file,'utf8'),'js/'+dir+'/'+m[1]+'.js','../'+lang+'/template/'+dir+'/'+m[1]+'.php');
                    if(res[1]){
                        var fd = fs.openSync('./views/'+dir+'/'+lang+'/'+file, 'w');
                        fs.writeSync(fd, res[0])
                        fs.closeSync(fd);
                        helper.mkdir('../'+lang+'/js/'+dir);
                        fd = fs.openSync('../'+lang+'/js/'+dir+'/'+m[1]+'.min.js', 'w');
                        fs.writeSync(fd, helper.compressJs(res[1]));
                        fs.closeSync(fd);
                    }
                }
            });
        }
    });
    function jsExtract(content,path,tpl_path){
        var m;
        if(m=content.match(/<script\s+type\s*=\s*\"text\/javascript\"\s*>\s*\/\/static([\s\S]*?)<\/script>/im)){
            tpl = fs.readFileSync(tpl_path,'utf8');
            js='var template = new Hogan.Template();template.r ='+hogan.compile(tpl,{asString:true})+';\r\n'+m[1].trim();
            content=content.replace(/<script\s+type\s*=\s*"text\/javascript"\s*>\s*\/\/template([\s\S]*?)<\/script>\s*<script\s+type\s*=\s*"text\/javascript"\s*>\s*\/\/static([\s\S]*?)<\/script>/i,'<script type="text/javascript" src="<?php echo $this->url("'+path+'")?>"></script>');
            if(js.indexOf('<?')!==-1){
                console.log('jsExtract fail');
                process.exit;
            }
        }else{
            js=false;
        }
        return [content,js];
    }
}