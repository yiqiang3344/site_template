<h3>
    <span>操作：<input type="submit" id="delete" value="禁用"/></span>
    <span style="float:right">
         搜索：
        <input type="text" id="search_val"/>
        <select id="search_type">
            <option value="username">名字</option>
            <option value="id">id</option>
            <option value="deleteFlag">禁用</option>
            <option value="ip">ip</option>
        </select>
         <input type="submit" id="search" value="确定"/>
    </span>
</h3>
<table class="js_list h60">
    <tr>
        <th width="45">全选 <input type="checkbox" class="js_cbox_all"/></th>
        <th id="order_id">id</th>
        <th id="order_username">名字</th>
        <th id="order_ip">ip</th>
        <th id="order_deleteFlag">禁用</th>
    </tr>
    {{#data}}
        <tr id="info_{{id}}">
            <td class="ac"><input type="checkbox" class="js_cbox" value="{{id}}"/></td>
            <td class="ac">{{id}}</td>
            <td id="">{{username}}</td>
            <td id="">{{ip}}</td>
            <td class="ac" id="attr_deleteFlag">{{deleteFlag}}</td>
        </tr>
    {{/data}}
</table>
<div id="page"></div>