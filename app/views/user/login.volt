{% extends "layouts/super_front.volt" %}

{% block content %}
        <div class="blog-post" style="">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">请登录</h3>
                    </div>
                    <div class="panel-body">
                       	<div class="text-center"><i class="fa fa-user fa-5x"></i>
						<p style="margin: 60px 0;"></p>
                        <!-- Change this to a button or input when using this as a form -->
                        <a href="{{ oAuthUrl | default('#') }}" class="btn btn-lg btn-primary btn-block">使用轻云登录</a>
					</div>
                            
                    </div>
                </div>
            </div>
        </div>
{% endblock %}