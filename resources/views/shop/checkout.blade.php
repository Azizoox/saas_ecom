@extends('shop.layouts.app')

@section('title', 'Commande - ' . ($shop->name ?? 'Ma Boutique'))

@section('content')
    
    <div class="container my-5">
        <h1 class="mb-4">Finaliser ma commande</h1>
        <p class="mb-4 text-muted">Connecté en tant que {{ auth()->user()->name ?? 'Invité' }}</p>
       
        
        <div class="row">
            <div class="col-lg-8">
                <div class="checkout-form">
                    <!-- Contact Information Section -->
                    <div class="form-section mb-5">
                        <h4 class="mb-4 pb-3 border-bottom"><i class="bi bi-person-circle me-2"></i>Informations de contact</h4>
                        
                        <form id="checkoutForm" action="{{ route('shop.confirm-checkout', ['subdomain' => $shop->subdomain ?? request()->route('subdomain', '')]) }}" method="POST">
                        @csrf
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="first_name" class="form-label">Prénom *</label>
                                <input type="text" class="form-control" id="first_name" name="first_name"  required value="{{ auth()->user()->first_name ?? '' }}">

                            </div>
                            <div class="col-md-6">
                                <label for="last_name" class="form-label">Nom *</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" required value="{{ auth()->user()->last_name ?? '' }}">
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" class="form-control" id="email" name="email" required value="{{ auth()->user()->email ?? '' }}">
                        </div>
                        
                        <div class="mb-4">
                            <label for="phone" class="form-label">Téléphone *</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required value="{{ auth()->user()->phone ?? '' }}">
                        </div>
                        
                        <h4 class="mb-4 mt-5 pb-3 border-bottom"><i class="bi bi-geo-alt me-2"></i>Adresse de livraison</h4>
                        
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
                            <h4 class="mb-4 pb-3 border-bottom"><i class="bi bi-credit-card me-2"></i>Adresse de facturation</h4>
                            
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
                        
                        <div class="mt-5 pt-4 border-top">
                            <button type="submit" class="btn btn-primary btn-lg w-100 py-3">
                                <i class="bi bi-arrow-right me-2"></i>Continuer vers la confirmation
                            </button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="checkout-form sticky-top" style="top: 20px;">
                    <h4 class="mb-4 pb-3 border-bottom"><i class="bi bi-bag-check me-2"></i>Récapitulatif de la commande</h4>
                    
                    <div class="products-section mb-4">
                        @foreach($cartItems as $item)
                        <div class="summary-item p-3 mb-3 border rounded" style="background-color: #f8f9fa;">
                            <div class="row g-3 align-items-center">
                                <div class="col-4">
                                    @if($item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="img-fluid rounded" style="object-fit: cover; height: 80px; width: 100%;">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 80px;">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-8">
                                    <strong class="d-block mb-1">{{ $item->product->name }}</strong>
                                    <small class="text-muted d-block">{{ $item->quantity }} x {{ number_format($item->product->price, 2, ',', ' ') }} TND</small>
                                    <strong class="text-primary d-block mt-2">{{ number_format($item->product->price * $item->quantity, 2, ',', ' ') }} TND</strong>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <hr class="my-3">
                    
                    <div class="pricing-section">
                        <div class="d-flex justify-content-between mb-3">
                            <span>Sous-total</span>
                            <strong>{{ number_format($subtotal, 2, ',', ' ') }} TND</strong>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                            <span>Frais de livraison</span>
                            <strong>{{ number_format($shippingCost, 2, ',', ' ') }} TND</strong>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center" style="font-size: 1.25rem;">
                            <span class="fw-bold">Total</span>
                            <span class="fw-bold text-primary" style="font-size: 1.5rem;">{{ number_format($totalPrice, 2, ',', ' ') }} TND</span>
                        </div>
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