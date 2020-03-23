{% extends "layouts/super_front.volt" %}
{% block content %}
<style type="text/css" media="screen">
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
            <span class="badge badge-primary">Category: {{item['categoryId']}}</span>
            <span class="badge badge-primary">{{item['identity']}}</span>
            <span class="badge badge-primary">Template: {{item['schemaTemplateId']}}</span>            

        </h6>
        <blockquote>
              <p>{{item["desc"]}}</p>
        </blockquote>
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