{% extends "layouts/super_front.volt" %}
{% block content %}
<style>
tr > th {font-size: 13px;}
tr > td {font-size: 13px;}
</style>
    <div class="blog-post" style="min-height: 505px;">
        <h2 class="blog-post-title">数据列表</h2>
        <p class="blog-post-meta">###</p>
        <table width="100%" class="table table-striped table-bordered table-hover" id="item-table">
            <thead>
                <tr>
                    <th>序号</th>
                    <th>唯一标识</th>
                    <th>名称</th>
                    <th>状态</th>
                    <th width="20%">描述</th>
                    <th>创建时间</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>序号</th>
                    <th>唯一标识</th>
                    <th>名称</th>
                    <th>状态</th>
                    <th width="20%">描述</th>
                    <th>创建时间</th>
                </tr>
            </tfoot>
        </table>
    </div>
 
{% endblock %}
