{% extends "layouts/super_admin.volt" %}
{% block content %}
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                {% include "partial/breadcrumb_category" with ["parents": parents] %}
                <div style="position: absolute; right: 30px; top: 4px">
                    <a class="btn btn-primary" {% if category['pid'] == 0%} disabled onclick="javascript:return false;"{% endif %}href="{{url('/category/list/')}}{{category['pid']}}">返回上级</a>
                    <a class="btn btn-primary" href="{{url('/category/create')}}/{{categoryId}}">新增分类</a>
                </div>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">

                <table width="100%" class="table table-striped table-bordered table-hover" id="category-table">
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

<!-- Modal -->
<div class="modal fade" id="view-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">详情预览</h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
{% endblock %}