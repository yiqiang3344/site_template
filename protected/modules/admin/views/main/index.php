<script type="text/javascript" src="<?php echo $this->url('ueditor/ueditor.config.js');?>"></script>
<script type="text/javascript" src="<?php echo $this->url('ueditor/ueditor.all.js');?>"></script>
<script type="text/javascript">//template
    var template = Hogan.compile(<?php echo json_encode($this->template);?>);
</script>
<script type="text/javascript">//static
    function print_page(){
        var html = '<div class="maincontent"></div>';
        document.write(html);

        content_refresh();
    }

    function content_refresh(){
        var html = template.render(params);
        html += '<div>';
        html += '<textarea name="后台取值的key" id="myEditor" style="height:400px;width:500px;">这里写你的初始化内容</textarea>';
        html += '<input type="submit" id="submit" value="提交"/>';
        html += '</div>';
        $('.maincontent').html(html);

        var editor = UE.getEditor('myEditor');
        editor.ready(function(){
            this.setContent('test');
        });
        $('#submit').click(function(){
            console.log(editor.getContent());
        });
    }
</script>
<script type="text/javascript">//php代码只能出现在这个脚本中
    var params = <?php echo json_encode($params);?>;

    //v
    print_page();
</script>