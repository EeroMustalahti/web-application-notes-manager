

<?php $__env->startSection('content'); ?>
    <?php foreach($users as $user): ?>
        <div id="user<?php echo e($user->slug); ?>" class="panel panel-default">
            <div class="panel-heading clearfix">
                Notes of user <?php echo e($user->name); ?>

                <?php if(Auth::check()): ?>
                    <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('delete-users', $user->id)): ?>
                        <button class="btn btn-danger pull-right delete-user" value="<?php echo e($user->slug); ?>">Delete user</button>
                    <?php endif; ?>
                    <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('make-modes', $user->id)): ?>
                        <button id="mode<?php echo e($user->slug); ?>" class="btn btn-space btn-info pull-right make-mode" value="<?php echo e($user->slug); ?>"><?php echo e($user->roles()->find($modeRoleId) ? 'Remove moderator' : 'Make moderator'); ?></button>
                    <?php endif; ?>
                <?php endif; ?>
                <a class="btn btn-space btn-default pull-right" href="<?php echo e(url($user->slug . '/notes')); ?>">Check notes</a>
            </div>
            <div class="panel-body">
                <ul class="list-inline">
                    <?php foreach($user->notes as $note): ?>
                        <li class="list-group-item"><?php echo e($note->title); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php endforeach; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>