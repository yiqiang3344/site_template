<h3>
    <span>操作：<input type="submit" id="add" value="添加"/>  <input type="submit" id="delete" value="删除"/></span>
    <span style="float:right">
         搜索：
        <input type="text" id="search_val"/>
        <select id="search_type">
            <option value="name">名称</option>
            <option value="id">id</option>
        </select>
        <input type="submit" id="search" value="确定"/>
    </span>
</h3>
<table class="js_list">
    <tr>
        <th width="45">全选 <input type="checkbox" class="js_cbox_all"/></th>
        <th id="order_id">id</th>
        <th id="order_name">名称</th>
        <th id="order_title">title</th>
        <th id="order_sort">权重</th>
        <th id="order_deleteFlag">已删除</th>
    </tr>
    {{#data}}
        <tr id="info_{{id}}">
            <td class="ac"><input type="checkbox" class="js_cbox" value="{{id}}"/></td>
            <td class="ac">{{id}}</td>
            <td id="attr_name">{{name}}</td>
            <td id="attr_title">{{title}}</td>
            <td id="attr_sort" class="ac">{{sort}}</td>
            <td id="attr_deleteFlag" class="ac">{{deleteFlag}}</td>
        </tr>
    {{/data}}
</table>
<div id="page"></div>