
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            {% include "layouts/nav.volt" %}
			{% include "layouts/sidebar.volt" %}
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">{{title|default('')}}</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
				{% block content %}
                <h2>默认内容layouts/super_admin</h2>
				{% endblock %}
            </div>
            <!-- /.container-fluid -->
        </div>
        <div class="loading" id="loading-div" style="display:none">Loading&#8230;</div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

<!-- Modal -->
<div class="modal fade" id="view-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">表单预览</h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="submit" class="btn btn-primary" id="submit-result-form">数据预览</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->