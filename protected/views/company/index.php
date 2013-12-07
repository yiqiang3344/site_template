<div class="maincontent">
<?php echo $this->Mustache->render($this->template,$params); ?>
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
        $('.js_order_do').click(function(){
            var orders = [];
            $('[id^=order_]').each(function(){
                var id = this.id.replace('order_','');
                var val = $(this).val();
                if(val!==''){
                    orders.push(id+'-'+val);
                }
            });
            if(orders.length>0){
                var href = document.location.href.replace(/order=[^&]+[&]?/,'');
                var ss = 'order='+orders.join('_');
                document.location.href = href.indexOf('?')>=0 ? (href.indexOf('?') == href.length-1 ? href.replace('?','?'+ss) : href.replace('?','?'+ss+'&')) : (href+'?'+ss);
            }
        });
        Pager($('#pager'), 'Company', 'Index', {search:search,order:order}, params);
    }
</script>
<script type="text/javascript">//php代码只能出现在这个脚本中
    var params = <?php echo json_encode($params);?>;
    var search = <?php echo json_encode($search);?>;
    var order = <?php echo json_encode($order);?>;
    var pagerTemplate = Hogan.compile(<?php echo json_encode($this->publicSubTemplate['pagerTemplate']);?>);
    page_bind();
</script>