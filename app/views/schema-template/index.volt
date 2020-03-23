{% extends "layouts/super_front.volt" %}

{% block content %}
<style>
div > label {
    font-size: 13px;
}
span.help-block {
    font-size: 12px;
}
.draggable {
    font-size: 14px;
}
</style>
    <div class="blog-post" style="min-height: 505px;">
        <h2 class="blog-post-title">数据模板</h2>
        <p class="blog-post-meta">官方免费模板，倾情奉献。</p>
        
        <h6>
            <span class="badge badge-primary">免费</span>
            <span class="badge badge-primary">官方</span>
            <span class="badge badge-primary">感恩</span>
        </h6>
        <a class="btn btn-default btn-primary pull-right" id="check-detail">查看详情</a>
        <p class="clear">&nbsp;</p>
        {{ __invoke__("Volt::partial", "partial/data_form") }}

    </div>


{% endblock %}