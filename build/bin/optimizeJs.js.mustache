var hogan = require('hogan.js');
var fs = require('fs');
var helper = require('./helper');
var lang_list = [
    {{#site.langs}}
        '{{.}}',
    {{/site.langs}}
    ];

// 编译各语言template
//     试图模板编译为(lang)/js/(controller)/(view).min.js
//     公用模板保存到(lang)/js/helper.min.js 
//     局部模板保存为(lang)/js/(controller)_sub_template.min.js
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
                fd = fs.openSync(lang+'/js/'+'helper.js', 'a+');
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
        }else if(helper.isFile(file)){
            //试图模板
            var ss ='var fTemplate=new Hogan.Template();fTemplate.r ='+hogan.compile(fs.readFileSync(file,'utf8'),{asString:true})+';',
                dir = file.match(new RegExp('^'+lang+'/template/(.*)/'))[1];
            helper.mkdir(lang+'/js/'+dir);
            fd = fs.openSync(lang+'/js/'+dir+'/'+helper.baseName(file,true)+'.min.js', 'w+');
            fs.writeSync(fd, ss);
            fs.closeSync(fd);
        }
    });
});
console.log('success transformed template to js file.');

// 处理视图文件
//     从视图文件夹的翻译视图中提取指定js文件码,压缩后追加到(lang)/js/(controller)/(view).min.js中，不存在则创建;然后替换视图中提取代码为js文件外链
process.chdir('protected');
helper.scanDir('./views',false,true).forEach(function(file){
    if(helper.isDir('./views/'+file) && file!='.' && file!='..'){
        generateJsFiles(file);
    }
});
console.log('success extract view`s js code to js file.');

function generateJsFiles(dir){
    lang_list.forEach(function(lang){
        if(helper.isDir('./views/'+dir+'/'+lang)){
            helper.scanDir('./views/'+dir+'/'+lang,false,true).forEach(function(file){
                if(m = file.match(/(.*)\.php$/)){
                    var res = jsExtract(fs.readFileSync('./views/'+dir+'/'+lang+'/'+file,'utf8'),'js/'+dir+'/'+m[1]+'.js');
                    if(res[1]){
                        var fd = fs.openSync('./views/'+dir+'/'+lang+'/'+file, 'w');
                        fs.writeSync(fd, res[0])
                        fs.closeSync(fd);
                        helper.mkdir('../'+lang+'/js/'+dir);
                        fd = fs.openSync('../'+lang+'/js/'+dir+'/'+m[1]+'.min.js', 'a+');
                        fs.writeSync(fd, helper.compressJs(res[1]));
                        fs.closeSync(fd);
                    }
                }
            });
        }
    });
    function jsExtract(content,path){
        var m,
            js;
        if(m=content.match(/<script\s+type\s*=\s*\"text\/javascript\"\s*>\s*\/\/static([\s\S]*?)<\/script>/im)){
            js = m[1].trim();
            content=content.replace(/(<script\s+type\s*=\s*"text\/javascript"\s*>\s*\/\/template([\s\S]*?)<\/script>\s*)?<script\s+type\s*=\s*"text\/javascript"\s*>\s*\/\/static([\s\S]*?)<\/script>/i,'<script type="text/javascript" src="<?php echo $this->url("'+path+'")?>"></script>');
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