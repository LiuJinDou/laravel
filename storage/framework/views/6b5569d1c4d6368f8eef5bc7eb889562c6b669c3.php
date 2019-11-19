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
<!--<legend>批量操作</legend>-->
<div class="layui-btn-group">
    <button class="layui-btn edit_group" _token="<?php echo e(csrf_token()); ?>">新建权限分组</button>
</div>

<hr class="layui-bg-green">
<div lay-filter="privilege_setting_field" class="layui-form privilege_setting_field">
    <?php $__currentLoopData = $privilege; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <fieldset  class="layui-elem-field">
            <legend>
                <span><?php echo e($value['group_name']); ?></span>
                <div class="layui-btn-group group_operate_area">
                    <button class="layui-btn layui-btn-primary layui-btn-sm edit_group" data-value="<?php echo e($value['group_name']); ?>" data-id="<?php echo e($value['id']); ?>" >
                        &nbsp;<i class="layui-icon">&#xe642;</i>
                    </button>
                    <button class="layui-btn layui-btn-primary layui-btn-sm del_group"  data-id="<?php echo e($value['id']); ?>" >
                        &nbsp;<i class="layui-icon">&#xe640;</i>
                    </button>
                    <button class="layui-btn layui-btn-primary layui-btn-sm privilege_setting_item_edit " data-group-id="<?php echo e($value['id']); ?>" data-id="0">
                        &nbsp;<i class="layui-icon">&#xe654;</i>
                    </button>
                </div>
            </legend>
            <div class="layui-field-box">
                <?php $__currentLoopData = $value['list']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="layui-inline layui-text privilege_setting_item" data-value='11'>
                    <p><?php echo e($item['privilege_name']); ?></p>
                    <p><?php echo e($item['privilege_url']); ?></p>
                    <div class="privilege_setting_opt_item layui-btn-group">
                        <button class="layui-btn layui-btn-primary layui-btn-xs privilege_setting_item_edit" data-group-id="<?php echo e($value['id']); ?>" data-value="<?php echo e($item['privilege_name']); ?>" data-id="<?php echo e($item['id']); ?>" data-url="<?php echo e($item['privilege_url']); ?>" data-type="<?php echo e($item['type']); ?>">
                            &nbsp;<i class="layui-icon">&#xe642;</i>
                        </button>
                        <button class="layui-btn layui-btn-primary layui-btn-xs privilege_setting_item_del" data-id="<?php echo e($item['id']); ?>" data-value="">
                            &nbsp;<i class="layui-icon">&#xe640;</i>
                        </button>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </fieldset>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<script src="/js/admin/privilege/privilege.js"></script>