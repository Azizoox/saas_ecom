

<?php $__env->startSection('content'); ?>
<div class=" mt-16 min-h-screen bg-slate-50 px-4 py-16">
    <div class="mx-auto w-full max-w-xl">
        <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
            <div class="mb-6 flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-full bg-blue-100 text-blue-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-16 9h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900">Verifiez votre adresse email</h1>
            </div>

            <?php if(session('status')): ?>
                <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700" role="alert">
                    <?php echo e(session('status')); ?>

                </div>
            <?php endif; ?>

            <?php if(session('message')): ?>
                <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700" role="alert">
                    <?php echo e(session('message')); ?>

                </div>
            <?php endif; ?>

            <p class="mb-2 text-sm leading-6 text-slate-600">
                Un lien de verification a ete envoye a votre adresse email.
            </p>
            <p class="mb-7 text-sm leading-6 text-slate-600">
                Cliquez sur le lien recu pour activer votre compte, puis revenez vous connecter.
            </p>

            <form method="POST" action="<?php echo e(route('verification.send')); ?>" class="space-y-3">
                <?php echo csrf_field(); ?>
                <button type="submit" class="inline-flex w-full items-center justify-center rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Renvoyer l'email de verification
                </button>
                <a href="<?php echo e(route('login')); ?>" class="inline-flex w-full items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                    Retour a la connexion
                </a>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layouts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views/auth/verify-email.blade.php ENDPATH**/ ?>