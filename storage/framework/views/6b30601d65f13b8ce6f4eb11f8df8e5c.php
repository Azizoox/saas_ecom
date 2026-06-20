<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmez votre email</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>

        /* ── Reset ── */
        * { margin: 0; padding: 0; box-sizing: border-box; }

        /* ── Page ── */
        body {
            font-family: 'Inter', Arial, sans-serif;
            background: #f0f5ff;
            color: #1e293b;
            padding: 40px 16px;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        /* ── Wrapper ── */
        .wrapper {
            max-width: 560px;
            margin: 0 auto;
        }

        /* ── Brand ── */
        .brand {
            text-align: center;
            margin-bottom: 24px;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #2563eb;
        }

        /* ── Card ── */
        .card {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid #dbeafe;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(37, 99, 235, 0.08);
        }

        /* ── Blue top bar ── */
        .top-bar {
            height: 4px;
            background: linear-gradient(90deg, #93c5fd, #2563eb, #1d4ed8);
        }

        /* ── Header ── */
        .header {
            padding: 40px 40px 32px;
            text-align: center;
            border-bottom: 1px solid #eff6ff;
        }

        .icon-circle {
            width: 72px;
            height: 72px;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            border-radius: 50%;
            margin: 0 auto 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 24px rgba(37, 99, 235, 0.3);
        }

        .icon-circle svg {
            width: 34px;
            height: 34px;
        }

        .header h1 {
            font-size: 22px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 8px;
        }

        .header p {
            font-size: 14px;
            color: #64748b;
            font-weight: 300;
        }

        /* ── Body ── */
        .body {
            padding: 32px 40px 36px;
        }

        .greeting {
            font-size: 14px;
            color: #475569;
            margin-bottom: 6px;
        }

        .greeting strong {
            color: #0f172a;
            font-weight: 600;
        }

        .message {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 28px;
            line-height: 1.7;
        }

        /* ── Button ── */
        .btn-wrap {
            text-align: center;
            margin-bottom: 28px;
            color: white;
        }

        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: #ffffff;
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
            padding: 14px 36px;
            border-radius: 12px;
            letter-spacing: 0.02em;
            box-shadow: 0 4px 16px rgba(37, 99, 235, 0.4);
        }

        /* ── Expiry ── */
        .expiry {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 12px;
            padding: 12px 16px;
            margin-bottom: 24px;
        }

        .expiry-icon {
            font-size: 16px;
            flex-shrink: 0;
        }

        .expiry p {
            font-size: 13px;
            color: #92400e;
        }

        .expiry strong {
            color: #d97706;
        }

        /* ── Note ── */
        .note {
            font-size: 12.5px;
            color: #94a3b8;
            line-height: 1.65;
            padding-top: 20px;
            border-top: 1px solid #f1f5f9;
        }

        /* ── URL fallback ── */
        .url-fallback {
            margin-top: 16px;
            background: #f8fafc;
            border-radius: 10px;
            padding: 12px 14px;
        }

        .url-fallback .label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #94a3b8;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .url-fallback a {
            font-size: 11.5px;
            color: #3b82f6;
            word-break: break-all;
            text-decoration: none;
        }

        /* ── Footer ── */
        .footer {
            background: #1e3a8a;
            padding: 20px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
        }

        .footer-brand {
            font-size: 13px;
            font-weight: 700;
            color: #93c5fd;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .footer-copy {
            font-size: 11px;
            color: #3b82f6;
        }

        /* ── Bottom note ── */
        .bottom-note {
            text-align: center;
            font-size: 11px;
            color: #94a3b8;
            margin-top: 20px;
        }

    </style>
</head>
<body>
<div class="wrapper">

    <!-- Brand -->
    <div class="brand"><?php echo e($appName); ?></div>

    <!-- Card -->
    <div class="card">

        <div class="top-bar"></div>

        <!-- Header -->
        <div class="header">
            <div class="icon-circle">
                <svg viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="3" y="8" width="28" height="19" rx="3.5" stroke="white" stroke-width="1.8" fill="none"/>
                    <path d="M3 13L17 21.5L31 13" stroke="white" stroke-width="1.8" stroke-linecap="round"/>
                    <circle cx="26" cy="25" r="6" fill="#22c55e"/>
                    <path d="M23.5 25L25.3 27L28.5 23" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h1>Confirmez votre email</h1>
            <p>Une étape simple pour sécuriser votre compte</p>
        </div>

        <!-- Body -->
        <div class="body">

            <p class="greeting">Bonjour <strong><?php echo e($user->name); ?></strong>,</p>
            <p class="message">
                Merci de nous avoir rejoint ! Cliquez sur le bouton ci-dessous pour confirmer votre adresse email et activer votre compte.
            </p>

            <!-- CTA -->
            <div class="btn-wrap">
                <a href="<?php echo e($url); ?>" class="btn">Confirmer mon email &rarr;</a>
            </div>

            <!-- Expiry -->
            <div class="expiry">
                <span class="expiry-icon">⏱</span>
                <p>Ce lien expire dans <strong><?php echo e($expireMinutes); ?> minutes</strong></p>
            </div>

            <!-- Note -->
            <p class="note">
                Vous n'avez pas créé de compte chez <strong><?php echo e($appName); ?></strong> ? Ignorez simplement cet email.
            </p>

            <!-- URL fallback -->
            <div class="url-fallback">
                <p class="label">Lien de secours</p>
                <a href="<?php echo e($url); ?>"><?php echo e($url); ?></a>
            </div>

        </div>

        <!-- Footer -->
        <div class="footer">
            <span class="footer-brand"><?php echo e($appName); ?></span>
            <span class="footer-copy">© <?php echo e(date('Y')); ?> Tous droits réservés</span>
        </div>

    </div>

    <p class="bottom-note">Email automatique · Ne pas répondre</p>

</div>
</body>
</html><?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views/emails/custom-verify-email.blade.php ENDPATH**/ ?>