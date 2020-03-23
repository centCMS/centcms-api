<div class="form-group">
    <label class="control-label">分类</label>
    <div class="row">
        <div class="col-md-8">
            <div id="category-selecter"></div>
        </div>
{% if redirectTo is not defined %}
        <div class="col-md-2">
            <a href="javascript:" class="btn btn-default" id="reset-cascader">重置</a>
        </div>
{% endif %}
    </div>
</div>
<div class="form-group" style="display:none;">
    <label>分类值</label>
    <textarea class="form-control" name="category-value" id="category-value">
    </textarea>
</div>