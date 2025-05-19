<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'actions' => [],
    'details' => [],
    'title',
    'url',
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'actions' => [],
    'details' => [],
    'title',
    'url',
]); ?>
<?php foreach (array_filter(([
    'actions' => [],
    'details' => [],
    'title',
    'url',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<li
    <?php echo e($attributes->class(['fi-global-search-result scroll-mt-9 transition duration-75 focus-within:bg-gray-50 hover:bg-gray-50 dark:focus-within:bg-white/5 dark:hover:bg-white/5'])); ?>

>
    <a
        <?php echo e(\Filament\Support\generate_href_html($url)); ?>

        x-on:click="close()"
        class="<?php echo \Illuminate\Support\Arr::toCssClasses([
            'fi-global-search-result-link block outline-none',
            'pe-4 ps-4 pt-4' => $actions,
            'p-4' => ! $actions,
        ]); ?>"
    >
        <h4 class="text-sm font-medium text-gray-950 dark:text-white">
            <?php echo e($title); ?>

        </h4>

        <!--[if BLOCK]><![endif]--><?php if($details): ?>
            <dl class="mt-1">
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        <!--[if BLOCK]><![endif]--><?php if($isAssoc ??= \Illuminate\Support\Arr::isAssoc($details)): ?>
                            <dt class="inline font-medium"><?php echo e($label); ?>:</dt>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        <dd class="inline"><?php echo e($value); ?></dd>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </dl>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </a>

    <!--[if BLOCK]><![endif]--><?php if($actions): ?>
        <?php if (isset($component)) { $__componentOriginal06869628e057700d7c7d1210beefbe23 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal06869628e057700d7c7d1210beefbe23 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.global-search.actions','data' => ['actions' => $actions]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament-panels::global-search.actions'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($actions)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal06869628e057700d7c7d1210beefbe23)): ?>
<?php $attributes = $__attributesOriginal06869628e057700d7c7d1210beefbe23; ?>
<?php unset($__attributesOriginal06869628e057700d7c7d1210beefbe23); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal06869628e057700d7c7d1210beefbe23)): ?>
<?php $component = $__componentOriginal06869628e057700d7c7d1210beefbe23; ?>
<?php unset($__componentOriginal06869628e057700d7c7d1210beefbe23); ?>
<?php endif; ?>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</li>
<?php /**PATH C:\Project\brivent\vendor\filament\filament\src\/../resources/views/components/global-search/result.blade.php ENDPATH**/ ?>