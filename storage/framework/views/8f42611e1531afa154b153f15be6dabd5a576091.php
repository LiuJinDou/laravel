<?php echo $__env->make('admin/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<style>
    .privilege_setting_field .layui-field-box>div{
        vertical-align: top;
        display:inline-block;
        margin:-1px 0 0 -5px;
        padding:10px;
        width:218px;
        height:40px;
        line-height:23px;
        border: solid 1px #e6e6e6;
        background-color: #f9f9f9;
    }
    .privilege_setting_field .layui-field-box>div:hover{
        background-color: #FFFFCC;
    }

    .privilege_setting_field .group_operate_area{
        display:none;
    }

    .privilege_setting_field>fieldset:hover .group_operate_area{
        display:inline;
    }

    .privilege_setting_field .privilege_setting_item{
        position: relative;
    }

    .privilege_setting_field .privilege_setting_item .privilege_setting_opt_item{
        display:none;
        position: absolute;
        right:0px;
        top:-1px;
    }

    .privilege_setting_field .privilege_setting_item:hover .privilege_setting_opt_item{
        display:inline;
    }
    .layui-elem-field legend{height:30px;}
</style>
<form class="layui-form"> <!-- 提示：如果你不想用form，你可以换成div等任何一个普通元素 -->
<div lay-filter="privilege_setting_field" class="layui-form privilege_setting_field">
    <?php $__currentLoopData = $privilege; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <fieldset  class="layui-elem-field">
            <legend>
                <?php echo e($value['group_name']); ?> <input type="checkbox" lay-filter="all_select" title="全选">
            </legend>
            <div class="layui-field-box role_privilege_check_area">
                <?php $__currentLoopData = $value['list']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="layui-inline layui-text privilege_setting_item" data-value='11' lay-filter="single_select">
                        <p>
                            <?php if($item['is_allow']): ?>
                                <input type="checkbox" name="privileges[]" lay-filter="privilege_item" value="<?php echo e($item['id']); ?>" lay-skin="primary" checked>
                            <?php else: ?>
                                <input type="checkbox" name="privileges[]" lay-filter="privilege_item" value="<?php echo e($item['id']); ?>" lay-skin="primary">
                            <?php endif; ?>
                            <?php echo e($item['privilege_name']); ?></p>
                        <p><?php echo e($item['privilege_url']); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </fieldset>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="privilege">Submit</button>
                <button type="reset" class="layui-btn layui-btn-primary">Reset</button>
            </div>
        </div>
        <input type="hidden" name="role_id" value="">
        <input type="hidden" name="iframe" value="">
</div>
</form>
<script src="/js/admin/privilege/role_privilege.js"></script>