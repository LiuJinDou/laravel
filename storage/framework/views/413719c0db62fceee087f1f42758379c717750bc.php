<?php echo $__env->make('admin/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <div class="demoTable layui-form">
        Category：
            <div class="layui-input-inline">
                <select id="category_id" lay-filter="category" lay-verify="required" lay-search="">
                </select>
            </div>
        Month：
        <div class="layui-input-inline">
            <input type="text" class="layui-input" id="month" name="month" placeholder="Please select Month">
        </div>
        Year：
        <div class="layui-input-inline">
            <input type="text" class="layui-input" id="year" name="year" placeholder="Please select Year">
        </div>
        <button class="layui-btn layui-btn-warm" data-type="reload">Serach</button>
        <button class="layui-btn add_consume" data-type="add_consume">addConsume</button>
        <button class="layui-btn batch_add_consume" data-type="batch_add_consume">batchAdd</button>
    </div>

<table class="layui-hide" id="test" lay-filter="test"></table>

<script type="text/html" id="toolbarDemo">
    <div class="layui-btn-container">
        <button class="layui-btn layui-btn-sm" lay-event="getCheckData">获取选中行数据</button>
        <button class="layui-btn layui-btn-sm" lay-event="getCheckLength">获取选中数目</button>
        <button class="layui-btn layui-btn-sm" lay-event="isAll">验证是否全选</button>
    </div>
</script>

<script src="/js/admin/consume/consume.js"></script>