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
        $('.maincontent').html(html);

        var editor = UE.getEditor('myEditor');
        editor.ready(function(){
            // this.setContent('test');
        });
        $('#submit').click(function(){
            var content = editor.getContent(),
                id = params.id || 0;
                name = $('#name').val(),
                urlName = $('#urlName').val(),
                sort = $('#sort').val();
            oneAjax('Main','AjaxAdd',{type:'contact',id:id,name:name,urlName:urlName,content:content,sort:sort},function(o){
                if(o.code==1){
                    State.back(1);
                }else{
                    $.each(o.errors,function(k,v){
                        $('#link_'+k).addClass('merror');
                    });
                }
            },this);
        });
    }
</script>
<script type="text/javascript">//php代码只能出现在这个脚本中
    var params = <?php echo json_encode($params);?>;

    //v
    print_page();
</script>