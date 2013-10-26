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
        State.setDic({
            'main/index':'首页',
            'comment/index':'评论',
        });
        State.setDefaultPosition('main/index',{});
        var html = template.render(params);
        html += State.getPositionHtml();
        $('.maincontent').html(html);
    }
</script>
<script type="text/javascript">//php代码只能出现在这个脚本中
    var params = <?php echo json_encode($params);?>;

    //v
    print_page();
</script>