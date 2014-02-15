<form id="form">
    <table>
        <tr>
            <th>排序</th>
            <td><input class="attr" id="sort" name="sort" type="text" value="{{sort}}"></td>
        </tr>
        <tr >
            <th>图片</th>
            <td><img src="{{img}}" alt="无"><br> <input class="attr" id="img" name="img" type="file"/></td> 
        </tr>
        <tr>
            <th>url</th>
            <td><input class="attr" id="url" name="url" type="text" value="{{url}}"></td>
        </tr>
        <tr>
            <th>已删除</th>
            <td><input class="attr" id="deleteFlag" name="deleteFlag" type="text" value="{{deleteFlag}}"></td>
        </tr>
        <tr>
            <th>操作</th>
            <td><input id="submit" type="submit" value="提交"></td>
        </tr> 
    </table>
</form>
