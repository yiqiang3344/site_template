<h3>
    <span>操作：<input type="submit" id="add" value="添加"/>  <input type="submit" id="delete" value="删除"/></span>
    <span style="float:right">
         搜索：
        <input type="text" id="search_val"/>
        <select id="search_type">
            <option value="name">名字</option>
            <option value="id">id</option>
            <option value="category">种类</option>
        </select>
        <input type="submit" id="search" value="确定"/>
    </span>
</h3>
<table class="h60">
    <tr>
        <th width="45">全选 <input type="checkbox" class="js_cbox_all"></th>
        <th id="order_id">id</th>
        <th id="order_category">种类</th>
        <th id="order_name">名字</th>
        <th id="order_nameFirstLetter">首字母</th>
        <th id="order_weight">权重</th>
        <th class="attr img" id="order_logo">logo</th>
        <th id="order_star">星级</th>
        <th id="order_score">评分</th>
        <th id="order_beFixed">固定</th>
        <th id="order_beRecommend">推荐</th>
        <th id="order_beGuarantee">担保</th>
        <th id="order_clickCount">点击数</th>
        <th id="order_commentCount">评论数</th>
        <th id="order_platform">平台</th>
        <th id="order_hasLicense">有证书</th>
        <th id="order_openedTime">开业时间</th>
        <th id="order_url">网址</th>
        <th id="order_urlPhoto">网站快照</th>
        <th id="order_abstract">简介</th>
        <th id="order_deleteFlag">已删除</th>
        <th>操作</th>
    </tr>
    {{#data}}
        <tr id="info_{{id}}" class="ac">
            <td class="ac"><input type="checkbox" class="js_cbox" value="{{id}}"/></td>
            <td class="ac">{{id}}</td>
            <td class="ac" id="attr_category">{{category}}</td>
            <td class="ac" id="attr_name">{{name}}</td>
            <td class="ac" id="attr_nameFirstLetter">{{nameFirstLetter}}</td>
            <td class="ac" id="attr_weight">{{weight}}</td>
            <td class="ac" id="attr_logo"><img src="{{logo}}"/></td>
            <td class="ac" id="attr_star">{{star}}</td>
            <td class="ac" id="attr_score">{{score}}</td>
            <td class="ac" id="attr_beFixed">{{beFixed}}</td>
            <td class="ac" id="attr_beRecommend">{{beRecommend}}</td>
            <td class="ac" id="attr_beGuarantee">{{beGuarantee}}</td>
            <td class="ac" id="attr_clickCount">{{clickCount}}</td>
            <td class="ac" id="attr_commentCount">{{commentCount}}</td>
            <td class="ac" id="attr_platform">{{platform}}</td>
            <td class="ac" id="attr_hasLicense">{{hasLicense}}</td>
            <td class="ac" id="attr_openedTime" width="67">{{openedTime}}</td>
            <td class="ac" id="attr_url">{{url}}</td>
            <td id="attr_urlPhoto"><img src="{{urlPhoto}}"/></td>
            <td id="attr_abstract">{{abstract}}</td>
            <td id="attr_deleteFlag" class="ac">{{deleteFlag}}</td>
            <td class="ac"><button id="edit_{{id}}">编辑</button></td>
        </tr>
    {{/data}}
</table>
<div id="page"></div>