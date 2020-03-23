{% extends "layouts/super_admin.volt" %}

{% block content %}
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                新建分类
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="row">
                <form id="category-form" method="POST"  autocomplete="off">
                <div class="col-md-8" id="schema-div">
                <div id="alert-div"></div>
                    <div class="form-group">
                        <label>分类名称</label>
                        <input class="form-control" name="name" required />
                    </div>
                    <div class="form-group">
                        <label>分类标识</label>
                        <input class="form-control" name="identity" placeholder="IDENTITY">
                        <p class="help-block">全局唯一标识，可通过该标识获取分类信息。</p>
                    </div>

{{ __invoke__("Volt::partial", "partial/select_category", ["category": category]) }}

                    <div class="form-group">
                        <label>分类描述</label>
                        <textarea class="form-control" name="desc" rows="3"></textarea>
                    </div>
                    <div class="form-group" style="display: none;">
                        <label>分类状态</label><br />
                        <input class="form-control" name="status" value="1" />
                    </div>
                    
                    <div class="form-group" id="submit-button">
                        <button type="submit" class="btn btn-primary btn-lg">保存分类</button>
                    </div>
                
                </div>
            
                
                </form>
                </div>

            </div>
        </div>
    </div>
</div>
{% endblock %}