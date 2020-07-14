<?php echo $__env->make('admin/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <h3><?php echo e($key+1); ?>、（<?php echo e($item['table_name']); ?>）<?php echo e($item['table_comment']); ?></h3>
    <hr class="layui-bg-red">
    <table class="layui-table">
        <colgroup>
            <col width="150">
            <col width="200">
            <col>
        </colgroup>
        <thead>
        <tr>
            <th>字段名</th>
            <th>数据类型</th>
            <th>默认值</th>
            <th>可空</th>
            <th>自动递增</th>
            <th>备注</th>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $item['tables']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($value['COLUMN_NAME']); ?></td>
                <td><?php echo e($value['COLUMN_TYPE']); ?></td>
                <td><?php echo e($value['COLUMN_DEFAULT']); ?></td>
                <td><?php echo e($value['IS_NULLABLE']); ?></td>
                <?php if($value['EXTRA']=='auto_increment'): ?>
                    <td>是</td>
                <?php else: ?>
                    <td></td>
                <?php endif; ?>
                <td><?php echo e($value['COLUMN_COMMENT']); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>