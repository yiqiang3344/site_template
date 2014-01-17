<h3>
    <span>操作：<input type="submit" id="add" value="添加"/>  <input type="submit" id="delete" value="删除"/></span>
    <span style="float:right">
         搜索：
        <input type="text" id="search_val"/>
        <select id="search_type">
            <option value="title">标题</option>
            <option value="id">id</option>
        </select>
        <input type="submit" id="search" value="确定"/>
    </span>
</h3>
<table class="h60">
    <tr>
        <th width="45">全选 <input type="checkbox" class="js_cbox_all"/></th>
        <th class="ac" id="order_id">id</th>
        <th width="100" id="order_categoryName">分类</th>
        <th width="45" id="order_top">置顶</th>
        <th id="order_title">标题</th>
        <th id="order_abstract">简要</th>
        <th id="order_img">有图片</th>
        <th width="50" id="order_deleteFlag">已删除</th>
        <th width="50">操作</th>
    </tr>
    {{#data}}
        <tr id="info_{{id}}">
            <td class="ac"><input type="checkbox" class="js_cbox" value="{{id}}"/></td>
            <td class="ac">{{id}}</td>
            <td id="attr_categoryName">{{categoryName}}</td>
            <td class="ac" id="attr_top">{{top}}</td>
            <td id="attr_title">{{title}}</td>
            <td id="attr_abstract">{{abstract}}</td>
            <td id="">{{#img}}<img src="{{img}}" alt="无"/>{{/img}}</td>
            <td class="ac" id="attr_deleteFlag">{{deleteFlag}}</td>
            <td class="ac"><button id="edit_{{id}}">编辑</button></td>
        </tr>
    {{/data}}
</table>
<div id="page"></div>