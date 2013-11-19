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

        $('#upload_logo').click(function(){
            var u = new uploader(document.getElementById('logo_file'),{
                url : getUrl('Main','AjaxUploadImage'),
                success : function(o){
                    if(o.code==1){
                        State.back(0);
                    }else{
                        alert(o.error);
                    }
                }
            });
            u.send();
            return false;
        });

        ////////////link///////////////
        $('#add_link').click(function(){
            $('[id^="link_"]').removeClass('merror');
            var name = $('#link_name').val(),
                url = $('#link_url').val(),
                sort = $('#link_sort').val() || 0;
            oneAjax('Main','AjaxAdd',{type:'Link',name:name,url:url,sort:sort},function(o){
                if(o.code==1){
                    State.back(0);
                }else{
                    $.each(o.errors,function(k,v){
                        $('#link_'+k).addClass('merror');
                    });
                }
            },this);
            return false;
        });

        $('#delete_link').click(function(){
            var ids = [];
            $('.js_link').find('.js_cbox:checked').each(function(){
                ids.push(this.value);
            });
            ids = ids.join(',');
            oneAjax('Main','AjaxDelete',{type:'Link',ids:ids},function(o){
                if(o.code==1){
                    State.back(0);
                }else{
                    alert('error');
                }
            },this);
            return false;
        });

        ////////////contact///////////////
        $('[id^=contact_edit_]').click(function(){
            var id = this.id.replace('contact_edit_','');
            State.forward('Main','ContactEdit',{id:id});
            return false;
        });

        $('#contact_add').click(function(){
            State.forward('Main','ContactEdit',{});
            return false;
        });

        $('#contact_delete').click(function(){
            var ids = [];
            $('.js_contact').find('.js_cbox:checked').each(function(){
                ids.push(this.value);
            });
            ids = ids.join(',');
            oneAjax('Main','AjaxDelete',{type:'Contact',ids:ids},function(o){
                if(o.code==1){
                    State.back(0);
                }else{
                    alert('error');
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