

<?php $__env->startSection('title', 'Login - ' . $shop->name); ?>

<?php $__env->startPush('styles'); ?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=DM+Serif+Display&display=swap" rel="stylesheet">
<style>
 
    body { font-family: 'DM Sans', sans-serif; }
    .brand-panel {
        background:var(--c-accent);
       
    }
    .circle-deco-1 {
        position: absolute; top: -80px; left: -80px;
        width: 260px; height: 260px; border-radius: 50%;
        border: 1px solid rgba(255,255,255,0.06);
    }
    .circle-deco-2 {
        position: absolute; bottom: -40px; right: -60px;
        width: 200px; height: 200px; border-radius: 50%;
        border: 1px solid rgba(255,255,255,0.05);
    }
    .input-field {
        width: 100%;
        padding: 10px 14px;
        font-size: 14px;
        font-family: 'DM Sans', sans-serif;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        background: #fafafa;
        color: #111;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
    }
    .input-field:focus {
        border-color:var('--c-accent-dk');
        background: #fff;
        box-shadow: 0 0 0 3px rgba(5,150,105,0.1);
    }
    .input-field.is-invalid { border-color: #ef4444; }
    .input-field.is-invalid:focus { box-shadow: 0 0 0 3px rgba(239,68,68,0.1); }
    .btn-submit {
        width: 100%; padding: 12px;
        background: var(--c-accent);
        color: white; font-weight: 600; font-size: 15px;
        border: none; border-radius: 10px; cursor: pointer;
        transition: background 0.2s, transform 0.1s;
        font-family: 'DM Sans', sans-serif;
        letter-spacing: 0.01em;
    }
    .btn-submit:hover { background: var(--c-accent-dk); }
    .btn-submit:active { transform: scale(0.98); }
    .btn-google {
        width: 100%; padding: 10px;
        background: #fff; color: #374151;
        font-size: 14px; font-weight: 500;
        border: 1px solid #e5e7eb; border-radius: 10px; cursor: pointer;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        font-family: 'DM Sans', sans-serif;
        transition: background 0.2s, border-color 0.2s;
    }
    .btn-google:hover { background: #f9fafb; border-color: #d1d5db; }
    .divider {
        display: flex; align-items: center; gap: 10px;
        margin: 16px 0;
    }
    .divider-line { flex: 1; height: 1px; background: #f3f4f6; }
    .divider-text { font-size: 12px; color: #9ca3af; }
    .password-wrapper { position: relative; }
    .pw-toggle {
        position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
        background: none; border: none; cursor: pointer;
        color: #9ca3af; font-size: 12px; font-family: 'DM Sans', sans-serif;
        padding: 2px 4px;
    }
    .pw-toggle:hover { color: var(--c-accent-dk); }
    .alert-error {
        background: #fef2f2; border: 1px solid #fecaca;
        border-radius: 10px; padding: 12px 14px;
        margin-bottom: 20px;
    }
    .create {
        color: var(--c-accent);
    }
  
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-10 px-4">
    <div class="w-full max-w-3xl rounded-2xl overflow-hidden shadow-xl flex" style="min-height: 520px;">

        
        <div class="flex-1 bg-white p-8 md:p-10 flex flex-col justify-center">

            
            <div class="flex items-center gap-2 mb-6 md:hidden">
                <div class="w-7 h-7 rounded-lg bg-emerald-700 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                    </svg>
                </div>
                <span class="font-semibold text-sm text-gray-800"><?php echo e($shop->name); ?></span>
            </div>

            <div class="mb-7">
                <h1 class="text-2xl font-semibold text-gray-900 mb-1">Welcome back</h1>
                <p class="text-sm text-gray-500">Sign in to your account to continue</p>
            </div>

            
            <?php if($errors->any()): ?>
            <div class="alert-error">
                <ul class="list-none space-y-0.5">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="text-sm text-red-600"><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <?php endif; ?>

        

            <form method="POST" action="<?php echo e(route('shop.login.store', ['subdomain' => $shop->subdomain])); ?>" novalidate>
                <?php echo csrf_field(); ?>

                
                <div class="mb-4">
                    <label for="email" class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1.5">Email address</label>
                    <input
                        id="email" name="email" type="email"
                        value="<?php echo e(old('email')); ?>"
                        placeholder="john@example.com"
                        required autocomplete="email" autofocus
                        class="input-field <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    >
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-xs text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div class="mb-4">
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Password</label>
                        <?php if(Route::has('shop.password.request')): ?>
                        <a href="<?php echo e(route('shop.password.request', ['subdomain' => $shop->subdomain])); ?>"
                           class="text-xs text-emerald-700 font-medium hover:underline">
                            Forgot password?
                        </a>
                        <?php endif; ?>
                    </div>
                    <div class="password-wrapper">
                        <input
                            id="password" name="password" type="password"
                            placeholder="Your password"
                            required autocomplete="current-password"
                            class="input-field <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        >
                        <button type="button" class="pw-toggle" onclick="togglePw('password', this)">show</button>
                    </div>
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-xs text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div class="flex items-center gap-2.5 mb-6">
                    <input type="checkbox" id="remember" name="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>

                        class="w-4 h-4 rounded border-gray-300 accent-emerald-700">
                    <label for="remember" class="text-sm text-gray-500">Remember me for 30 days</label>
                </div>

                <button type="submit" class="btn-submit">Sign in</button>

                <p class="mt-4 text-center text-sm text-gray-500">
                    Don't have an account?
                    <a href="<?php echo e(route('shop.register', ['subdomain' => $shop->subdomain])); ?>" class="create  font-medium hover:underline">Create one</a>
                </p>
            </form>
        </div>

        
        <div class="brand-panel relative hidden md:flex flex-col justify-between p-10 w-5/12 flex-shrink-0 overflow-hidden">
            <div class="circle-deco-1"></div>
            <div class="circle-deco-2"></div>

            
            <div class="relative z-10">
                <div class="inline-flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                    </div>
                    <span class="text-white font-semibold text-sm tracking-wide"><?php echo e($shop->name); ?></span>
                </div>
            </div>

            
            <div class="relative z-10 flex-1 flex flex-col justify-center py-8">
                

                <blockquote style="font-family:'DM Serif Display',serif;" class="text-white text-xl leading-snug mb-5">
                    "Best shopping experience I've had online."
                </blockquote>
                <p class="text-white/60 text-sm leading-relaxed mb-6">
                    Super fast delivery and the customer support is truly amazing. I'm a customer for life.
                </p>

          
            </div>

            
                   </div>

    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function togglePw(id, btn) {
    const input = document.getElementById(id);
    if (input.type === 'password') { input.type = 'text'; btn.textContent = 'hide'; }
    else { input.type = 'password'; btn.textContent = 'show'; }
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('shop.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views/shop/auth/login.blade.php ENDPATH**/ ?>