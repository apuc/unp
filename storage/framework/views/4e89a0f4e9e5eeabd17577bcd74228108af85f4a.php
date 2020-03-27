<?php $__env->startSection('content'); ?>
    <div class="card-wrap">
        <h2 class="title">Вопрос</h2>
        <form>
            <div class="row">
                <div class="col-12 col-md-4 form-group">
                    <label for="ask-name">Имя <span class="red">*</span></label>
                    <input type="text" class="form-control" id="ask-name">
                </div>
                <div class="col-12 col-md-4 form-group">
                    <label for="ask-email">E-mail <span class="red">*</span></label>
                    <input type="email" class="form-control" id="ask-email">
                </div>
                <div class="col-12 col-md-4 form-group">
                    <label for="ask-name">Тема обращения <span class="red">*</span></label>
                    <select class="form-control" id="ask-name">
                        <option selected="selected" value="">-- Выберите тему</option>
                        <option value="">Прогнозы</option>
                        <option value="">Общие вопросы</option>
                        <option value="">Сотрудничество</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-12 form-group">
                    <label for="ask-text">Комментарий <span class="red">*</span></label>
                    <textarea class="form-control" rows="7" id="ask-text"></textarea>
                </div>
            </div>
            <div class="row justify-content-between">
                <div class="col-12 col-lg-6 form-group">
                    <div class="policy-box custom-control custom-checkbox">
                        <input class="custom-control-input policy-check" id="policy" type="checkbox">
                        <label class="custom-control-label" for="policy">Даю согласие на обработку<br>моих
                            <a href="legal-document.php">персональных данных</a></label>
                        <div class="invalid-feedback policy-error">Вы не дали согласие на обработку персональных
                            данных
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6 form-group">
                </div>
            </div>

            <div class="btn-account-row">
                <a href="#" class="btn btn-primary pl-4 pr-4">Отправить</a>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('top'); ?>
    <?php if(filled($document = Text::get($sitesection, 'top'))): ?>
        <section class="text-top">
            <?php echo $document->content; ?>

        </section>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
    <?php echo $__env->make('partial.site.sidebar.info', [
        'current' => 'site.help.ask'
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('bottom'); ?>
    <?php if(filled($document = Text::get($sitesection, 'bottom'))): ?>
        <section class="text-bottom">
            <?php echo $document->content; ?>

        </section>
    <?php endif; ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.site.grid.double', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/site/help/ask.blade.php ENDPATH**/ ?>