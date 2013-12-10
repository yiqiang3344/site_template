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
        $('.js_comment_submit').click(function(){
            var data = {companyId:companyId};
            var has_error = false;
            $.each($('[id^=comment_]'),function(){
                $(this).removeClass('merror');
                var v = $(this).val();
                if(v==''){
                    $(this).addClass('merror');
                    has_error = true;
                }
                data[this.id.replace('comment_','')] = v;
            });
            if(has_error){
                return false;
            }
            oneAjax('Company','AjaxAddComment',data,function(o){
                if(o.code==1){
                    State.back(0);
                }else{
                    for(var k in o.errors){
                        alert(o.errors[k][0]);
                        return false;
                    }
                }
            },this);
            return false;
        });

        Pager($('#pager'), 'Company', 'Go', {to:companyId}, params.comments);
    }
</script>
<script type="text/javascript">//php代码只能出现在这个脚本中
    var params = <?php echo json_encode($params);?>;
    var companyId = <?php echo json_encode($companyId);?>;
    var pagerTemplate = Hogan.compile(<?php echo json_encode($this->publicSubTemplate['pagerTemplate']);?>);
    page_bind();
</script>