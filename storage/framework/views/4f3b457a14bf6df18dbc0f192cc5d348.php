
<?php $__env->startSection('content'); ?>


    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 lg:pt-40 lg:pb-32 overflow-hidden gradient-bg">
        <!-- Decorative blobs -->
        <div class="blob w-96 h-96 bg-blue-400 top-10 -left-20 animate-float"></div>
        <div class="blob w-96 h-96 bg-orange-400 bottom-10 -right-20 animate-float" style="animation-delay: 1s;"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="text-white">
                    <h1 class="text-5xl lg:text-6xl xl:text-7xl font-bold mb-6 leading-tight animate-fadeInUp">
                        Créez Votre <span class="text-orange-400">Boutique</span> en Ligne en Minutes
                    </h1>
                    <p class="text-xl lg:text-2xl mb-8 text-blue-100 animate-fadeInUp delay-100">
                        La plateforme e-commerce la plus simple et puissante pour lancer votre business en ligne.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 animate-fadeInUp delay-200">
                        <a href="#" class="btn-primary bg-orange-500 hover:bg-orange-600 text-white px-8 py-4 rounded-full font-bold text-lg shadow-2xl inline-flex items-center justify-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Créer Ma Boutique
                        </a>
                        <a href="#features" class="glass text-white px-8 py-4 rounded-full font-bold text-lg inline-flex items-center justify-center hover:bg-white/20 transition">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Voir la Démo
                        </a>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-6 mt-12 animate-fadeInUp delay-300" id="stats-section">
                        <div>
                            <div class="stat-number text-orange-400" data-target="5000" data-suffix="K+" data-animate="true">0</div>
                            <div class="text-blue-100 mt-2">Boutiques</div>
                        </div>
                        <div>
                            <div class="stat-number text-orange-400" data-target="98" data-suffix="%" data-animate="true">0</div>
                            <div class="text-blue-100 mt-2">Satisfaction</div>
                        </div>
                        <div>
                            <div class="stat-number text-orange-400" data-static="24/7">24/7</div>
                            <div class="text-blue-100 mt-2">Support</div>
                        </div>
                    </div>
                </div>

                <!-- Right Content - Mockup -->
                <div class="relative animate-fadeInRight delay-200">
                    <div class="relative z-10">
                        <img src="<?php echo e(asset('images/hero.png')); ?>" 
                             alt="Shopino Dashboard"  style="height: 350px;"
                             class="w-full h-full  rounded-2xl shadow-2xl transform hover:scale-105 transition-transform duration-500">
                    </div>
                    <!-- Floating cards -->
                    <div class="absolute -top-10 -left-10 glass p-4 rounded-xl shadow-xl animate-float">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div class="text-white">
                                <div class="font-bold">+125 Ventes</div>
                                <div class="text-sm text-blue-100">Aujourd'hui</div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute -bottom-10 -right-10 glass p-4 rounded-xl shadow-xl animate-float" style="animation-delay: 1.5s; margin-bottom: -30px;">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-orange-500 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                            <div class="text-white " >
                                <div class="font-bold">4,850 DT</div>
                                <div class="text-sm text-blue-100">Revenue</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 lg:py-32 bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl lg:text-5xl font-bold mb-4" style="color: var(--primary);">
                    Tout ce dont vous avez <span class="gradient-text">besoin</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Des fonctionnalités puissantes pour développer votre business en ligne
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="feature-card bg-white p-8 rounded-2xl shadow-lg">
                    <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3" style="color: var(--primary);">Design Personnalisable</h3>
                    <p class="text-gray-600">
                        Des templates modernes et entièrement personnalisables pour refléter l'identité de votre marque.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="feature-card bg-white p-8 rounded-2xl shadow-lg">
                    <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3" style="color: var(--primary);">Paiements Sécurisés</h3>
                    <p class="text-gray-600">
                        Intégration avec tous les moyens de paiement populaires en Tunisie et dans le monde.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="feature-card bg-white p-8 rounded-2xl shadow-lg">
                    <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3" style="color: var(--primary);">Analytics Avancés</h3>
                    <p class="text-gray-600">
                        Suivez vos ventes, vos clients et vos performances en temps réel avec des rapports détaillés.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="feature-card bg-white p-8 rounded-2xl shadow-lg">
                    <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3" style="color: var(--primary);">100% Responsive</h3>
                    <p class="text-gray-600">
                        Votre boutique s'adapte parfaitement à tous les appareils : mobile, tablette et desktop.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div class="feature-card bg-white p-8 rounded-2xl shadow-lg">
                    <div class="w-16 h-16 bg-red-100 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3" style="color: var(--primary);">Gestion Stocks</h3>
                    <p class="text-gray-600">
                        Gérez facilement votre inventaire, vos produits et vos commandes depuis un seul endroit.
                    </p>
                </div>

                <!-- Feature 6 -->
                <div class="feature-card bg-white p-8 rounded-2xl shadow-lg">
                    <div class="w-16 h-16 bg-yellow-100 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3" style="color: var(--primary);">Support 24/7</h3>
                    <p class="text-gray-600">
                        Notre équipe est toujours disponible pour vous aider à réussir votre projet e-commerce.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-20 lg:py-32 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl lg:text-5xl font-bold mb-4" style="color: var(--primary);">
                    Comment ça <span class="gradient-text">fonctionne</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Lancez votre boutique en 3 étapes simples
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 md:gap-12">
                <!-- Step 1 -->
                <div class="text-center">
                    <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl">
                        <span class="text-4xl font-bold text-white">1</span>
                    </div>
                    <h3 class="text-2xl font-bold mb-4" style="color: var(--primary);">Créez votre compte</h3>
                    <p class="text-gray-600 text-lg">
                        Inscription gratuite en moins de 2 minutes. Aucune carte bancaire requise.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="text-center">
                    <div class="w-24 h-24 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl">
                        <span class="text-4xl font-bold text-white">2</span>
                    </div>
                    <h3 class="text-2xl font-bold mb-4" style="color: var(--primary);">Ajoutez vos produits</h3>
                    <p class="text-gray-600 text-lg">
                        Importez facilement vos produits avec photos, descriptions et prix.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="text-center">
                    <div class="w-24 h-24 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl">
                        <span class="text-4xl font-bold text-white">3</span>
                    </div>
                    <h3 class="text-2xl font-bold mb-4" style="color: var(--primary);">Commencez à vendre</h3>
                    <p class="text-gray-600 text-lg">
                        Partagez votre boutique et commencez à recevoir des commandes immédiatement.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-20 lg:py-32 bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl lg:text-5xl font-bold mb-4" style="color: var(--primary);">
                    Des tarifs <span class="gradient-text">transparents</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Choisissez le plan qui correspond à vos besoins
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- Starter Plan -->
                <div class="pricing-card bg-white rounded-3xl shadow-xl p-8 border-2 border-gray-100">
                    <div class="text-center">
                        <h3 class="text-2xl font-bold mb-2" style="color: var(--primary);">Starter</h3>
                        <div class="mt-4 mb-6">
                            <span class="text-5xl font-bold" style="color: var(--primary);">Gratuit</span>
                        </div>
                        <p class="text-gray-600 mb-8">Parfait pour débuter</p>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">Jusqu'à 50 produits</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">Templates gratuits</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">Support par email</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">SSL gratuit</span>
                        </li>
                    </ul>
                    <button class="w-full bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-4 rounded-full transition">
                        Commencer
                    </button>
                </div>

                <!-- Pro Plan (Popular) -->
                <div class="pricing-card popular bg-white rounded-3xl shadow-2xl p-8 transform scale-105 relative">
                    <div class="absolute -top-5 left-1/2 transform -translate-x-1/2">
                        <span class="bg-gradient-to-r from-orange-500 to-orange-600 text-white px-6 py-2 rounded-full text-sm font-bold shadow-lg">
                            POPULAIRE
                        </span>
                    </div>
                    <div class="text-center">
                        <h3 class="text-2xl font-bold mb-2" style="color: var(--primary);">Pro</h3>
                        <div class="mt-4 mb-2">
                            <span class="text-5xl font-bold" style="color: var(--primary);">99 DT</span>
                            <span class="text-gray-600">/mois</span>
                        </div>
                        <p class="text-gray-600 mb-8">Pour les entreprises en croissance</p>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700 font-semibold">Produits illimités</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700 font-semibold">Templates premium</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700 font-semibold">Support prioritaire</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700 font-semibold">Analytics avancés</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700 font-semibold">0% commission</span>
                        </li>
                    </ul>
                    <button class="w-full btn-primary bg-gradient-to-r from-orange-500 to-orange-600 text-white font-bold py-4 rounded-full shadow-lg">
                        Commencer Maintenant
                    </button>
                </div>

                <!-- Enterprise Plan -->
                <div class="pricing-card bg-white rounded-3xl shadow-xl p-8 border-2 border-gray-100">
                    <div class="text-center">
                        <h3 class="text-2xl font-bold mb-2" style="color: var(--primary);">Enterprise</h3>
                        <div class="mt-4 mb-6">
                            <span class="text-5xl font-bold" style="color: var(--primary);">Sur Devis</span>
                        </div>
                        <p class="text-gray-600 mb-8">Solutions personnalisées</p>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">Tout du plan Pro</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">Design sur mesure</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">Account manager dédié</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">API personnalisée</span>
                        </li>
                    </ul>
                    <button class="w-full bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-4 rounded-full transition">
                        Nous Contacter
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section id="testimonials" class="py-20 lg:py-32 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl lg:text-5xl font-bold mb-4" style="color: var(--primary);">
                    Ce que disent nos <span class="gradient-text">clients</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Des milliers d'entrepreneurs nous font confiance
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-gray-50 p-8 rounded-2xl shadow-lg">
                    <div class="flex mb-4">
                        <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    </div>
                    <p class="text-gray-700 mb-6 text-lg italic">
                        "Shopino a transformé mon business. En une semaine, j'ai lancé ma boutique et j'ai commencé à vendre. L'interface est intuitive et le support est excellent!"
                    </p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white font-bold text-lg mr-4">
                            S
                        </div>
                        <div>
                            <div class="font-bold" style="color: var(--primary);">Sarah Mansour</div>
                            <div class="text-gray-600 text-sm">Boutique Mode</div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-gray-50 p-8 rounded-2xl shadow-lg">
                    <div class="flex mb-4">
                        <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    </div>
                    <p class="text-gray-700 mb-6 text-lg italic">
                        "Les outils de gestion sont incroyables. Je peux suivre mes commandes, mon stock et mes statistiques en temps réel. C'est exactement ce dont j'avais besoin!"
                    </p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-400 to-orange-600 rounded-full flex items-center justify-center text-white font-bold text-lg mr-4">
                            K
                        </div>
                        <div>
                            <div class="font-bold" style="color: var(--primary);">Karim Ben Ali</div>
                            <div class="text-gray-600 text-sm">Électronique & Tech</div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-gray-50 p-8 rounded-2xl shadow-lg">
                    <div class="flex mb-4">
                        <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    </div>
                    <p class="text-gray-700 mb-6 text-lg italic">
                        "Meilleur investissement pour mon business! Les templates sont magnifiques et le responsive est parfait. Mes ventes ont doublé depuis que j'utilise Shopino."
                    </p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center text-white font-bold text-lg mr-4">
                            A
                        </div>
                        <div>
                            <div class="font-bold" style="color: var(--primary);">Amira Trabelsi</div>
                            <div class="text-gray-600 text-sm">Cosmétiques Bio</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 lg:py-32 gradient-bg relative overflow-hidden">
        <div class="blob w-96 h-96 bg-orange-400 top-0 right-0 animate-float"></div>
        <div class="blob w-96 h-96 bg-blue-400 bottom-0 left-0 animate-float" style="animation-delay: 1s;"></div>
        
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h2 class="text-4xl lg:text-6xl font-bold text-white mb-6">
                Prêt à Lancer Votre Boutique?
            </h2>
            <p class="text-xl lg:text-2xl text-blue-100 mb-10">
                Rejoignez des milliers d'entrepreneurs qui ont choisi Shopino pour développer leur business en ligne.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#" class="btn-primary bg-orange-500 hover:bg-orange-600 text-white px-10 py-5 rounded-full font-bold text-xl shadow-2xl inline-flex items-center justify-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Démarrer Gratuitement
                </a>
                <a href="#" class="glass text-white px-10 py-5 rounded-full font-bold text-xl inline-flex items-center justify-center hover:bg-white/20 transition">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    Parler à un Expert
                </a>
            </div>
            <p class="text-blue-100 mt-6 text-sm">
                ✓ Sans carte bancaire  ✓ Configuration en 5 minutes  ✓ Support en français
            </p>
        </div>
    </section>

    <script>
        // Counter Animation for Stats
        document.addEventListener('DOMContentLoaded', function() {
            const statsSection = document.getElementById('stats-section');
            const animatedStats = document.querySelectorAll('[data-animate="true"]');
            let hasAnimated = false;

            // Intersection Observer to trigger animation when stats are visible
            const observerOptions = {
                threshold: 0.5,
                rootMargin: '0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && !hasAnimated) {
                        hasAnimated = true;
                        animateCounters();
                    }
                });
            }, observerOptions);

            observer.observe(statsSection);

            // Animation function
            function animateCounters() {
                animatedStats.forEach(stat => {
                    const target = parseInt(stat.getAttribute('data-target'));
                    const suffix = stat.getAttribute('data-suffix');
                    const duration = 2000; // 2 seconds
                    const startTime = performance.now();
                    const startValue = 0;

                    function easeOutQuad(t) {
                        return t * (2 - t); // Quadratic easing
                    }

                    function animate(currentTime) {
                        const elapsed = currentTime - startTime;
                        const progress = Math.min(elapsed / duration, 1);
                        const easeProgress = easeOutQuad(progress);
                        const currentValue = Math.floor(startValue + (target - startValue) * easeProgress);
                        
                        if (suffix === 'K+') {
                            stat.textContent = (currentValue / 1000).toFixed(1) + suffix;
                        } else {
                            stat.textContent = currentValue + suffix;
                        }

                        if (progress < 1) {
                            requestAnimationFrame(animate);
                        } else {
                            // Final value
                            if (suffix === 'K+') {
                                stat.textContent = (target / 1000).toFixed(1) + suffix;
                            } else {
                                stat.textContent = target + suffix;
                            }
                        }
                    }

                    requestAnimationFrame(animate);
                });
            }
        });
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layouts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views/landing.blade.php ENDPATH**/ ?>