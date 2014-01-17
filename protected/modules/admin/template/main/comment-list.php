<h3>
    <span>操作：<input type="submit" id="delete" value="删除"/></span>
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
<table class="js_comment">
    <tr>
        <th width="45">全选 <input type="checkbox" class="js_cbox_all"></th>
        <th id="order_id">id</th>
        <th id="order_companyId">公司id</th>
        <th id="order_userId">用户id</th>
        <th id="order_username">用户名</th>
        <th id="order_content">内容</th>
        <th id="order_totalScore">总评分</th>
        <th id="order_scoreA">评分A</th>
        <th id="order_scoreB">评分B</th>
        <th id="order_scoreC">评分C</th>
        <th id="order_deleteFlag">已删除</th>
    </tr>
    {{#data}}
        <tr id="info_{{id}}">
            <td class="ac">{{id}}</td>
            <td class="ac" id="">{{companyId}}</td>
            <td class="ac" id="">{{userId}}</td>
            <td id="">{{username}}</td>
            <td id="attr_content">{{content}}</td>
            <td id="attr_totalScore">{{totalScore}}</td>
            <td id="attr_scoreA">{{scoreA}}</td>
            <td id="attr_scoreB">{{scoreB}}</td>
            <td id="attr_scoreC">{{scoreC}}</td>
            <td id="attr_deleteFlag" class="ac">{{deleteFlag}}</td>
            <td class="ac"><button id="edit_{{id}}">编辑</button></td>
        </tr>
    {{/data}}
</table>
 <div id="page"></div>
