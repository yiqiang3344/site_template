<div>
    <ul class="mlist_abstract">
        {{#data}}
        <li class="line" id="line_{{id}}">
            <div class="img">
                <a href="{{url}}" class="goto"><img src="{{img}}" alt="无"/></a>
            </div>
            <div class="info">
                <p class="title"><a href="{{url}}" class="goto">{{title}}</a></p>
                <p class="abstract">{{abstract}}</p>
            </div>
        </li>
        {{/data}}
    </ul>
</div>