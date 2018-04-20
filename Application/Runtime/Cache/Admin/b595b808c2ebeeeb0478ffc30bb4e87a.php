<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title><?php echo C('APP_NAME');?>管理后台</title>
    <script src="//cdn.bootcss.com/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="/ApiAdmin/Public/layui/css/layui.css">
    <style>
        .layui-nav-child .layui-nav-item{
            padding-left: 15px;
        }
    </style>
</head>

<body>
<!-- 布局容器 -->
<div class="layui-layout layui-layout-admin">
    <!-- 头部 -->
    <div class="layui-header">
        <div class="layui-main">
            <!-- logo -->
            <a href="/" style="color: #c2c2c2; font-size: 18px; line-height: 60px;"><?php echo C('APP_NAME');?>管理后台</a>
            <!-- 水平导航 -->
            <ul class="layui-nav" style="position: absolute; top: 0; right: 0; background: none;">
                <li class="layui-nav-item">
                    <a href="javascript:;">
                        进入前台
                    </a>
                </li>
                <li class="layui-nav-item">
                    <a href="javascript:;">
                        管理员
                    </a>
                    <dl class="layui-nav-child">
                        <dd class="api-add">
                            <a href="javascript:;">
                                个人信息
                            </a>
                        </dd>
                        <dd>
                            <a href="<?php echo U('Login/logOut');?>">
                                退出登录
                            </a>
                        </dd>
                    </dl>
                </li>
            </ul>
        </div>
    </div>

    <!-- 侧边栏 -->
    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <ul class="layui-nav layui-nav-tree" lay-filter="left-nav" style="border-radius: 0;">
            </ul>
        </div>
    </div>

    <!-- 主体 -->
    <div class="layui-body">
        <!-- 顶部切换卡 -->
        <div class="layui-tab layui-tab-brief" lay-filter="top-tab" lay-allowClose="true" style="margin: 0;">
            <ul class="layui-tab-title"></ul>
            <div class="layui-tab-content"></div>
        </div>
    </div>

    <!-- 底部 -->
    <div class="layui-footer" style="text-align: center; line-height: 44px;">
        <strong>Copyright &copy; 2014-<?php echo date('Y');?> <a href=""><?php echo C('COMPANY_NAME');?></a>.</strong> All rights reserved.
    </div>
</div>

<script type="text/javascript" src="/ApiAdmin/Public/layui/layui.js"></script>
<script type="text/javascript">
    layui.config({
        base: '/ApiAdmin/Public/js/'
    });

    layui.use(['cms'], function() {
        var cms = layui.cms('left-nav', 'top-tab');
        cms.addNav(JSON.parse('<?php echo json_encode($list);?>'), 0, 'id', 'fid', 'name', 'url');
        cms.bind(60 + 41 + 20 + 44); //头部高度 + 顶部切换卡标题高度 + 顶部切换卡内容padding + 底部高度
        cms.clickLI(0);
    });

    layui.use(['layer'], function() {
        $('.api-add').on('click', function () {
            layer.open({
                type: 2,
                area: ['80%', '80%'],
                maxmin: true,
                content: '<?php echo U("Login/changeUser");?>'
            });
        });
        var updateTime = '<?php echo ($userInfo["updateTime"]); ?>';
        if( updateTime == 0 ){
            layer.open({
                title: '初次登陆请重置密码！',
                type: 2,
                area: ['80%', '80%'],
                maxmin: true,
                closeBtn:0,
                content: '<?php echo U("Login/changeUser");?>'
            });
        }else{
            var nickname = '<?php echo ($userInfo["nickname"]); ?>';
            if( !nickname ){
                layer.open({
                    title: '初次登陆请补充真实姓名！',
                    type: 2,
                    area: ['80%', '80%'],
                    maxmin: true,
                    closeBtn:0,
                    content: '<?php echo U("Login/changeUser");?>'
                });
            }
        }
    });
</script>
</body>
</html>