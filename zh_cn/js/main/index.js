var template = new Hogan.Template();template.r =function(c,p,i){var _=this;_.b(i=i||"");_.b("<div>");_.b("\n" + i);_.b("	首页测试:");_.b(_.v(_.f("test",c,p,0)));_.b("\n" + i);_.b("</div>");return _.fl();;};
function print_page(){
        var html = '<div class="maincontent"></div>';
        document.write(html);

        content_refresh();
    }

    function content_refresh(){
        var html = template.render(params);
        $('.maincontent').html(html);
    }