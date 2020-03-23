{% extends "layouts/super_admin.volt" %}

{% block content %}
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                {% include "partial/breadcrumb_category" with ["parents": parents] %}
                <div style="position: absolute; right: 30px; top: 4px">
                    <a class="btn btn-primary" href="{{url('/item/create')}}?categoryId={{categoryId}}">新增数据</a>
                </div>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
            <div class="row">
    <div class="col-md-6">
    {% set redirectTo = url('/item/list') %}
    {{ __invoke__("Volt::partial", "partial/select_category", ["category": category, "redirectTo" : redirectTo], "select_category.js") }}
    </div>
</div>

                <table width="100%" class="table table-striped table-bordered table-hover" id="item-table">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>唯一标识</th>
                            <th>名称</th>
                            <th>状态</th>
                            <th width="20%">描述</th>
                            <th>创建时间</th>
                            <th>操作</th>
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
                            <th>操作</th>
                        </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    </div>
</div>
{% endblock %}