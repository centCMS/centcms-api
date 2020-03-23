{% extends "layouts/super_front.volt" %}

{% block content %}
<style type="text/css" media="screen">

div > label {
    font-size: 13px;
}
span.help-block {
    font-size: 12px;
}
.draggable {
    font-size: 14px;
}
#editor { 
    position: relative;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    min-height: 300px;
}
</style>
    <div class="blog-post" style="min-height: 505px;">
        <h2 class="blog-post-title">{{item["name"]}}</h2>
        <p class="blog-post-meta">{{item["ctime"]}} <a href="#">作者: id({{item["createUserId"]}})</a></p>
        <h6>
            <span class="badge badge-primary">{{item['identity']}}</span>

        </h6>
        <blockquote>
              <p>{{item["desc"]}}</p>
        </blockquote>
        
        {{ __invoke__("Volt::partial", "partial/data_form") }}
        
        <h3>Schema JSON</h3>
        <div style="form-group">
            <pre id="editor"></pre>
        </div>
    </div>

    <nav>
        <ul class="pager">
            <li><a href="#">Previous</a></li>
            <li><a href="#">Next</a></li>
        </ul>
    </nav>

 
{% endblock %}