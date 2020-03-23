{% extends "layouts/super_error.volt" %}

{% block content %}
      <h1 class="mt-4 mb-3">404
        <small>Page Not Found</small>
      </h1>
      <div class="jumbotron">
        <h1 class="display-1 text-center">404</h1>
        <p class="text-center">
			      您所访问的页面 "{{notFoundUrl}}" 不存在。<br /><br />
			      <a class="btn btn-primary btn-lg" href="{{url('/')}}">返回首页</a>
        </p>  
      </div>
{% endblock %}
