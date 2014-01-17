<table>
    <tr>
        <th>标题</th>
        <td><input class="attr" id="title" type="text" value="{{title}}"></td>
    </tr>
    <tr>
        <th>标题</th>
        <td> 
            <select class="attr" id="categoryId">
                {{#categoryList}}
                <option value="{{id}}" {{#selected}}selected{{/selected}}>{{name}}</option>
                {{/categoryList}}
            </select>
        </td>
    </tr>
    <tr>
        <th>置顶</th>
        <td><input class="attr" id="top" value="{{top}}"/></td>
    </tr>
    <tr>
        <th>简介</th>
        <td><textarea style="width:400px;height:200px;" class="attr" id="abstract">{{abstract}}</textarea></td>
    </tr>
    <tr>
        <th>插图</th>
        <td><img src="{{img}}"/></td>
    </tr>
    <tr>
        <th>删除</th>
        <td><input class="attr" id="deleteFlag" type="text" value="{{deleteFlag}}"></td>
    </tr> 
    <tr>
        <th>内容</th>
        <td><textarea style="width:600px;height:400px;" class="attr" id="content">{{content}}</textarea></td>
    </tr> 
    <tr>
        <th>操作</th>
        <td><input id="submit" type="submit" value="提交"></td>
    </tr> 
</table>