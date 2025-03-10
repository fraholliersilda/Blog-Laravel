<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Key Purchase Success</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-success text-white">
                        <h3 class="mb-0">Payment Successful!</h3>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                            <h4 class="mt-3">Thank you for your purchase</h4>
                            <p>Your API key has been generated successfully.</p>
                        </div>

                        <div class="alert alert-warning">
                            <strong>Important:</strong> Please save your API key now. For security reasons, we won't be able to display it again.
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Your API Key:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" value="{{ $apiKey }}" id="apiKeyField" readonly>
                                <button class="btn btn-outline-secondary" type="button" id="copyButton">Copy</button>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h5>How to use your API key</h5>
                            <p>Include your API key in the request header:</p>
                            <pre class="bg-light p-3 rounded"><code>Authorization: Bearer {{ $apiKey }}</code></pre>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <a href="{{ route('api-keys.purchase') }}" class="btn btn-primary">Return to Purchase Page</a>
                            <div class="card mt-3">
                                <div class="card-body">
                                    <h5 class="card-title">Want to manage your API key?</h5>
                                    <p class="card-text">Create an account to keep track of your API usage, update your credentials, and purchase additional keys.</p>
                                    <div class="d-grid">
                                        <a href="{{ route('register') }}" class="btn btn-outline-primary">Create an Account</a>
                                    </div>
                                    <p class="text-muted small mt-2">Already have an account? <a href="{{ route('login') }}">Log in</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('copyButton').addEventListener('click', function() {
            var apiKeyField = document.getElementById('apiKeyField');
            apiKeyField.select();
            document.execCommand('copy');
            this.innerHTML = 'Copied!';
            setTimeout(() => {
                this.innerHTML = 'Copy';
            }, 2000);
        });
    </script>
</body>
</html>
