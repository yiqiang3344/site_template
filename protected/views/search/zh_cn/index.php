<div class="maincontent">
<?php echo $this->Mustache->render($this->template,$params); ?>
</div>

<script type="text/javascript" src="<?php echo $this->url("js/search/index.js")?>"></script>
<script type="text/javascript">//php代码只能出现在这个脚本中
    var params = <?php echo json_encode($params);?>;
    var pagerTemplate = Hogan.compile(<?php echo json_encode($this->publicSubTemplate['pagerTemplate']);?>);
    page_bind();
</script>