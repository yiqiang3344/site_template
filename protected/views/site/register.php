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
        $('.js_verifyImg').click(function() {
            $.ajax({
                url: getUrl('Site', 'captcha', {
                    refresh: 1
                }),
                dataType: 'json',
                cache: false,
                success: function(data) {
                    $('.js_verifyImg').attr('src', data['url']);
                    $('body').data('captcha.hash', [data['hash1'], data['hash2']]);
                    return false;
                }
            });
            return false;
        });
        $('.js_registerForm').find('[name="submit"]').click(function() {
            $('.js_registerForm').find('.merror').removeClass('merror');
            oneAjax('Site', 'AjaxRegister', $('.js_registerForm').serialize(), function(obj) {
                if (obj.code === 1) {
                    State.back(0);
                } else if (obj.code === 2) {
                    $.each(obj.errors, function(k, v) {
                        return $('.js_registerForm').find('[name=' + k + ']').addClass('merror');
                    });
                }
                return false;
            }, this);
            return false;
        });
    }
</script>
<script type="text/javascript">//php代码只能出现在这个脚本中
    var params = <?php echo json_encode($params);?>;
    page_bind();
</script>