<?php $pageNum = $pageInfo['lastPage'];
    $currentPage = $pageInfo['page'];
    $pageMenuNum = PAGE_MENU_NUM;
    $startPage = max($currentPage - intval(PAGE_MENU_NUM / 2), 1);
    $endPage = min($currentPage + intval(PAGE_MENU_NUM / 2), $pageNum);
    if ($endPage - $startPage < $pageMenuNum - 1 && $endPage - $startPage < $pageNum - 1) {
        if ($startPage == 1)
            $endPage = min($pageNum, $pageMenuNum);
        if ($endPage == $pageNum)
            $startPage = max($endPage + 1 - $pageMenuNum, 1);
    }
    $id = isset($id) ? $id : '';
    if ($pageNum > 1) { ?>
        <!--showpage start-->
        <div style="float:right;">
            <span class="left <?php echo $currentPage == 1 ? 'current' : 'amp' ?>" id="previous<?php echo $id; ?>"></span>
            <span>
                <?php for($i=$startPage; $i<=$endPage; $i++){ ?>
                    <a <?php if($i == $currentPage){ ?> class="on" href="#_self"<?php }else{ ?>href="<?php echo $this->createUrl('questEvent/index',array('page'=>$i));?>"<?php }?> id="em<?php echo $id; ?>"><?php echo $i;?></a>
                <?php } ?>
            </span>
            <span class="right <?php echo $currentPage == $pageNum ? 'current' : 'amp' ?>" id="next<?php echo $id; ?>"></span>
        </div>
        <!--showpage end-->
<?php } ?>

<?php if($pageNum!=0 && $id==''){ ?>
    <input type="hidden" id="pageNum" value="<?php echo $pageNum; ?>" />
    <input type="hidden" id="currentPage" value="<?php echo $currentPage; ?>" />
<?php } ?>
<script  type="text/javascript">
    page = function(type){
        var pageNum = $("#pageNum").attr('value');
        var page = parseInt($("#currentPage").attr("value"));
        if(type == 1){
            page = page > 1 ? page - 1 : 1;
        }else{
            page = page < pageNum ? page + 1 : pageNum;
        }
        window.location.href = "<?php echo $sourceUrl ?>"+"&page="+page;
    }
    
    $(document).ready(function(){
        var currentPage = $("#currentPage").attr('value');
        $("#em<?php echo $id; ?>"+currentPage).parent().show();
        
        $("#previous<?php echo $id; ?>").click(function(){
            <?php if ($currentPage != 1) { ?>
                page(1);
            <?php } ?>
        });
        
        $("#next<?php echo $id; ?>").click(function(){
            <?php if ($currentPage != $pageNum) { ?>
                page(2);
            <?php } ?>
        });
    });
</script>

