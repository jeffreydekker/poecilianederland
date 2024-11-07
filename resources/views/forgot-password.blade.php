<x-layout>
    <div class="container py-md-5 mt-5 mx-auto" style="max-width: 500px;">
        <div class="card shadow-sm p-4">
            <h3 class="text-center mb-4">Wachtwoord Resetten</h3>
            <p class="text-center">We zullen een link naar uw e-mailadres sturen. Gebruik deze link om het wachtwoord te resetten.</p>
            <form action="/forgot-password-post" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">E-mailadres</label>
                    <input type="email" class="form-control" name="email" id="email" required>
                </div>
                @error('email')
                <p class="m-0 small alert alert-danger shadow-sm">{{ $message }}</p>
                @enderror
                <div class="d-grid mt-3">
                    <button type="submit" class="btn btn-primary">Reset link aanvragen</button>
                </div>
            </form>
        </div>
    </div>
</x-layout>