{% extends "layouts/super_error.volt" %}

{% block content %}
      <h1 class="mt-4 mb-3">403
        <small>Forbindden</small>
      </h1>
      <div class="jumbotron">
        <h1 class="display-1 text-center">403</h1>
        <p class="text-center">
			      您没有权限访问页面 "{{forbiddenUrl}}" 。<br /><br />
			      <a class="btn btn-primary btn-lg" href="{{url('/')}}">返回首页</a>
        </p>  
      </div>
{% endblock %}
