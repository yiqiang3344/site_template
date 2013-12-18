<div class="mfooter clearfix">
    <div class="fl ml100 clearfix">
        {{#list}}
        <div class="fl w300">
            {{#.}}
            <div class="w300">
                <a href="{{url}}">{{name}}</a>
            </div>
            {{/.}}
        </div>
        {{/list}}
    </div>
</div>