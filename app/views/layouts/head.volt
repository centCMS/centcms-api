	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="CentCMS, Config, Controllr, Content, CMS, Data Deliver, Schema Free" />
    <meta name="author" content="BullSoft, OpenOrg in China" />

    <title>CentCMS:{{title|default('')}}</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ static_url('/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="{{ static_url('/vendor/metisMenu/metisMenu.min.css') }}" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="{{ static_url('/vendor/datatables-plugins/dataTables.bootstrap.css') }}" rel="stylesheet">
    <!-- DataTables Responsive CSS -->
    <link href="{{ static_url('/vendor/datatables-responsive/dataTables.responsive.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ static_url('/dist/css/sb-admin-2.css') }}" rel="stylesheet">
    <link href="{{ static_url('/dist/css/common.css') }}" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="{{ static_url('/vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ static_url('/jsonform-2.1.6/deps/opt/bootstrap-wysihtml5.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ static_url('/jsonform-2.1.6/deps/opt/spectrum.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ static_url('/vendor/bootstrap-cascader/css/bootstrap-cascader.min.css') }}" rel="stylesheet" type="text/css">

    {{ __invoke__("Volt::yourCss", controller, action) }}