<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{csrf_token()}}">


    <title>laravel for blog</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">


    <!-- Custom styles for this template -->
    <link href="/css/blog.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/wangEditor.min.css">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>

    <![endif]-->
</head>

<body>

@include("layout.nav")
<div class="container">

    <div class="blog-header">
    </div>

    <div class="row">
        @yield("content")

        @include("layout.sidebar")
    </div><!-- /.row -->
</div><!-- /.container -->

@include("layout.footer")
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/wangEditor.min.js"></script>
<script src="/js/ylaravel.js"></script>
<script>
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(".like-button").click(function (event) {
            alert(1);
            var target = $(event.target);
            var current_like = target.attr('like-value');

            var user_id = target.attr('like-user');

            if (current_like == 1) {
                // 取消关注
                $.ajax({
                    url: '/user/' + user_id + '/unfan',
                    method: 'POST',
                    dataType: "json",
                    success: function (data) {
                        if (data.error != 0 ) {
                            alert(data.msg);
                            return;
                        }
                        target.attr("like-value", 0);
                        target.text("关注");
                    }
                })

            } else {
                // 关注
                $.ajax({
                    url: '/user/' + user_id + '/fan',
                    method: 'POST',
                    dataType: "json",
                    success: function (data) {
                        if (data.error != 0 ) {
                            alert(data.msg);
                            return;
                        }
                        target.attr("like-value", 1);
                        target.text("取消关注");
                    }
                })
            }
        });
    });
</script>

</body>
</html>
