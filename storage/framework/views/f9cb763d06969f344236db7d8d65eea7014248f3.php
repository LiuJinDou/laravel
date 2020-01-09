<?php echo $__env->make('admin/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="demoTable layui-form">
    Month：
    <div class="layui-input-inline">
        <input type="text" class="layui-input" id="month" name="month" placeholder="Please select month">
    </div>
    date：
    <div class="layui-input-inline">
        <input type="text" class="layui-input" id="date" name="date" placeholder="Please select date">
    </div>
    Name：<div class="layui-inline">
        <input class="layui-input" name="name" id="name" autocomplete="off" placeholder="Please input name">
    </div>
    <button class="layui-btn layui-btn-warm" data-type="reload">Search</button>
    <button class="layui-btn add_detail" data-type="add_detail">addDetail</button>
    <button class="layui-btn export_detail" data-type="export_detail">exportDetail</button>
</div>
<table class="layui-hide" id="detail_list" lay-filter="detail_list"></table>

<script type="text/html" id="toolbarDemo">
    <div class="layui-btn-container">
        <button class="layui-btn layui-btn-sm" lay-event="getCheckData">获取选中行数据</button>
        <button class="layui-btn layui-btn-sm" lay-event="getCheckLength">获取选中数目</button>
        <button class="layui-btn layui-btn-sm" lay-event="isAll">验证是否全选</button>
    </div>
</script>

<script src="/js/admin/consume/detail.js"></script>