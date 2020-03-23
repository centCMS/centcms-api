{% extends "layouts/super_admin.volt" %}
{% block content %}
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                新增数据
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-5" id="item-div">
                        <form id="item-form" method="POST" autocomplete="off">
                        <div id="alert-div"></div>
                        <div class="form-group required">
                            <label class="control-label">数据名称</label>
                            <input class="form-control" name="name" required  />
                        </div>
                        <div class="form-group required">
                            <label class="control-label">数据标识</label>
                            <input class="form-control" name="identity" placeholder="IDENTITY" required />
                            <p class="help-block">全局唯一标识，可能过该标识获取数据详情。</p>
                        </div>
                        <div class="form-group">
                            <label class="control-label">数据描述</label>
                            <textarea class="form-control" name="desc" rows="3"></textarea>
                        </div>

 {{ __invoke__("Volt::partial", "partial/select_category", ["category": category]) }}
                        
                        <div class="form-group required">
                            <label class="control-label">数据状态</label><br />
                            <div class="radio-inline">
                                <label class="radio">
                                    <input type="radio" name="status" id="item-status-0" value="0" checked>草稿
                                </label>
                            </div>
                            <div class="radio-inline">
                                <label class="radio">
                                    <input type="radio" name="status" id="item-status-1" value="1">发布
                                </label>
                            </div>
                        </div>
                                        
                        <div class="form-group" id="submit-button">
                            <button type="submit" class="btn btn-primary btn-lg">保存数据</button>
                        </div>
                    
                        </form>
                    </div>

                    <div class="col-md-7">
                        <div class="form-group">
                            <label>数据内容</label>
                        </div>

                        {{ __invoke__("Volt::partial", "partial/data_form") }}

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{% endblock %}