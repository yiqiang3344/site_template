<div class="maincontent">
<?php echo $this->Mustache->render($this->template,$params); ?>
</div>

<script type="text/javascript">//template
    var fTemplate = Hogan.compile(<?php echo json_encode($this->template);?>);
</script>
<script type="text/javascript">//static
    function content_refresh(){
        var html = fTemplate.render(params);
        $('.maincontent').html(html);
        page_bind();
    }

    function page_bind(){
        Pager($('#pager'), 'Rank', 'Index', {key:key}, params);
    }
</script>
<script type="text/javascript">//php代码只能出现在这个脚本中
    var params = <?php echo json_encode($params);?>;
    var key = <?php echo json_encode($key);?>;
    var pagerTemplate = Hogan.compile(<?php echo json_encode($this->publicSubTemplate['pagerTemplate']);?>);
    page_bind();
</script>