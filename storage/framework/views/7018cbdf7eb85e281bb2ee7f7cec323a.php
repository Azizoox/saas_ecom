

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 px-4 py-12">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-3">🤖 Test du Chatbot</h1>
            <p class="text-gray-600 text-lg">Vérifiez la configuration et testez le chatbot en direct</p>
        </div>

        <div class="grid lg:grid-cols-3 gap-6">
            <!-- Left Column: Status & Configuration -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Status Card -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-blue-600">
                    <div class="flex items-center mb-4">
                        <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse mr-3"></div>
                        <h2 class="font-bold text-lg text-gray-900">Status</h2>
                    </div>
                    <p id="status" class="text-gray-600 text-sm">
                        <span class="inline-block animate-spin mr-2">⚙️</span>Vérification en cours...
                    </p>
                </div>

                <!-- Configuration Card -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-indigo-600">
                    <h3 class="font-bold text-lg text-gray-900 mb-4">Configuration</h3>
                    <div id="config-info" class="text-sm space-y-3">
                        <div class="flex items-center">
                            <span class="inline-block animate-spin mr-2">⚙️</span>
                            <span class="text-gray-600">Vérification...</span>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <label for="shop-select" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Boutique (contexte catalogue)</label>
                        <select id="shop-select" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-indigo-500">
                            <option value="">— Sans boutique —</option>
                        </select>
                    </div>
                </div>

                <!-- Important Notes -->
                <div class="bg-amber-50 rounded-2xl border-2 border-amber-200 p-6">
                    <h3 class="font-bold text-amber-900 mb-4 flex items-center">
                        <span class="text-xl mr-2">⚠️</span> Notes Importantes
                    </h3>
                    <ul class="text-sm text-amber-800 space-y-2">
                        <li class="flex gap-2">
                            <span class="text-amber-600">•</span>
                            <span>Migrations: <code class="bg-white px-1.5 py-0.5 rounded text-xs font-mono">php artisan migrate</code></span>
                        </li>
                        <li class="flex gap-2">
                            <span class="text-amber-600">•</span>
                            <span>Clé API: Configurez <code class="bg-white px-1.5 py-0.5 rounded text-xs font-mono">OPENAI_API_KEY</code></span>
                        </li>
                        <li class="flex gap-2">
                            <span class="text-amber-600">•</span>
                            <span>Chatbot en direct: Landing page (landing.blade.php)</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Right Column: Chat Interface -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden flex flex-col" style="height: 600px;">
                    <!-- Chat Header -->
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-6">
                        <h3 class="font-bold text-xl">Chat Test</h3>
                        <p class="text-blue-100 text-sm mt-1">Testez le chatbot en envoyant des messages</p>
                    </div>

                    <!-- Chat Messages -->
                    <div id="test-messages" class="flex-1 overflow-y-auto p-6 space-y-4 bg-gray-50">
                        <div class="flex justify-center">
                            <div class="bg-white rounded-full px-4 py-2 text-gray-600 text-sm border border-gray-200">
                                Commencez la conversation
                            </div>
                        </div>
                    </div>

                    <!-- Chat Input -->
                    <div class="border-t border-gray-200 bg-white p-4">
                        <div class="flex gap-3">
                            <input 
                                id="test-input" 
                                type="text" 
                                placeholder="Entrez un message..." 
                                @keydown.enter="sendTestMessage()"
                                class="flex-1 border border-gray-300 rounded-full px-5 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition" 
                            />
                            <button 
                                onclick="sendTestMessage()" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-full font-semibold text-sm transition-all duration-200 hover:shadow-lg active:scale-95 flex items-center gap-2"
                            >
                                <span>Envoyer</span>
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M16.6915026,12.4744748 L3.50612381,13.2599618 C3.19218622,13.2599618 3.03521743,13.4170592 3.03521743,13.5741566 L1.15159189,20.0151496 C0.8376543,20.8006365 0.99,21.89 1.77946707,22.52 C2.41,22.99 3.50612381,23.1 4.13399899,22.8429026 L21.714504,14.0454487 C22.6563168,13.5741566 23.1272231,12.6315722 22.9702544,11.6889879 L4.13399899,1.16612285 C3.34915502,0.9 2.40734225,1.00636533 1.77946707,1.4776575 C0.994623095,2.10604706 0.837654326,3.0486314 1.15159189,3.99021575 L3.03521743,10.4311088 C3.03521743,10.5882061 3.19218622,10.7453035 3.50612381,10.7453035 L16.6915026,11.5307905 C16.6915026,11.5307905 17.1624089,11.5307905 17.1624089,12.0020827 C17.1624089,12.4744748 16.6915026,12.4744748 16.6915026,12.4744748 Z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let selectedShopSubdomain = '';

