<!DOCTYPE html>
<html lang="zh_CN">
    <head>
        <meta name="csrf-token" content="{{ security.getTokenKey() }},{{ security.getToken() }}" />
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <script type="text/javascript">
            var jsVars = <?=json_encode($jsVars, JSON_NUMERIC_CHECK|JSON_HEX_TAG)?>;
            for (var key in jsVars) {
                window[key] = jsVars[key];
            }
        </script>
{% include "layouts/head.volt" %}
    
    </head>
	<body>
{{ content() }}
    <footer>
        <div class="text-center" style="margin: 20px 0">
            Copyright &copy; 2020 <a href="https://bullsoft.org" target="_blank">BullSoft.Org</a>.
            <br />
            We built with: <a href="http://phalconplus.bullsoft.org" target="_blank">Phalcon+ {{phpversion("phalconplus")}}</a> , 
            <a href="https://phalcon.io" target="_blank">Phalcon {{phpversion("phalcon")}}</a> and 
            <a href="https://getbootstrap.com/docs/3.3/" target="_blank">Bootstrap 3.3.7</a>.
        </div>
    </footer>
	{% include "layouts/foot.volt" %}

{% if partialJs is defined %}
{% for readyjs in partialJs %}
{% if strpos(readyjs, "/") === 0 %}
    <script src="{{ static_url(readyjs) }}" type="text/javascript" charset="utf-8"></script>
{% else %}
    <script src="{{ static_url('/yourjs/partial/') }}{{readyjs}}" type="text/javascript" charset="utf-8"></script>
{% endif %}
{% endfor %}
{% endif %}

{{ __invoke__("Volt::yourJs", controller, action) }}

	</body>
</html>
