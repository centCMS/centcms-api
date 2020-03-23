{% extends "layouts/super_admin.volt" %}

{% block content %}
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                新建模板
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="row">
                <form id="schema-form" method="POST"  autocomplete="off">
                <div class="col-md-8" id="schema-div">
                <div id="alert-div"></div>
                    <div class="form-group">
                        <label>模板名称</label>
                        <input class="form-control" name="name" required />
                    </div>
                    <div class="form-group">
                        <label>模板标识</label>
                        <input class="form-control" name="identity" placeholder="IDENTITY">
                        <p class="help-block">全局唯一标识，可能过该标识获取模板详情。</p>
                    </div>
                    <div class="form-group">
                        <label>模板描述</label>
                        <textarea class="form-control" name="desc" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label>模板状态</label><br />
                        <div class="radio-inline">
                            <label class="radio">
                                <input type="radio" name="status" id="optionsRadiosInline1" value="option1" checked>草稿
                            </label>
                        </div>
                        <div class="radio-inline">
                            <label class="radio">
                                <input type="radio" name="status" id="optionsRadiosInline2" value="option2">发布
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>模板内容</label>
                    </div>
                
                </div>
                <div class="col-md-4" id="submit-div">
                    <div class="form-group" id="submit-button">
                        <button type="submit" class="btn btn-primary btn-lg">保存模板</button>
                    </div>
                </div>
                </form>
                </div>

	            <div class="row">
		            <div class="col-md-5">
		                <form id="form" class="form-vertical" method="POST"></form>
	                </div>
		            <div class="col-md-7">
		                <h2>表单预览</h2>
		                <div id="result" class="well">(please wait)</div>
		            </div>
	            </div>
            </div>
        </div>
    </div>
</div>
{% endblock %}