async function checkStatus() {
    try {
        const res = await fetch('/test-db');
        const data = await res.json();
        
        document.getElementById('status').innerHTML = `
            <div class="text-green-600 font-semibold mb-2">✓ Base de données connectée</div>
            <div class="text-gray-600 text-xs space-y-1">
                <div>🏪 Boutiques: <span class="font-bold">${data.shops_count || 0}</span></div>
                <div>📦 Produits: <span class="font-bold">${data.products_count || 0}</span></div>
                <div>💬 Conversations: <span class="font-bold">${data.conversations_count || 0}</span></div>
                <div>💭 Messages: <span class="font-bold">${data.messages_count || 0}</span></div>
            </div>
        `;

        const shopSelect = document.getElementById('shop-select');
        if (data.shops && data.shops.length) {
            data.shops.forEach(s => {
                const opt = document.createElement('option');
                opt.value = s.subdomain;
                opt.textContent = s.subdomain;
                shopSelect.appendChild(opt);
            });
            shopSelect.addEventListener('change', () => {
                selectedShopSubdomain = shopSelect.value;
            });
            if (data.shops[0]) {
                shopSelect.value = data.shops[0].subdomain;
                selectedShopSubdomain = data.shops[0].subdomain;
            }
        }

        document.getElementById('config-info').innerHTML = `
            <div class="flex items-center text-green-600">
                <span class="text-green-500 mr-2">✓</span>
                <span>Route POST /chat</span>
            </div>
            <div class="flex items-center text-green-600">
                <span class="text-green-500 mr-2">✓</span>
                <span>Modèle: gpt-4o-mini</span>
            </div>
            <div class="flex items-center" id="openai-status">
                <span class="inline-block animate-spin mr-2">⚙️</span>
                <span class="text-gray-600">Vérification OpenAI...</span>
            </div>
        `;

        const testBody = { message: 'Bonjour' };
        if (selectedShopSubdomain) testBody.shop_subdomain = selectedShopSubdomain;

        await fetch('/chat', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
            },
            body: JSON.stringify(testBody)
        }).then(r => r.json()).then(d => {
            if (d.reply) {
                document.getElementById('openai-status').innerHTML = `
                    <span class="text-green-500 mr-2">✓</span>
                    <span class="text-green-600">OpenAI connecté — réponses IA actives</span>
                `;
            } else {
                document.getElementById('openai-status').innerHTML = `
                    <span class="text-orange-500 mr-2">⚠</span>
                    <span class="text-orange-600">Mode fallback (vérifiez OPENAI_API_KEY)</span>
                `;
            }
        }).catch(() => {
            document.getElementById('openai-status').innerHTML = `
                <span class="text-orange-500 mr-2">⚠</span>
                <span class="text-orange-600">ChatService non disponible</span>
            `;
        });

    } catch (e) {
        document.getElementById('status').innerHTML = `<span class="text-red-600">✗ Erreur: ${e.message}</span>`;
    }
}

async function sendTestMessage() {
    const input = document.getElementById('test-input');
    const messages = document.getElementById('test-messages');
    const msg = input.value.trim();
    
    if (!msg) return;
    
    // Clear initial message if present
    const initialMsg = messages.querySelector('.flex.justify-center');
    if (initialMsg && messages.children.length === 1) {
        initialMsg.remove();
    }
    
    // Add user message
    const userDiv = document.createElement('div');
    userDiv.className = 'flex justify-end animate-fade-in';
    userDiv.innerHTML = `
        <div class="bg-blue-600 text-white rounded-3xl rounded-tr-none px-4 py-2.5 max-w-xs shadow-md text-sm leading-relaxed">
            ${escapeHtml(msg)}
        </div>
    `;
    messages.appendChild(userDiv);
    
    input.value = '';
    input.focus();
    messages.scrollTop = messages.scrollHeight;
    
    try {
        const res = await fetch('/chat', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
            },
            body: JSON.stringify({
                message: msg,
                shop_subdomain: selectedShopSubdomain || undefined
            })
        });
        
        const data = await res.json();
        
        const assistantDiv = document.createElement('div');
        assistantDiv.className = 'flex justify-start animate-fade-in';
        assistantDiv.innerHTML = `
            <div class="bg-white text-gray-800 rounded-3xl rounded-tl-none border border-gray-200 px-4 py-2.5 max-w-xs shadow-md text-sm leading-relaxed">
                ${escapeHtml(data.reply || 'Pas de réponse')}
            </div>
        `;
        messages.appendChild(assistantDiv);
        
        messages.scrollTop = messages.scrollHeight;
    } catch (e) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'flex justify-start';
        errorDiv.innerHTML = `
            <div class="bg-red-50 text-red-700 rounded-lg px-3 py-2 text-xs border border-red-200">
                <span class="font-semibold">Erreur:</span> ${escapeHtml(e.message)}
            </div>
        `;
        messages.appendChild(errorDiv);
        messages.scrollTop = messages.scrollHeight;
    }
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Add CSS for animation
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-in {
        animation: fadeIn 0.3s ease-out;
    }
    
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
`;
document.head.appendChild(style);

document.addEventListener('DOMContentLoaded', checkStatus);

// Allow Enter key to send message
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('test-input').addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendTestMessage();
        }
    });
});
</script>

<style>
    input:focus {
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.layouts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views/chat-test.blade.php ENDPATH**/ ?>