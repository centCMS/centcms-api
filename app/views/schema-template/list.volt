{% extends "layouts/super_admin.volt" %}
{% block content %}
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                &nbsp;
                <div style="position: absolute; right: 30px; top: 4px">
                    <a class="btn btn-primary" href="{{url('/schema-template/create')}}">新增模板</a>
                </div>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">

                <table width="100%" class="table table-striped table-bordered table-hover" id="schema-template-table">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>唯一标识</th>
                            <th>名称</th>
                            <th>状态</th>
                            <th>描述</th>
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
                            <th>描述</th>
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