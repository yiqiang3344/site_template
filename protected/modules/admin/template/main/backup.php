<div>
    <div>
        <input id="name" type="text" value="{{now}}">
        <input id="backup" type="submit" value="备份">
    </div>
    <div>
        <p>备份列表</p>
        <ul>
            <li>
                <div class="fl">id</div>
                <div class="fl">标识</div>
                <div class="fl">日期</div>
            </li>
            {{#list}}
            <li>
                <div class="fl">{{id}}</div>
                <div class="fl attr_name">{{name}}</div>
                <div class="fl attr_datetime">{{datetime}}</div>
                <div class="fl attr_lastRebackTime">{{lastRebackTime}}</div>
                <div class="fl">
                    <input type="submit" id="reback_{{id}}" value="还原">
                </div>
            </li>
            {{/list}}
        </ul>
    </div>
</div>