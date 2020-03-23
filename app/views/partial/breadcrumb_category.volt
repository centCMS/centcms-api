<ul class="breadcrumb" style="margin:0; padding: 0">
类目 >>  
{% for item in parents %}
    <li><a href="{{url('/item/list/')}}{{item['id']}}">{{item['name']}}</a></li>
{% endfor %}
    <li>{{category['name']}}</li>
</ul>