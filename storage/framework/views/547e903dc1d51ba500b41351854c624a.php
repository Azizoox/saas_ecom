<?php $__env->startSection('title', 'Confirmer ma commande - ' . ($shop->name ?? 'Ma Boutique')); ?>

<?php $__env->startSection('content'); ?>
    <div class="container my-5">
        
        <div class="row mb-5">
            <div class="col-12">
                <div class="d-flex align-items-center mb-4">
                    <div class="checkout-step-indicator">
                        <span class="step completed">
                            <i class="bi bi-check2"></i>
                        </span>
                        <span class="step-label">Panier</span>
                    </div>
                    <div class="step-connector"></div>
                    <div class="checkout-step-indicator">
                        <span class="step completed">
                            <i class="bi bi-check2"></i>
                        </span>
                        <span class="step-label">Infos</span>
                    </div>
                    <div class="step-connector"></div>
                    <div class="checkout-step-indicator">
                        <span class="step active">3</span>
                        <span class="step-label">Confirmation</span>
                    </div>
                </div>
                <h1 class="mb-2">Vérifier votre commande</h1>
                <p class="text-muted">Veuillez vérifier les détails avant de confirmer votre commande</p>
            </div>
        </div>

        <div class="row">
            
            <div class="col-lg-8">
                
                <div class="confirm-card mb-4">
                    <div class="card-header-custom">
                        <h5 class="mb-0">
                            <i class="bi bi-box-seam me-2"></i>Produits commandés
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="confirm-item">
                                <div class="item-image">
                                    <?php if($item->product->image): ?>
                                        <img src="<?php echo e(asset('storage/' . $item->product->image)); ?>"
                                             alt="<?php echo e($item->product->name); ?>" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                    <?php else: ?>
                                        <div style="width: 60px; height: 60px; background: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="item-details">
                                    <h6 class="mb-1"><?php echo e($item->product->name); ?></h6>
                                    <small class="text-muted"><?php echo e($item->quantity); ?> × <?php echo e(number_format($item->product->price, 2, ',', ' ')); ?> TND</small>
                                </div>
                                <div class="item-price">
                                    <strong><?php echo e(number_format($item->product->price * $item->quantity, 2, ',', ' ')); ?> TND</strong>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                
                <div class="confirm-card mb-4">
                    <div class="card-header-custom">
                        <h5 class="mb-0">
                            <i class="bi bi-person me-2"></i>Informations client
                        </h5>
                        <a href="#" class="edit-link" data-bs-toggle="modal" data-bs-target="#editCustomerModal">
                            <i class="bi bi-pencil-square"></i>Modifier
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Prénom</small>
                                <strong><?php echo e($customerData['first_name'] ?? 'N/A'); ?></strong>
                            </div>
                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Nom</small>
                                <strong><?php echo e($customerData['last_name'] ?? 'N/A'); ?></strong>
                            </div>
                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Email</small>
                                <strong><?php echo e($customerData['email'] ?? 'N/A'); ?></strong>
                            </div>
                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Téléphone</small>
                                <strong><?php echo e($customerData['phone'] ?? 'N/A'); ?></strong>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="confirm-card mb-4">
                    <div class="card-header-custom">
                        <h5 class="mb-0">
                            <i class="bi bi-geo-alt me-2"></i>Adresse de livraison
                        </h5>
                        <a href="#" class="edit-link" data-bs-toggle="modal" data-bs-target="#editAddressModal">
                            <i class="bi bi-pencil-square"></i>Modifier
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="address-block">
                            <p class="mb-2">
                                <strong><?php echo e($customerData['first_name']); ?> <?php echo e($customerData['last_name']); ?></strong>
                            </p>
                            <p class="mb-1"><?php echo e($customerData['address'] ?? 'N/A'); ?></p>
                            <p class="mb-1"><?php echo e($customerData['city'] ?? 'N/A'); ?> <?php echo e($customerData['postal_code'] ?? 'N/A'); ?></p>
                            <p><?php echo e($customerData['country'] ?? 'N/A'); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="col-lg-4">
                
                <div class="confirm-card sticky-top" style="top: 20px;">
                    <div class="card-header-custom">
                        <h5 class="mb-0">
                            <i class="bi bi-receipt me-2"></i>Récapitulatif
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="summary-row">
                            <span>Sous-total</span>
                            <span><?php echo e(number_format($subtotal, 2, ',', ' ')); ?> TND</span>
                        </div>
                        <div class="summary-row">
                            <span>Frais de livraison</span>
                            <span><?php echo e(number_format($shippingCost, 2, ',', ' ')); ?> TND</span>
                        </div>
                        <?php if(!empty($discountTotal) && $discountTotal > 0): ?>
                            <div class="summary-row text-success">
                                <span>Réduction</span>
                                <span>-<?php echo e(number_format($discountTotal, 2, ',', ' ')); ?> TND</span>
                            </div>
                        <?php endif; ?>
                        <div class="summary-divider"></div>
                        <div class="summary-row-total">
                            <span>TOTAL</span>
                            <span><?php echo e(number_format($totalPrice, 2, ',', ' ')); ?> TND</span>
                        </div>
                    </div>

                    
                    <div class="card-footer-custom">
                        <form id="confirmOrderForm" action="<?php echo e(route('shop.process-order', ['subdomain' => $shop->subdomain])); ?>" method="POST">
                            <?php echo csrf_field(); ?>

                            
                            <input type="hidden" name="first_name" value="<?php echo e($customerData['first_name'] ?? ''); ?>">
                            <input type="hidden" name="last_name" value="<?php echo e($customerData['last_name'] ?? ''); ?>">
                            <input type="hidden" name="email" value="<?php echo e($customerData['email'] ?? ''); ?>">
                            <input type="hidden" name="phone" value="<?php echo e($customerData['phone'] ?? ''); ?>">
                            <input type="hidden" name="address" value="<?php echo e($customerData['address'] ?? ''); ?>">
                            <input type="hidden" name="city" value="<?php echo e($customerData['city'] ?? ''); ?>">
                            <input type="hidden" name="postal_code" value="<?php echo e($customerData['postal_code'] ?? ''); ?>">
                            <input type="hidden" name="country" value="<?php echo e($customerData['country'] ?? ''); ?>">
                            <input type="hidden" name="payment_method" value="<?php echo e($paymentMethod ?? 'card'); ?>">

                            <button type="submit" class="btn btn-success btn-lg w-100 mb-3">
                                <i class="bi bi-lock-fill me-2"></i>Confirmer la commande
                            </button>
                        </form>

                        <a href="<?php echo e(route('shop.checkout', ['subdomain' => $shop->subdomain])); ?>" class="btn btn-outline-secondary btn-lg w-100">
                            <i class="bi bi-arrow-left me-2"></i>Retour
                        </a>
                    </div>
                </div>

                
                <div class="security-info mt-4">
                    <p class="mb-2">
                        <i class="bi bi-shield-check text-success"></i>
                        <small>Paiement sécurisé</small>
                    </p>
                    <p class="mb-0">
                        <i class="bi bi-truck text-info"></i>
                        <small>Livraison rapide</small>
                    </p>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="editCustomerModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modifier les informations</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Prénom</label>
                        <input type="text" class="form-control edit-first-name" value="<?php echo e($customerData['first_name'] ?? ''); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nom</label>
                        <input type="text" class="form-control edit-last-name" value="<?php echo e($customerData['last_name'] ?? ''); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control edit-email" value="<?php echo e($customerData['email'] ?? ''); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Téléphone</label>
                        <input type="tel" class="form-control edit-phone" value="<?php echo e($customerData['phone'] ?? ''); ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" id="saveCustomerBtn">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="editAddressModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modifier l'adresse de livraison</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Adresse</label>
                        <input type="text" class="form-control edit-address" value="<?php echo e($customerData['address'] ?? ''); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ville</label>
                        <input type="text" class="form-control edit-city" value="<?php echo e($customerData['city'] ?? ''); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Code postal</label>
                        <input type="text" class="form-control edit-postal-code" value="<?php echo e($customerData['postal_code'] ?? ''); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gouvernorat</label>
                        <select class="form-select edit-country">
                            <option>-- Sélectionner un gouvernorat --</option>
                            <option value="Ariana" <?php echo e(($customerData['country'] ?? '') == 'Ariana' ? 'selected' : ''); ?>>Ariana</option>
                            <option value="Béja" <?php echo e(($customerData['country'] ?? '') == 'Béja' ? 'selected' : ''); ?>>Béja</option>
                            <option value="Ben Arous" <?php echo e(($customerData['country'] ?? '') == 'Ben Arous' ? 'selected' : ''); ?>>Ben Arous</option>
                            <option value="Bizerte" <?php echo e(($customerData['country'] ?? '') == 'Bizerte' ? 'selected' : ''); ?>>Bizerte</option>
                            <option value="Gabès" <?php echo e(($customerData['country'] ?? '') == 'Gabès' ? 'selected' : ''); ?>>Gabès</option>
                            <option value="Gafsa" <?php echo e(($customerData['country'] ?? '') == 'Gafsa' ? 'selected' : ''); ?>>Gafsa</option>
                            <option value="Jendouba" <?php echo e(($customerData['country'] ?? '') == 'Jendouba' ? 'selected' : ''); ?>>Jendouba</option>
                            <option value="Kairouan" <?php echo e(($customerData['country'] ?? '') == 'Kairouan' ? 'selected' : ''); ?>>Kairouan</option>
                            <option value="Kasserine" <?php echo e(($customerData['country'] ?? '') == 'Kasserine' ? 'selected' : ''); ?>>Kasserine</option>
                            <option value="Kébili" <?php echo e(($customerData['country'] ?? '') == 'Kébili' ? 'selected' : ''); ?>>Kébili</option>
                            <option value="Le Kef" <?php echo e(($customerData['country'] ?? '') == 'Le Kef' ? 'selected' : ''); ?>>Le Kef</option>
                            <option value="Mahdia" <?php echo e(($customerData['country'] ?? '') == 'Mahdia' ? 'selected' : ''); ?>>Mahdia</option>
                            <option value="La Manouba" <?php echo e(($customerData['country'] ?? '') == 'La Manouba' ? 'selected' : ''); ?>>La Manouba</option>
                            <option value="Médenine" <?php echo e(($customerData['country'] ?? '') == 'Médenine' ? 'selected' : ''); ?>>Médenine</option>
                            <option value="Monastir" <?php echo e(($customerData['country'] ?? '') == 'Monastir' ? 'selected' : ''); ?>>Monastir</option>
                            <option value="Nabeul" <?php echo e(($customerData['country'] ?? '') == 'Nabeul' ? 'selected' : ''); ?>>Nabeul</option>
                            <option value="Sfax" <?php echo e(($customerData['country'] ?? '') == 'Sfax' ? 'selected' : ''); ?>>Sfax</option>
                            <option value="Sidi Bouzid" <?php echo e(($customerData['country'] ?? '') == 'Sidi Bouzid' ? 'selected' : ''); ?>>Sidi Bouzid</option>
                            <option value="Siliana" <?php echo e(($customerData['country'] ?? '') == 'Siliana' ? 'selected' : ''); ?>>Siliana</option>
                            <option value="Sousse" <?php echo e(($customerData['country'] ?? '') == 'Sousse' ? 'selected' : ''); ?>>Sousse</option>
                            <option value="Tataouine" <?php echo e(($customerData['country'] ?? '') == 'Tataouine' ? 'selected' : ''); ?>>Tataouine</option>
                            <option value="Tozeur" <?php echo e(($customerData['country'] ?? '') == 'Tozeur' ? 'selected' : ''); ?>>Tozeur</option>
                            <option value="Tunis" <?php echo e(($customerData['country'] ?? '') == 'Tunis' ? 'selected' : ''); ?>>Tunis</option>
                            <option value="Zaghouan" <?php echo e(($customerData['country'] ?? '') == 'Zaghouan' ? 'selected' : ''); ?>>Zaghouan</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" id="saveAddressBtn">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        :root {
            --primary-color: #f15a24;
            --secondary-color: #667eea;
            --success-color: #10b981;
            --text-dark: #1f2937;
            --text-light: #6b7280;
            --border-color: #e5e7eb;
            --bg-light: #f9fafb;
        }

        .checkout-step-indicator {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            flex: 1;
        }

        .checkout-step-indicator .step {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            background: var(--bg-light);
            color: var(--text-light);
            border: 2px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .checkout-step-indicator .step.completed {
            background: var(--success-color);
            color: white;
            border-color: var(--success-color);
        }

        .checkout-step-indicator .step.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 8px rgba(241, 90, 36, 0.1);
        }

        .checkout-step-indicator .step-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-dark);
            text-align: center;
        }

        .step-connector {
            flex: 0.3;
            height: 2px;
            background: var(--border-color);
            margin: 0 10px;
        }

        .confirm-card {
            background: white;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            overflow: hidden;
            transition: all 0.3s ease;
            animation: fadeInUp 0.5s ease;
        }

        .confirm-card:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-header-custom {
            background: var(--bg-light);
            padding: 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header-custom h5 {
            color: var(--text-dark);
            margin: 0;
            font-weight: 600;
        }

        .edit-link {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 4px;
            transition: all 0.3s ease;
        }

        .edit-link:hover {
            color: var(--secondary-color);
            gap: 8px;
        }

        .card-body {
            padding: 20px;
        }

        .card-footer-custom {
            padding: 20px;
            background: var(--bg-light);
            border-top: 1px solid var(--border-color);
        }

        .confirm-item {
            display: flex;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid var(--border-color);
            align-items: flex-start;
        }

        .confirm-item:last-child {
            border-bottom: none;
        }

        .item-image {
            flex-shrink: 0;
        }

        .item-details {
            flex: 1;
        }

        .item-details h6 {
            margin: 0;
            color: var(--text-dark);
            font-weight: 600;
        }

        .item-price {
            flex-shrink: 0;
            text-align: right;
            color: var(--primary-color);
            font-weight: 700;
            font-size: 16px;
        }

        .address-block {
            background: var(--bg-light);
            padding: 15px;
            border-radius: 8px;
            line-height: 1.8;
            color: var(--text-dark);
        }

        .address-block p {
            margin: 0;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            color: var(--text-light);
            font-size: 14px;
        }

        .summary-row strong {
            color: var(--text-dark);
        }

        .summary-divider {
            height: 1px;
            background: var(--border-color);
            margin: 12px 0;
        }

        .summary-row-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            font-size: 18px;
            font-weight: 700;
            color: var(--text-dark);
            border-top: 1px solid var(--border-color);
            padding-top: 15px;
        }

        .summary-row-total span:last-child {
            color: var(--primary-color);
            font-size: 20px;
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success-color), #059669);
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #059669, var(--success-color));
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
        }

        .btn-success::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: white;
            opacity: 0.1;
            transition: left 0.3s ease;
        }

        .btn-success:hover::before {
            left: 100%;
        }

        .btn-outline-secondary {
            color: var(--text-dark);
            border-color: var(--border-color);
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline-secondary:hover {
            background: var(--bg-light);
            border-color: var(--text-dark);
            color: var(--text-dark);
        }

        .security-info {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 15px;
            text-align: center;
        }

        .security-info p {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .security-info small {
            color: var(--text-light);
        }

        @media (max-width: 768px) {
            .checkout-step-indicator {
                margin-bottom: 15px;
            }

            .step-connector {
                display: none;
            }

            .confirm-card.sticky-top {
                position: static !important;
            }

            .confirm-item {
                flex-direction: column;
                gap: 10px;
            }

            .item-image {
                width: 100%;
            }

            .item-price {
                text-align: left;
            }
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('saveCustomerBtn').addEventListener('click', function() {
            const firstName = document.querySelector('.edit-first-name').value;
            const lastName = document.querySelector('.edit-last-name').value;
            const email = document.querySelector('.edit-email').value;
            const phone = document.querySelector('.edit-phone').value;

            if (!firstName || !lastName || !email || !phone) {
                alert('Veuillez remplir tous les champs');
                return;
            }

            document.querySelector('input[name="first_name"]').value = firstName;
            document.querySelector('input[name="last_name"]').value = lastName;
            document.querySelector('input[name="email"]').value = email;
            document.querySelector('input[name="phone"]').value = phone;

            // Update display
            location.reload();
        });

        document.getElementById('saveAddressBtn').addEventListener('click', function() {
            const address = document.querySelector('.edit-address').value;
            const city = document.querySelector('.edit-city').value;
            const postalCode = document.querySelector('.edit-postal-code').value;
            const country = document.querySelector('.edit-country').value;

            if (!address || !city || !postalCode || !country) {
                alert('Veuillez remplir tous les champs');
                return;
            }

            document.querySelector('input[name="address"]').value = address;
            document.querySelector('input[name="city"]').value = city;
            document.querySelector('input[name="postal_code"]').value = postalCode;
            document.querySelector('input[name="country"]').value = country;

            // Update display
            location.reload();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('shop.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views/shop/confirm-checkout.blade.php ENDPATH**/ ?>