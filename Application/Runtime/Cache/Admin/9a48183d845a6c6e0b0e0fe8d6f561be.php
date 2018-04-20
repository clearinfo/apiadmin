<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title><?php echo C('APP_NAME');?>管理后台</title>
    <link rel="stylesheet" href="/ApiAdmin/Public/layui/css/layui.css">
    <script type="text/javascript" src="/ApiAdmin/Public/layui/layui.js"></script>
    <script src="//cdn.bootcss.com/jquery/3.1.1/jquery.min.js"></script>
    
</head>
<body>
<div style="margin: 15px;">
    
    <script type="text/javascript" src="/ApiAdmin/Public/dataTable/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="/ApiAdmin/Public/css/dataTable.css">
    <fieldset class="layui-elem-field">
        <legend>秘钥管理 - 秘钥列表</legend>
        <div class="layui-field-box">
            <span class="layui-btn layui-btn-normal api-add"><i class="layui-icon">&#xe608;</i> 新增</span>
            <table class="layui-table" id="list-admin" lay-even>
                <thead>
                <tr>
                    <th>秘钥名称</th>
                    <th>AppId</th>
                    <th>AppSecret</th>
                    <th>秘钥状态</th>
                    <th>操作</th>
                </tr>
                </thead>
            </table>
        </div>
    </fieldset>

</div>

    <script>
        /**
         * 格式化时间戳
         * @param fmt
         * @returns {*}
         * @constructor
         */
        Date.prototype.Format = function (fmt) {
            var o = {
                "M+": this.getMonth() + 1, //月份
                "d+": this.getDate(), //日
                "h+": this.getHours(), //小时
                "m+": this.getMinutes(), //分
                "s+": this.getSeconds(), //秒
                "q+": Math.floor((this.getMonth() + 3) / 3), //季度
                "S": this.getMilliseconds() //毫秒
            };
            if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
            for (var k in o)
                if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
            return fmt;
        };

        layui.use(['layer', 'form'], function () {
            $('.api-add').on('click', function () {
                layer.open({
                    type: 2,
                    area: ['80%', '80%'],
                    maxmin: true,
                    content: '<?php echo U("add");?>'
                });
            });
            $(document).on('click', '.edit', function () {
                var ownObj = $(this);
                layer.open({
                    type: 2,
                    area: ['80%', '80%'],
                    maxmin: true,
                    content: ownObj.attr('data-url') + '&id=' + ownObj.attr('data-id')
                });
            });
            $(document).on('click', '.confirm', function () {
                var ownObj = $(this);
                layer.confirm(ownObj.attr('data-info'), {
                    btn: ['确定', '取消'] //按钮
                }, function () {
                    $.ajax({
                        type: "POST",
                        url: ownObj.attr('data-url'),
                        data: {id: ownObj.attr('data-id')},
                        success: function (msg) {
                            if (msg.code == 1) {
                                location.reload();
                            } else {
                                layer.msg(msg.msg, {
                                    icon: 5,
                                    shade: [0.6, '#393D49'],
                                    time: 1500
                                });
                            }
                        }
                    });
                });
            });

            var myFun = function (query) {
                query = query || '';
                return $('#list-admin').DataTable({
                    dom: 'rt<"bottom"ifpl><"clear">',
                    ordering: false,
                    autoWidth: false,
                    searching: false,
                    serverSide: true,
                    ajax: {
                        url: '<?php echo U("ajaxGetIndex");?>' + query,
                        type: 'POST',
                        dataSrc: function (json) {
                            if (json.code == 0) {
                                parent.layer.msg(json.msg, {
                                    icon: 5,
                                    shade: [0.6, '#393D49'],
                                    time: 1500
                                });
                            } else {
                                return json.data;
                            }
                        }
                    },
                    columnDefs: [
                        {
                            "targets": 3,
                            "render": function (data) {
                                if (data == 1) {
                                    return '启用';
                                } else {
                                    return '禁用';
                                }
                            }
                        },
                        {
                            "targets": 4,
                            "render": function (data, type, row) {
                                var returnStr = '';
                                if (row.status == 1) {
                                    returnStr += '<span class="layui-btn layui-btn-warm confirm" ' +
                                        'data-id="' + row.id + '" data-info="你确定禁用当前秘钥么？" data-url="<?php echo U('close');?>">禁用</span>';
                                } else {
                                    returnStr += '<span class="layui-btn confirm" ' +
                                        'data-id="' + row.id + '" data-info="你确定启用当前秘钥么？" data-url="<?php echo U('open');?>">启用</span>';
                                }
                                returnStr += '<span class="layui-btn edit layui-btn-normal" ' +
                                    'data-id="' + row.id + '" data-url="<?php echo U('edit');?>">编辑</span>';
                                returnStr += '<span class="layui-btn layui-btn-danger confirm" ' +
                                    'data-id="' + row.id + '" data-info="你确定删除当前商品么？" data-url="<?php echo U('del');?>">删除</span>';
                                return returnStr;
                            }
                        }
                    ],
                    iDisplayLength: 20,
                    aLengthMenu: [20, 30, 50],
                    columns: [
                        {"data": "name"},
                        {"data": "appId"},
                        {"data": "appSecret"},
                        {"data": "status"},
                        {"data": null}
                    ]
                });
            };
            var myTable = myFun();
            $('.sub').on("click", function () {
                myTable.destroy();
                myTable = myFun('&' + $('#form-admin-add').serialize());
            });
        });
    </script>

</body>
</html>