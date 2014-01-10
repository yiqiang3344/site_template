<div class="mpager {{#className}}{{className}}{{/className}}">
    {{#last}}
    <a href="{{last.href}}" {{#last.id}}id="{{last.id}}"{{/last.id}}>上一页</a>
    {{/last}}
    {{#list}}
        {{#ellipsis}}
        ...
        {{/ellipsis}}
        {{^ellipsis}}
        <a class="{{#select}}udl{{/select}}" href="{{href}}" {{#id}}id="{{id}}"{{/id}}>{{name}}</a>
        {{/ellipsis}}
    {{/list}}
    {{#next}}
   <a href="{{next.href}}" {{#next.id}}id="{{next.id}}"{{/next.id}}>下一页</a>
    {{/next}}
</div>