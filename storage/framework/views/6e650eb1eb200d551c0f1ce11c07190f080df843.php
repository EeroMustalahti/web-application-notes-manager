

<?php $__env->startSection('content'); ?>
    <?php if(Auth::check() && (Auth::user() == $user || isset($editNote))): ?>
        <div class="panel panel-default">
            <form action="<?php if(isset($editNote)): ?> <?php echo e(url($editNote->id . '/edit')); ?> <?php else: ?> <?php echo e(url($user->slug . '/notes')); ?> <?php endif; ?>" method="post">
                <?php echo e(csrf_field()); ?>

                <div class="panel-heading">
                    <?php if(isset($editNote)): ?>
                        Edit note <?php echo e($editNote->title); ?>:
                    <?php else: ?>
                        Write new note:
                    <?php endif; ?>
                </div>
                <div class="panel-body">
                    <div class="form-group <?php echo e($errors->has('title') ? 'has-error' : ''); ?>">
                        <label class="control-label" for="title">Title:</label>
                        <input class="form-control" type="text" name="title" id="title"value="<?php if(isset($editNote) && !($errors->has('title') || $errors->has('body'))): ?><?php echo e($editNote->title); ?><?php else: ?><?php echo e(old('title')); ?><?php endif; ?>">
                        <?php echo $errors->first('title', '<p class="help-block">:message</p>'); ?>

                    </div>
                    <div class="form-group <?php echo e($errors->has('body') ? 'has-error' : ''); ?>">
                        <label class="control-label" for="body">Content:</label>
                        <textarea class="form-control" name="body" id="body"><?php if(isset($editNote) && !($errors->has('title') || $errors->has('body'))): ?><?php echo e($editNote->body); ?><?php else: ?><?php echo e(old('body')); ?><?php endif; ?></textarea>
                        <?php echo $errors->first('body', '<p class="help-block">:message</p>'); ?>

                    </div>
                    <button type="submit" class="btn btn-primary"><?php if(isset($editNote)): ?> Edit note <?php else: ?> Add note <?php endif; ?></button>
                </div>
            </form>
        </div>
    <?php endif; ?>

    <?php foreach($user->notes as $note): ?>
        <div id="note<?php echo e($note->id); ?>" class="panel panel-default">
        <div class="panel-heading clearfix">
            <?php echo e($note->title); ?>

            <?php if(Auth::check()): ?>
                <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('delete-notes', $note->id)): ?>
                    <button class="btn btn-danger pull-right delete-note" value="<?php echo e($note->id); ?>">Delete note</button>
                <?php endif; ?>
                <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('edit-notes', $note->id)): ?>
                    <a class="btn btn-space btn-info pull-right" href="<?php echo e(url($note->id . '/edit')); ?>">Edit note</a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
            <div class="panel-body">
                <?php echo $note->body; ?>

            </div>
        </div>
    <?php endforeach; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>