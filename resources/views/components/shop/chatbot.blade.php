{{-- Chatbot Component - Laravel Blade + Alpine.js --}}

<style>
    /* ── Animations ── */
    @keyframes cb-pulse  { 0%,100%{opacity:1} 50%{opacity:.35} }
    @keyframes cb-bounce { 0%,80%,100%{transform:translateY(0)} 40%{transform:translateY(-5px)} }
    @keyframes cb-slide-up { from{opacity:0;transform:translateY(12px)} to{opacity:1;transform:translateY(0)} }
    @keyframes cb-pop    { from{opacity:0;transform:scale(.92)} to{opacity:1;transform:scale(1)} }
    @keyframes cb-msg-in { from{opacity:0;transform:translateY(6px)} to{opacity:1;transform:translateY(0)} }

    [x-cloak] { display:none !important; }

    /* ── Toggle button ── */
    .cb-toggle {
        width:60px; height:60px;
        background:linear-gradient(145deg,#3b82f6,#1d4ed8);
        border:none; border-radius:50%;
        color:white; font-size:22px;
        cursor:pointer;
        box-shadow:0 8px 28px rgba(37,99,235,.45);
        display:flex; align-items:center; justify-content:center;
        transition:transform .25s cubic-bezier(.34,1.56,.64,1), box-shadow .25s ease;
        position:relative;
    }
    .cb-toggle:hover { transform:scale(1.08); box-shadow:0 12px 36px rgba(37,99,235,.55); }
    .cb-toggle.is-open { transform:scale(1.05) rotate(15deg); }

    /* Notification badge */
    .cb-badge {
        position:absolute; top:-2px; right:-2px;
        width:16px; height:16px;
        background:#ef4444; border-radius:50%;
        border:2px solid white;
        animation:cb-pulse 2s infinite;
    }

    /* ── Window ── */
    .cb-window {
        position:absolute; bottom:72px; right:0;
        width:370px; height:520px;
        background:#ffffff;
        border-radius:20px;
        border:1px solid rgba(37,99,235,.12);
        box-shadow:0 24px 64px rgba(0,0,0,.13), 0 4px 16px rgba(37,99,235,.08);
        display:flex; flex-direction:column;
        overflow:hidden;
        animation:cb-pop .22s cubic-bezier(.34,1.3,.64,1);
        transform-origin:bottom right;
    }

    /* ── Header ── */
    .cb-header {
        flex-shrink:0;
        padding:14px 16px;
        background:linear-gradient(135deg,#1e40af 0%,#2563eb 60%,#3b82f6 100%);
        color:white;
        display:flex; align-items:center; gap:12px;
    }
    .cb-avatar {
        width:40px; height:40px; border-radius:12px;
        background:rgba(255,255,255,.18);
        display:flex; align-items:center; justify-content:center;
        font-size:20px; flex-shrink:0;
        border:1.5px solid rgba(255,255,255,.25);
    }
    .cb-header-info { flex:1; min-width:0; }
    .cb-header-name  { font-size:15px; font-weight:700; margin:0 0 2px; }
    .cb-header-status{ font-size:11px; opacity:.8; display:flex; align-items:center; gap:5px; }
    .cb-status-dot   { width:7px; height:7px; background:#4ade80; border-radius:50%; animation:cb-pulse 2s infinite; flex-shrink:0; }
    .cb-close {
        width:32px; height:32px;
        background:rgba(255,255,255,.12);
        border:none; border-radius:9px;
        color:white; cursor:pointer; font-size:14px;
        display:flex; align-items:center; justify-content:center;
        transition:background .15s;
        flex-shrink:0;
    }
    .cb-close:hover { background:rgba(255,255,255,.22); }

    /* ── Messages ── */
    .cb-messages {
        flex:1;
        overflow-y:auto;
        padding:14px 14px 6px;
        display:flex; flex-direction:column;
        gap:10px;
        background:#f8faff;
        /* Custom scrollbar */
        scrollbar-width:thin;
        scrollbar-color:#c7d7fe #f8faff;
    }
    .cb-messages::-webkit-scrollbar       { width:4px; }
    .cb-messages::-webkit-scrollbar-track { background:#f8faff; }
    .cb-messages::-webkit-scrollbar-thumb { background:#c7d7fe; border-radius:4px; }
    .cb-messages::-webkit-scrollbar-thumb:hover { background:#93c5fd; }

    /* Individual message row */
    .cb-row { display:flex; animation:cb-msg-in .2s ease; }
    .cb-row.user    { justify-content:flex-end; }
    .cb-row.bot     { justify-content:flex-start; align-items:flex-end; gap:7px; }

    /* Bot mini avatar */
    .cb-bot-icon {
        width:28px; height:28px; border-radius:8px;
        background:linear-gradient(135deg,#3b82f6,#1d4ed8);
        flex-shrink:0;
        display:flex; align-items:center; justify-content:center;
        font-size:13px;
    }

    /* Bubble */
    .cb-bubble {
        padding:10px 14px;
        font-size:13.5px; line-height:1.55;
        max-width:78%;
        word-break:break-word;
    }
    .cb-bubble.user {
        background:linear-gradient(135deg,#2563eb,#1d4ed8);
        color:white;
        border-radius:18px 18px 4px 18px;
        box-shadow:0 3px 10px rgba(37,99,235,.3);
    }
    .cb-bubble.bot {
        background:white;
        color:#1e293b;
        border-radius:18px 18px 18px 4px;
        border:1px solid #e2e8f0;
        box-shadow:0 2px 6px rgba(0,0,0,.05);
    }

    /* Date chip */
    .cb-datechip {
        text-align:center;
        font-size:10.5px; color:#94a3b8;
        padding:4px 10px;
        background:#eff6ff;
        border-radius:20px;
        align-self:center;
        margin:4px 0;
    }

    /* ── Loading dots ── */
    .cb-typing { display:flex; gap:4px; align-items:center; padding:2px 0; }
    .cb-dot { width:7px; height:7px; background:#93c5fd; border-radius:50%; }
    .cb-dot:nth-child(1) { animation:cb-bounce 1.3s infinite .0s; }
    .cb-dot:nth-child(2) { animation:cb-bounce 1.3s infinite .18s; }
    .cb-dot:nth-child(3) { animation:cb-bounce 1.3s infinite .36s; }

    /* ── Error ── */
    .cb-error {
        background:#fef2f2; color:#b91c1c;
        border:1px solid #fecaca; border-radius:10px;
        padding:8px 12px; font-size:12px;
    }

    /* ── Input area ── */
    .cb-input-wrap {
        flex-shrink:0;
        padding:10px 12px;
        background:white;
        border-top:1px solid #e2e8f0;
        display:flex; align-items:center; gap:8px;
    }
    .cb-input {
        flex:1;
        border:1.5px solid #e2e8f0;
        border-radius:14px;
        padding:10px 14px;
        font-size:13.5px;
        outline:none;
        font-family:inherit;
        color:#1e293b;
        background:#f8faff;
        transition:border-color .2s, box-shadow .2s, background .2s;
        resize:none;
    }
    .cb-input:focus {
        border-color:#3b82f6;
        box-shadow:0 0 0 3px rgba(59,130,246,.12);
        background:white;
    }
    .cb-input:disabled { background:#f1f5f9; cursor:not-allowed; color:#94a3b8; }
    .cb-input::placeholder { color:#94a3b8; }

    .cb-send {
        width:40px; height:40px; min-width:40px;
        border:none; border-radius:12px;
        background:linear-gradient(135deg,#3b82f6,#1d4ed8);
        color:white; cursor:pointer;
        display:flex; align-items:center; justify-content:center;
        box-shadow:0 3px 10px rgba(37,99,235,.35);
        transition:transform .15s, box-shadow .15s, background .15s;
    }
    .cb-send:hover:not(:disabled) { transform:scale(1.07); box-shadow:0 5px 16px rgba(37,99,235,.45); }
    .cb-send:active:not(:disabled){ transform:scale(.96); }
    .cb-send:disabled { background:#cbd5e1; box-shadow:none; cursor:not-allowed; }

    /* ── Scroll-to-bottom button ── */
    .cb-scroll-btn {
        position:absolute; bottom:72px; left:50%; transform:translateX(-50%);
        background:white; border:1px solid #e2e8f0;
        border-radius:20px; padding:5px 12px;
        font-size:11px; color:#475569;
        cursor:pointer; box-shadow:0 2px 8px rgba(0,0,0,.1);
        display:flex; align-items:center; gap:4px;
        transition:opacity .2s;
        white-space:nowrap;
    }
    .cb-scroll-btn:hover { background:#f0f7ff; color:#2563eb; }
</style>

<div x-data="chatbot('{{ $shop->subdomain ?? '' }}', '{{ $shop->name ?? config('app.name') }}')" style="position:fixed;bottom:24px;right:24px;z-index:9999;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;">

    {{-- Toggle button --}}
    <button
        class="cb-toggle"
        :class="open ? 'is-open' : ''"
        @click="open = !open; if(open) $nextTick(() => scrollToBottom())">
        <span x-show="!open">💬</span>
        <span x-show="open" x-cloak style="font-size:18px;font-weight:700;">✕</span>
        <span class="cb-badge" x-show="!open && unread > 0" x-cloak x-text="unread"></span>
    </button>

    {{-- Chat window --}}
    <div class="cb-window" x-show="open" x-cloak @click.outside="open = false" style="position:relative;">

        {{-- Header --}}
        <div class="cb-header">
            <div class="cb-avatar">🤖</div>
            <div class="cb-header-info">
                <p class="cb-header-name" x-text="'Assistant ' + shopName"></p>
                <span class="cb-header-status">
                    <span class="cb-status-dot"></span>
                    En ligne · Réponse rapide
                </span>
            </div>
            <button class="cb-close" @click="open = false" title="Fermer">✕</button>
        </div>

        {{-- Messages --}}
        <div class="cb-messages" x-ref="messages" @scroll="checkScroll()">

            <div class="cb-datechip">Aujourd'hui</div>

            <template x-for="(msg, index) in messages" :key="index">
                <div :class="'cb-row ' + msg.role">

                    {{-- Bot icon (only for bot messages) --}}
                    <div class="cb-bot-icon" x-show="msg.role === 'bot'">🤖</div>

                    <div :class="'cb-bubble ' + msg.role" x-text="msg.content"></div>
                </div>
            </template>

            {{-- Loading --}}
            <div class="cb-row bot" x-show="loading">
                <div class="cb-bot-icon">🤖</div>
                <div class="cb-bubble bot">
                    <div class="cb-typing">
                        <div class="cb-dot"></div>
                        <div class="cb-dot"></div>
                        <div class="cb-dot"></div>
                    </div>
                </div>
            </div>

            {{-- Error --}}
            <div class="cb-error" x-show="error" x-text="error"></div>

        </div>

        {{-- Scroll-to-bottom button --}}
        <button
            class="cb-scroll-btn"
            x-show="showScrollBtn"
            x-cloak
            @click="scrollToBottom()"
            style="position:absolute;bottom:66px;right:50%;transform:translateX(50%);">
            ↓ Nouveaux messages
        </button>

        {{-- Input --}}
        <div class="cb-input-wrap">
            <input
                class="cb-input"
                type="text"
                x-model="input"
                @keydown.enter="send()"
                :disabled="loading"
                placeholder="Écrivez votre message..."
            />
            <button
                class="cb-send"
                @click="send()"
                :disabled="loading || !input.trim()">
                <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                </svg>
            </button>
        </div>

    </div>
</div>

<script>
function chatbot(shopSubdomain = '', shopName = 'MaBoutique') {
    return {
        open: false,
        input: '',
        loading: false,
        error: '',
        unread: 1,
        showScrollBtn: false,
        shopSubdomain,
        shopName,
        messages: [
            { role: 'bot', content: 'Bonjour ! 👋 Je suis l\'assistant de ' + shopName + '. Produits, prix, livraison — comment puis-je vous aider ?' }
        ],

        async send() {
            if (!this.input.trim() || this.loading) return;

            this.unread = 0;
            this.error  = '';
            this.messages.push({ role: 'user', content: this.input });
            const msg = this.input;
            this.input   = '';
            this.loading = true;
            this.$nextTick(() => this.scrollToBottom());

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                if (!csrfToken) throw new Error('CSRF token introuvable');

                const res = await fetch('/chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        message: msg,
                        shop_subdomain: this.shopSubdomain || undefined
                    })
                });

                if (!res.ok) throw new Error('HTTP ' + res.status + ' : ' + res.statusText);

                const data = await res.json();
                if (data.reply) {
                    this.messages.push({ role: 'bot', content: data.reply });
                } else {
                    throw new Error('Réponse vide du serveur');
                }

            } catch (err) {
                console.error('Chat error:', err);
                this.error = 'Erreur : ' + err.message;
                this.messages.push({
                    role: 'bot',
                    content: "Désolé, je n'ai pas pu traiter votre message. Veuillez réessayer."
                });
            } finally {
                this.loading = false;
                this.$nextTick(() => this.scrollToBottom());
            }
        },

        scrollToBottom() {
            const el = this.$refs.messages;
            if (!el) return;
            el.scrollTo({ top: el.scrollHeight, behavior: 'smooth' });
            this.showScrollBtn = false;
        },

        checkScroll() {
            const el = this.$refs.messages;
            if (!el) return;
            const distanceFromBottom = el.scrollHeight - el.scrollTop - el.clientHeight;
            this.showScrollBtn = distanceFromBottom > 80;
        }
    }
}
</script>