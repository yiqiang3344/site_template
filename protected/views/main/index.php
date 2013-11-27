<div class="maincontent">
<?php
    $m = new Mustache_Engine;
    echo $m->render($this->template,$params);
?>
</div>

<script type="text/javascript">//template
    var template = Hogan.compile(<?php echo json_encode($this->template);?>);
</script>
<script type="text/javascript">//static
    function content_refresh(){
        var html = template.render(params);
        $('.maincontent').html(html);
        page_bind();
    }

    function page_bind(){
        
    }
</script>
<script type="text/javascript">//php代码只能出现在这个脚本中
    var params = <?php echo json_encode($params);?>;
    page_bind();
</script>