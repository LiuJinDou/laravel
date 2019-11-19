<?php echo $__env->make('admin/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="x-body layui-anim layui-anim-up">
    <blockquote class="layui-elem-quote">欢迎管理员：
        <span class="a-user"><?php echo e(auth('admin')->user()->name); ?></span>！ <span id="nowtime"></span></blockquote>
    <fieldset class="layui-elem-field">
        <legend>数据统计</legend>
        <div class="layui-field-box">
            <div class="layui-col-md12">
                <div class="layui-card">
                    <div class="layui-card-body">
                        <div class="layui-carousel x-admin-carousel x-admin-backlog" lay-anim="" lay-indicator="inside" lay-arrow="none">
                            <div carousel-item="">
                                <ul class="layui-row layui-col-space10 layui-this"></ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    <fieldset class="layui-elem-field">
        <legend>系统通知</legend>
        <div class="layui-field-box">
            <table class="layui-table" lay-skin="line">
                <tbody>
                <tr>
                    <td >
                        <a class="x-a" href="/" target="_blank">新版Shadow 1.0上线了</a>
                    </td>
                </tr>
                <tr>
                    <td >
                        <a class="x-a" href="/" target="_blank">交流qq:(1000100010)</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </fieldset>
    <fieldset class="layui-elem-field">
        <legend>系统信息</legend>
        <div class="layui-field-box">
            <table class="layui-table">
                <tbody>
                <tr>
                    <th>项目版本</th>
                    <td>1.0.0</td></tr>
                <tr>
                    <th>服务器地址</th>
                    <td><?php echo e($_SERVER['SERVER_NAME']); ?></td></tr>
                <tr>
                    <th>操作系统</th>
                    <td><?php echo e(php_uname()); ?></td></tr>
                <tr>
                    <th>运行环境</th>
                    <td><?php echo e(php_sapi_name()); ?></td></tr>
                <tr>
                    <th>PHP版本</th>
                    <td><?php echo e(PHP_VERSION); ?></td></tr>
                <tr>
                    <th>PHP运行方式</th>
                    <td><?php echo e(php_sapi_name()); ?></td></tr>
                <tr>
                    <th>MYSQL版本</th>
                    <td><?php echo e($_SERVER['MYSQL_VERSION']); ?></td></tr>
                <tr>
                    <th>Laravel</th>
                    <td><?php echo e($_SERVER['LARAVEL_VERSION']); ?></td></tr>
                <tr>
                    <th>上传附件限制</th>
                    <td>2M</td></tr>
                <tr>
                    <th>执行时间限制</th>
                    <td>30s</td></tr>
                <tr>
                    <th>剩余空间</th>
                    <td>86015.2M</td></tr>
                </tbody>
            </table>
        </div>
    </fieldset>
    <fieldset class="layui-elem-field">
        <legend>开发团队</legend>
        <div class="layui-field-box">
            <table class="layui-table">
                <tbody>
                <tr>
                    <th>版权所有</th>
                    <td>shadow(ljd)
                        <a href="http://www.mengshadow.top" class='x-a' target="_blank">访问博客</a></td>
                </tr>
                <tr>
                    <th>开发者</th>
                    <td>Shadow(11975876584@qq.com)</td></tr>
                </tbody>
            </table>
        </div>
    </fieldset>
    <blockquote class="layui-elem-quote layui-quote-nm">感谢Laravel,layui,百度Echarts,jquery等技术支持。</blockquote>
</div>
<script src="/js/admin/desktop.js"></script>