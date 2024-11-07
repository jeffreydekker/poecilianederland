<x-layout>
    <div class="container mt-5">
        <h1 class="mb-4" style="text-align:center;margin-top:0% "><strong>Profiel instellingen</strong></h1>
    
        
        <!-- Update Name -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Naam Veranderen</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.update.name') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Naam</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->naam) }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Veranderen</button>
                </form>
            </div>
        </div>

        <!-- Update Last Name (Achternaam) -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Achternaam Veranderen</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.update.achternaam') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="achternaam">Achternaam</label>
                        <input 
                            type="text" 
                            name="achternaam" 
                            class="form-control @error('achternaam') is-invalid @enderror" 
                            value="{{ old('achternaam', $user->achternaam) }}" 
                            required
                        >
                        <!-- Display Error Message -->
                        @error('achternaam')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Veranderen</button>
                </form>
            </div>
        </div>

        <!-- Update Email -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Email Veranderen</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.update.email') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Veranderen</button>
                </form>
            </div>
        </div>

        <!-- Update Password -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Wachtwoord Veranderen</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.update.password') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="current_password">Huidig Wachtwoord</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Nieuw Wachtwoord</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Nieuw Wachtwoord Herhalen</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Veranderen</button>
                </form>
            </div>
        </div>

        <!-- Delete Account -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0 text-danger">Account Verwijderen</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.delete.account') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Weet u zeker dat u uw account wilt verwijderen? Al uw registraties zullen verloren gaan.')">Account Verwijderen</button>
                </form>
            </div>
        </div>
    </div>
</x-layout>
