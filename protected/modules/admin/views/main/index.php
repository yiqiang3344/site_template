<script type="text/javascript" src="<?php echo $this->url('ueditor/ueditor.config.js');?>"></script>
<script type="text/javascript" src="<?php echo $this->url('ueditor/ueditor.all.js');?>"></script>
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
        // html += '<div>';
        // html += '<textarea name="后台取值的key" id="myEditor" style="height:400px;width:500px;">这里写你的初始化内容</textarea>';
        // html += '<input type="submit" id="submit" value="提交"/>';
        // html += '</div>';
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

        $('#add_link').click(function(){
            $('[id^="link_"]').removeClass('merror');
            var name = $('#link_name').val(),
                url = $('#link_url').val(),
                sort = $('#link_sort').val() || 0;
            oneAjax('Main','AjaxAddLink',{name:name,url:url,sort:sort},function(o){
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

        $('.js_cbox_all').click(function(e){
            var a = $(this).parents('ul').find('.js_cbox,.js_cbox_all');
            if($(this).filter(':checked').length){
                $.each(a,function(){
                    this.checked = true;
                })
            }else{
                $.each(a,function(){
                    this.checked = false;
                })
            }
        });

        $('#delete_link').click(function(){
            var ids = [];
            $('.js_link').find('.js_cbox:checked').each(function(){
                ids.push(this.value);
            });
            ids = ids.join(',');
            oneAjax('Main','AjaxDeleteLink',{ids:ids},function(o){
                if(o.code==1){
                    State.back(0);
                }else{
                    alert('error');
                }
            },this);
            return false;
        });

        // var editor = UE.getEditor('myEditor');
        // editor.ready(function(){
        //     this.setContent('test');
        // });
        // $('#submit').click(function(){
        //     console.log(editor.getContent());
        // });
    }
</script>
<script type="text/javascript">//php代码只能出现在这个脚本中
    var params = <?php echo json_encode($params);?>;

    //v
    print_page();
</script>