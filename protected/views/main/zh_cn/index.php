<script type="text/javascript" src="<?php echo $this->url("js/main/index.js")?>"></script>
<script type="text/javascript">//php代码只能出现在这个脚本中
    var params = <?php echo json_encode($params);?>;

    //v
    print_page();
</script>