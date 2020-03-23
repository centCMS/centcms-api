{% extends "layouts/super_front.volt" %}
{% block content %}
<header class="business-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="tagline"></h1>
            </div>
        </div>
    </div>
</header>

<p>&nbsp;</p>

<h2>我们做什么</h2>

<hr />

<p>
    这么大的事情一句两句话咋说得清楚。。。
    布尔软件不忘初心，致力于成为您身边的软件专家。
</p>
<p>
    <a class="btn btn-default btn-lg" href="mailto:support@bullsoft.org">联系我们 &raquo;</a>
</p>

<div class="row">
    <div class="col-sm-4 col-sm-offset-4">
        <img class="" src="{{static_url('/images/bullsoft_qrcode.jpeg')}}" alt="" width="300px">
    </div>
</div>
{% endblock %}