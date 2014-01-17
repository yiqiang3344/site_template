<h3>
    <span>标识：<input id="name" type="text" placeholder="{{now}}"  style="width: 130px" > <input id="backup" type="submit" value="备份"></span>
    <span style="float:right">
        搜索：
        <input type="text" id="search_val"/>
        <select id="search_type">
            <option value="name">标识</option>
            <option value="createTime">备份时间</option>
            <option value="id">id</option>
        </select>
        <input type="submit" id="search" value="确定"/>
    </span>
</h3>
<table class="h60">
    <tr>
        <th width="45">全选 <input type="checkbox" class="js_cbox_all"/></th>
        <th id="order_id">id</th>
        <th id="order_name">标识</th>
        <th id="order_createTime">备份时间</th>
        <th id="order_lastRebackTime">还原时间</th>
        <th>操作</th>
    </tr>
    {{#data}}
        <tr id="info_{{id}}">
            <td class="ac"><input type="checkbox" class="js_cbox" value="{{id}}"/></td>
            <td class="ac">{{id}}</td>
            <td class="ac" id="attr_name">{{name}}</td>
            <td class="ac">{{createTime}}</td>
            <td class="ac">{{lastRebackTime}}</td>
            <td class="ac"><button id="reback_{{id}}">还原</button></td>
        </tr>
    {{/data}}
</table>
<div id="page"></div>