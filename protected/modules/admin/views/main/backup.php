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

        //备份
        $('#backup').click(function(){
            var data = {name:$('#name').val()};
            oneAjax('Main','AjaxAdd',data,function(o){
                if(o.code==1){
                    State.back(0);
                }else{
                    $.each(o.errors,function(k,v){
                        $('#'+k).addClass('merror');
                    });
                }
            },this);
        });

        //还原
        $('[id^=reback_]').click(function(){
            var data = {id:this.id.replace('reback_','')};
            oneAjax('Main','AjaxReback',data,function(o){
                if(o.code==1){
                    State.back(0);
                }else{
                    alert(o.errors);
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