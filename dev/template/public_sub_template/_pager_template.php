<div class="mpager {{#className}}{{className}}{{/className}}">
    {{#last}}
    <span class="link"><a href="{{last.href}}" {{#last.id}}id="{{last.id}}"{{/last.id}}>上一页</a></span>
    {{/last}}
    {{#list}}
    <span class="link">
        {{#ellipsis}}
        ...
        {{/ellipsis}}
        {{^ellipsis}}
        <a href="{{href}}" {{#id}}id="{{id}}"{{/id}} {{#select}}style="text-decoration: underline;"{{/select}}>{{name}}</a>
        {{/ellipsis}}
    </span>
    {{/list}}
    {{#next}}
    <span class="link"><a href="{{next.href}}" {{#next.id}}id="{{next.id}}"{{/next.id}}>下一页</a></span>
    {{/next}}
</div>