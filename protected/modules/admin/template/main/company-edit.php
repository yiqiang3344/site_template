<form id="form">
    <table>
        <tr>
            <th width="60">种类</th>
            <td><input class="attr" id="category" name="category" type="text" value="{{category}}"></td>
        </tr>
        <tr>
            <th>名称</th>
            <td><input class="attr" id="name" name="name" type="text" value="{{name}}"></td>
        </tr>
        <tr>
            <th>首字母</th>
            <td><input class="attr" id="nameFirstLetter" name="nameFirstLetter" type="text" value="{{nameFirstLetter}}"></td>
        </tr>
        <tr>
            <th>权重</th>
            <td><input class="attr" id="weight" name="weight" type="text" value="{{weight}}"></td>
        </tr>
        <tr>
            <th>logo</th>
            <td><img src="{{logo}}" alt="无"> <br><input class="attr" id="logo" name="logo" type="file"/> </td> 
        </tr>
        <tr >
            <th>星级</th>
            <td><input class="attr" id="star" name="star" type="text" value="{{star}}"></td>
        </tr>
        <tr>
            <th>评分</th>
            <td><input class="attr" id="score" name="score" type="text" value="{{score}}"></td>
        </tr>
        <tr>
            <th>固定</th>
            <td><input class="attr" id="beFixed" name="beFixed" type="text" value="{{beFixed}}"></td>
        </tr>
        <tr>
            <th>推荐</th>
            <td><input class="attr" id="beRecommend" name="beRecommend" type="text" value="{{beRecommend}}"></td>
        </tr>
        <tr>
            <th>担保</th>
            <td><input class="attr" id="beGuarantee" name="beGuarantee" type="text" value="{{beGuarantee}}"></td>
        </tr>
        <tr>
            <th>点击数</th>
            <td><input class="attr" id="clickCount" name="clickCount" type="text" value="{{clickCount}}"></td>
        </tr>
        <tr>
            <th>评论数</th>
            <td><input class="attr" id="commentCount" name="commentCount" type="text" value="{{commentCount}}"></td>
        </tr>
        <tr>
            <th>平台</th>
            <td><input class="attr" id="platform" name="platform" type="text" value="{{platform}}"></td>
        </tr>
        <tr>
            <th>有证书</th>
            <td><input class="attr" id="hasLicense" name="hasLicense" type="text" value="{{hasLicense}}"></td>
        </tr>
        <tr>
            <th>开业时间</th>
            <td><input class="attr" id="openedTime" name="openedTime" type="text" value="{{openedTime}}"></td>
        </tr>
        <tr>
            <th>网址</th>
            <td><input class="attr" id="url" name="url" type="text" value="{{url}}"></td>
        </tr>
        <tr >
            <th>网页快照</th>
            <td><img src="{{urlPhoto}}" alt="无"><br> <input class="attr" id="urlPhoto" name="urlPhoto" type="file"/></td> 
        </tr>
        <tr>
            <th>删除</th>
            <td><input class="attr" id="deleteFlag" name="deleteFlag" type="text" value="{{deleteFlag}}"></td>
        </tr>
        <tr>
            <th>简介</th>
            <td><textarea style="width:400px;height:200px;" class="attr" id="abstract" name="abstract">{{abstract}}</textarea></td>
        </tr>
        <tr>
            <th>描述</th>
            <td><textarea style="width:600px;height:400px;" class="attr" id="description" name="description">{{description}}</textarea></td>
        </tr>
        <tr>
            <th>操作</th>
            <td><input id="submit" type="submit" value="提交"></td>
        </tr>
    </table>
</form>
