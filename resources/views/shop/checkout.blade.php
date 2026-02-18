@extends('shop.layouts.app')

@section('title', 'Commande - ' . ($shop->name ?? 'Ma Boutique'))

@section('content')
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #1e40af;
            --accent-color: #f59e0b;
            --text-dark: #1f2937;
            --text-light: #6b7280;
            --border-color: #e5e7eb;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-dark);
            background-color: #f9fafb;
        }

        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .checkout-steps {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2rem;
            position: relative;
        }

        .checkout-steps::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--border-color);
            z-index: 1;
        }

        .step {
            text-align: center;
            position: relative;
            z-index: 2;
        }

        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: white;
            border: 2px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.5rem;
            font-weight: bold;
        }

        .step.active .step-number {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .step.completed .step-number {
            background: var(--success-color, #10b981);
            color: white;
            border-color: var(--success-color, #10b981);
        }

        .step-label {
            font-size: 0.85rem;
            color: var(--text-light);
        }

        .step.active .step-label,
        .step.completed .step-label {
            color: var(--primary-color);
            font-weight: 600;
        }

        .checkout-form {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid var(--border-color);
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            padding: 1rem 0;
            font-weight: bold;
            font-size: 1.1rem;
            border-top: 2px solid var(--border-color);
        }

        .payment-method {
            border: 2px solid transparent;
            border-radius: 10px;
            padding: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .payment-method.selected {
            border-color: var(--primary-color);
            background: rgba(var(--primary-color-rgb, 37, 99, 235), 0.05);
        }

        .payment-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--border-color);
            border-radius: 8px;
            margin-right: 1rem;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
   

    <div class="container my-5">
        <h1 class="mb-4">Finaliser ma commande</h1>
        
        <!-- Checkout Steps -->
        <div class="checkout-steps mb-5">
            <div class="step completed">
                <div class="step-number">1</div>
                <div class="step-label">Panier</div>
            </div>
            <div class="step active">
                <div class="step-number">2</div>
                <div class="step-label">Commande</div>
            </div>
            <div class="step">
                <div class="step-number">3</div>
                <div class="step-label">Paiement</div>
            </div>
            <div class="step">
                <div class="step-number">4</div>
                <div class="step-label">Confirmation</div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-8">
                <div class="checkout-form">
                    <h4 class="mb-4">Informations de contact</h4>
                    
                    <form id="checkoutForm" action="{{ route('shop.process-order', ['subdomain' => $shop->subdomain ?? request()->route('subdomain', '')]) }}" method="POST">
                        @csrf
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="first_name" class="form-label">Prénom *</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="last_name" class="form-label">Nom *</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" required>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="phone" class="form-label">Téléphone *</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                        </div>
                        
                        <h4 class="mb-4 mt-5">Adresse de livraison</h4>
                        
                        <div class="mb-4">
                            <label for="address" class="form-label">Adresse *</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="city" class="form-label">Ville *</label>
                                <input type="text" class="form-control" id="city" name="city" required>
                            </div>
                            <div class="col-md-3">
                                <label for="postal_code" class="form-label">Code postal *</label>
                                <input type="text" class="form-control" id="postal_code" name="postal_code" required>
                            </div>
                            {{-- <div class="col-md-3">
                                <label for="country" class="form-label">Gouvernorat </label>
                                <input type="text" class="form-control" id="country" name="country" value="France" required>
                            </div> --}}
                            <div class="col-md-3">
    <label for="governorate" class="form-label">Gouvernorat</label>

    <select class="form-select" id="governorate" name="country" required>
        <option value="">-- Sélectionner un gouvernorat --</option>

        <option value="Ariana">Ariana</option>
        <option value="Béja">Béja</option>
        <option value="Ben Arous">Ben Arous</option>
        <option value="Bizerte">Bizerte</option>
        <option value="Gabès">Gabès</option>
        <option value="Gafsa">Gafsa</option>
        <option value="Jendouba">Jendouba</option>
        <option value="Kairouan">Kairouan</option>
        <option value="Kasserine">Kasserine</option>
        <option value="Kébili">Kébili</option>
        <option value="Le Kef">Le Kef</option>
        <option value="Mahdia">Mahdia</option>
        <option value="La Manouba">La Manouba</option>
        <option value="Médenine">Médenine</option>
        <option value="Monastir">Monastir</option>
        <option value="Nabeul">Nabeul</option>
        <option value="Sfax">Sfax</option>
        <option value="Sidi Bouzid">Sidi Bouzid</option>
        <option value="Siliana">Siliana</option>
        <option value="Sousse">Sousse</option>
        <option value="Tataouine">Tataouine</option>
        <option value="Tozeur">Tozeur</option>
        <option value="Tunis">Tunis</option>
        <option value="Zaghouan">Zaghouan</option>
    </select>
</div>

                        </div>
                        
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="same_address">
                            <label class="form-check-label" for="same_address">
                                Utiliser la même adresse pour la facturation
                            </label>
                        </div>
                        
                        <div id="billing_address" class="d-none">
                            <h4 class="mb-4">Adresse de facturation</h4>
                            
                            <div class="mb-4">
                                <label for="billing_address" class="form-label">Adresse *</label>
                                <input type="text" class="form-control" id="billing_address" name="billing_address">
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="billing_city" class="form-label">Ville *</label>
                                    <input type="text" class="form-control" id="billing_city" name="billing_city">
                                </div>
                                <div class="col-md-3">
                                    <label for="billing_postal_code" class="form-label">Code postal *</label>
                                    <input type="text" class="form-control" id="billing_postal_code" name="billing_postal_code">
                                </div>
                                <div class="col-md-3">
                                    <label for="billing_country" class="form-label">Pays *</label>
                                    <input type="text" class="form-control" id="billing_country" name="billing_country" value="France">
                                </div>
                            </div>
                        </div>
                        
                      
                        
                        <input type="hidden" name="payment_method" id="selected_payment_method" value="card">
                        
                        
                        
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-lock me-2"></i>Procéder au paiement - {{ number_format($totalPrice, 2, ',', ' ') }} TND
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="checkout-form">
                    <h4 class="mb-4">Récapitulatif de la commande</h4>
                    
                    @foreach($cartItems as $item)
                    <div class="summary-item">
                        <div>
                            <strong>{{ $item->product->name }}</strong>
                            <br>
                            <small class="text-muted">{{ $item->quantity }} x {{ number_format($item->product->price, 2, ',', ' ') }} TND</small>
                        </div>
                        <div class="text-end">
                            {{ number_format($item->product->price * $item->quantity, 2, ',', ' ') }} TND
                        </div>
                    </div>
                    @endforeach
                    
                    <div class="summary-item">
                        <span>Sous-total</span>
                        <span>{{ number_format($subtotal, 2, ',', ' ') }} TND</span>
                    </div>
                    
                    <div class="summary-item">
                        <span>Frais de livraison</span>
                        <span>{{ number_format($shippingCost, 2, ',', ' ') }} TND</span>
                    </div>
                    
                    <div class="summary-total">
                        <span>Total</span>
                        <span>{{ number_format($totalPrice, 2, ',', ' ') }} TND</span>
                    </div>
                </div>
                
                
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Payment method selection
        document.querySelectorAll('.payment-method').forEach(method => {
            method.addEventListener('click', function() {
                // Remove selected class from all methods
                document.querySelectorAll('.payment-method').forEach(m => {
                    m.classList.remove('selected');
                });
                
                // Add selected class to clicked method
                this.classList.add('selected');
                
                // Update hidden input
                const paymentMethod = this.dataset.method;
                document.getElementById('selected_payment_method').value = paymentMethod;
            });
        });

        // Same address checkbox
        document.getElementById('same_address').addEventListener('change', function() {
            const billingSection = document.getElementById('billing_address');
            if(this.checked) {
                billingSection.classList.add('d-none');
                
                // Copy shipping address to billing
                document.getElementById('billing_address').value = document.getElementById('address').value;
                document.getElementById('billing_city').value = document.getElementById('city').value;
                document.getElementById('billing_postal_code').value = document.getElementById('postal_code').value;
                document.getElementById('billing_country').value = document.getElementById('country').value;
            } else {
                billingSection.classList.remove('d-none');
            }
        });

        // Form submission
        document.getElementById('checkoutForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Basic validation
            const firstName = document.getElementById('first_name').value;
            const lastName = document.getElementById('last_name').value;
            const email = document.getElementById('email').value;
            const phone = document.getElementById('phone').value;
            const address = document.getElementById('address').value;
            const city = document.getElementById('city').value;
            const postalCode = document.getElementById('postal_code').value;
            
            if(!firstName || !lastName || !email || !phone || !address || !city || !postalCode) {
                alert('Veuillez remplir tous les champs obligatoires.');
                return;
            }
            
            // Submit the form
            this.submit();
        });
    </script>
@endsection