<div>
    <h2>后台首页</h2>
    <div>
        <h3>logo管理</h3>
        <p>当前logo</p>
        <div>
            <img src="{{logo_url}}" alt="logo">
        </div>
        <div>
            <input type="file" id="logo_file">
        </div>
        <div>
            <input type="submit" id="upload_logo" value="提交">
        </div>
    </div>
    <div>
        <h3>导航外链管理</h3>
        <ul class="mlist js_link">
            <li class="clearfix">
                <div class="fl w50">
                     <input type="checkbox" class="js_cbox_all"/>
                </div>
                <div class="fl w200">name</div>
                <div class="fl w300">url</div>
            </li>
            {{#links}}
            <li  class="clearfix">
                <div class="fl w50">
                     <input type="checkbox" class="js_cbox" value="{{id}}"/>
                </div>
                <div class="fl w200">{{name}}</div>
                <div class="fl w300">{{url}}</div>
            </li>
            {{/links}}
        </ul>
        <div>
            name<input type="text" id="link_name"/>
        </div>
        <div>
            url<input type="text" id="link_url"/>
        </div>
        <div>
            sort<input type="text" id="link_sort" value="0"/>
        </div>
        <div>
            <input type="submit" id="add_link" value="添加"/>
            <input type="submit" id="delete_link" value="删除"/>
        </div>
    </div>
    <div>
        <h3>联系我们管理</h3>
        <ul class="mlist js_contact">
            <li class="clearfix">
                <div class="fl w50">
                     <input type="checkbox" class="js_cbox_all"/>
                </div>
                <div class="fl w200">name</div>
                <div class="fl w300">urlName</div>
            </li>
            {{#contacts}}
            <li  class="clearfix">
                <div class="fl w50">
                     <input type="checkbox" class="js_cbox" value="{{id}}"/>
                </div>
                <div class="fl w200">{{name}}</div>
                <div class="fl w300">{{urlName}}</div>
                <div class="fl w300"><a href="" id="contact_edit_{{id}}">编辑</a></div>
            </li>
            {{/contacts}}
        </ul>
        <div>
            <input type="submit" id="contact_add" value="添加"/>
            <input type="submit" id="contact_delete" value="删除"/>
        </div>
    </div>
</div>