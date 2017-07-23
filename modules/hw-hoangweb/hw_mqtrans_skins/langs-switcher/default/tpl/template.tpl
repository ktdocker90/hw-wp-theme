<ul id="{{wrapper.id}}" class="{{wrapper.class}}">
{% for key,value in active_langs %}
    <li class="{{value.class}}">
        <a href="{{value.url}}" class="{{value.anchor_class}}" title="{{value.title}}"><span>{{text}}</span></a>
    </li>
{% endfor %}
</ul>