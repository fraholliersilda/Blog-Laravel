<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Purchase API Key</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Purchase API Key</h3>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="mb-4">
                            <h5>Access our API Services</h5>
                            <p>Get instant access to our powerful API with a unique API key. No account required!</p>

                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">API Key Features</h5>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">Unlimited API calls</li>
                                        <li class="list-group-item">Access to all endpoints</li>
                                        <li class="list-group-item">24/7 technical support</li>
                                        <li class="list-group-item">API documentation</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Basic Plan</h5>
                                        <h2 class="my-3">$19.99</h2>
                                        <p class="card-text">Monthly subscription</p>
                                        <ul class="list-unstyled text-start mb-4">
                                            <li><i class="bi bi-check-circle-fill text-success me-2"></i> 1,000 requests/day</li>
                                            <li><i class="bi bi-check-circle-fill text-success me-2"></i> Basic support</li>
                                        </ul>
                                        <form action="{{ route('paypal.process') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="plan" value="basic">
                                            <input type="hidden" name="amount" value="19.99">
                                            <button type="submit" class="btn btn-primary">Purchase Now</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card h-100 border-primary">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Premium Plan</h5>
                                        <h2 class="my-3">$49.99</h2>
                                        <p class="card-text">Monthly subscription</p>
                                        <ul class="list-unstyled text-start mb-4">
                                            <li><i class="bi bi-check-circle-fill text-success me-2"></i> Unlimited requests</li>
                                            <li><i class="bi bi-check-circle-fill text-success me-2"></i> Priority support</li>
                                            <li><i class="bi bi-check-circle-fill text-success me-2"></i> Advanced features</li>
                                        </ul>
                                        <form action="{{ route('paypal.process') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="plan" value="premium">
                                            <input type="hidden" name="amount" value="49.99">
                                            <button type="submit" class="btn btn-primary">Purchase Now</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <p>Want to go back to login? <a href="{{ route('login') }}">Click here</a> </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
