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

        $('#submit').click(function(){
            var data = {};
            $('.attr').each(function(){
                $(this).removeClass('merror');
                data[this.id] = $(this).val();
            });
            oneAjax('Site','AjaxLogin',data,function(o){
                if(o.code==1){
                    State.forward('Main','Index');
                }else{
                    $.each(o.errors,function(k,v){
                        $('#'+k).addClass('merror');
                    });
                }
            },this);
            return false;
        });
    }
</script>
<script type="text/javascript">//php代码只能出现在这个脚本中
    var params = <?php echo json_encode($params);?>;

    //v
    print_page();
</script>