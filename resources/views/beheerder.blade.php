<x-layout>
  <div class="container py-md-5 container--wide">
    <h1 style="text-align:center;margin-top:0% "><strong>Beheerder pagina</strong></h1>
    
    {{-- Nieuwe gebruiker toevoegen --}}
    <div class="mb-5">
      <h2 class="h4">Nieuwe gebruiker toevoegen</h2>
      <form action="/register" method="POST" class="border p-4 rounded shadow-sm">
        @csrf
        <div class="form-group">
          <label for="lidnummer" class="text-muted mb-1"><small>Lid nummer</small></label>
          <input name="lidnummer" id="lidnummer" class="form-control" value="{{ old('lidnummer') }}" autocomplete="on" />
          @error('lidnummer')
            <p class="m-0 small alert alert-danger shadow-sm">{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group">
          <label for="naam" class="text-muted mb-1"><small>Naam</small></label>
          <input name="naam" id="username-register" class="form-control" value="{{ old('naam') }}" autocomplete="on" />
          @error('naam')
            <p class="m-0 small alert alert-danger shadow-sm">{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group">
          <label for="achternaam" class="text-muted mb-1"><small>Achternaam</small></label>
          <input name="achternaam" id="achternaam" class="form-control" value="{{ old('achternaam') }}" autocomplete="on" />
          @error('achternaam')
            <p class="m-0 small alert alert-danger shadow-sm">{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group">
          <label for="email-register" class="text-muted mb-1"><small>Email</small></label>
          <input name="email" id="email-register" value="{{ old('email') }}" class="form-control" type="text" autocomplete="on" />
          @error('email')
            <p class="m-0 small alert alert-danger shadow-sm">{{ $message }}</p>
          @enderror
        </div>

        <button type="submit" class="btn btn-primary">Opslaan</button>
      </form>
    </div>

    {{-- Nieuwe visregistratie opties toevoegen voor gebruikers --}}
    <div class="mb-5">
      <h2 class="h4">Nieuwe opties toevoegen voor gebruikers</h2>
      <form action="/opties-opslaan" method="POST" class="border p-4 rounded shadow-sm">
        @csrf
        <div class="form-group">
          <label for="geslachtsnaam" class="text-muted mb-1"><small>Geslachtsnaam</small></label>
          <input type="text" name="geslachtsnaam" class="form-control" value="{{ old('geslachtsnaam') }}" autocomplete="off" />
          @error('geslachtsnaam')
            <p class="m-0 small alert alert-danger shadow-sm">{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group">
          <label for="soortnaam" class="text-muted mb-1"><small>Soortnaam</small></label>
          <input type="text" name="soortnaam" class="form-control" value="{{ old('soortnaam') }}" autocomplete="off" />
          @error('soortnaam')
            <p class="m-0 small alert alert-danger shadow-sm">{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group">
          <label for="ondersoort" class="text-muted mb-1"><small>Ondersoort</small></label>
          <input type="text" name="ondersoort" class="form-control" value="{{ old('ondersoort') }}" autocomplete="off" />
          @error('ondersoort')
            <p class="m-0 small alert alert-danger shadow-sm">{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group">
          <label for="vangplaats" class="text-muted mb-1"><small>Vangplaats</small></label>
          <input type="text" name="vangplaats" class="form-control" value="{{ old('vangplaats') }}" autocomplete="off" />
          @error('vangplaats')
            <p class="m-0 small alert alert-danger shadow-sm">{{ $message }}</p>
          @enderror
        </div>

        <button class="btn btn-primary">Opslaan</button>
      </form>
    </div>

    {{-- Lijst gebruikers --}}
    <div class="mb-5" id="gebruikers">
      <h2 class="h4">Lijst van gebruikers</h2>
      <table class="table table-striped table-bordered table-hover table-custom" id="tableModGebruikers">
        <thead>
          <tr>
            <th onclick="sortModUsers(0)"><strong>Lid sinds</strong></th>
            <th onclick="sortModUsers(1)"><strong>Lidnummer</strong></th>
            <th onclick="sortModUsers(2)"><strong>Email</strong></th>
            <th onclick="sortModUsers(3)"><strong>Volledige naam</strong></th>
            <th onclick="sortModUsers(4)"><strong>Registraties</strong></th>
            <th><strong><i class="fas fa-trash"></i></strong></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($users as $user)
          <tr>
            <td>{{ $user->created_at->format('d-m-Y') }}</td>
            <td><a href="mailto:{{ $user->email }}">{{ $user->lidnummer }}</a></td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->naam . " " . $user->achternaam }}</td>
            <td>{{ $user->registraties->count() }}</td>
            <td class="text-center">
              <form class="delete-post-form d-inline" action="/profiel/{{ $user->id }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="delete-post-button text-danger" data-toggle="tooltip" data-placement="top" title="Verwijderen">
                  <i class="fas fa-trash"></i>
                </button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      {{ $users->links() }}
    </div>

    {{-- Send email to all users
    <div class="mb-5">
      <h2 class="h4">Bulk Email</h2>
      <a href="mailto:@foreach ($users as $user) {{ $user->email }}, @endforeach" class="btn btn-secondary">Bulk email</a>
    </div> --}}

    {{-- Lijst opties --}}
    <div class="mb-5" id="opties">
      <h2 class="h4">Lijst van opties</h2>
      <table class="table table-striped table-bordered table-hover table-custom" id="tableModOptions">
        <thead>
          <tr>
            <th onclick="sortModOpties(0)"><strong>Geslachtsnaam</strong></th>
            <th onclick="sortModOpties(1)"><strong>Soortnaam</strong></th>
            <th onclick="sortModOpties(2)"><strong>Vangplaats</strong></th>
            <th onclick="sortModOpties(3)"><strong><i class="fas fa-trash"></i></strong></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($options as $option)
          <tr>
            <td>{{ $option->geslachtsnaam }}</td>
            <td>{{ $option->soortnaam }}</td>
            <td>{{ $option->vangplaats }}</td>
            <td class="text-center">
              <form class="delete-post-form d-inline" action="/option/{{ $option->id }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="delete-post-button text-danger" data-toggle="tooltip" data-placement="top" title="Verwijderen">
                  <i class="fas fa-trash"></i>
                </button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      {{ $options->links() }}
    </div>

    {{-- Lijst registraties --}}
    <div id="registraties">
      <h2 class="h4">Lijst van registraties</h2>
      <table class="table table-striped table-bordered table-hover table-custom" id="tableModRegistraties">
        <thead class="">
          <tr>
            <th onclick="sortModRegistraties(0)"><strong>Lidnummer</strong></th>
            <th onclick="sortModRegistraties(1)"><strong>Geslachtsnaam</strong></th>
            <th onclick="sortModRegistraties(2)"><strong>Soortnaam</strong></th>
            <th onclick="sortModRegistraties(3)"><strong>Vangplaats</strong></th>
            <th onclick="sortModRegistraties(4)"><strong>AS</strong></th>
            <th onclick="sortModRegistraties(5)"><strong>KV</strong></th>
            <th><i class="fas fa-trash"></i></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($registraties as $registratie)
          <tr>
            @if($registratie->gebruiker)
            <td>{{ $registratie->gebruiker->lidnummer }}</td>
            @endif
            <td>{{ $registratie->geslachtsnaam }}</td>
            <td>{{ $registratie->soortnaam }}</td>
            <td>{{ $registratie->vangplaats }}</td>
            <td>{{ $registratie->AS }}</td>
            <td>{{ $registratie->KV }}</td>
            <td class="text-center">
              @can('delete', $registratie)
              <form class="delete-post-form d-inline" action="/registratieviabeheerder/{{ $registratie->id }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="delete-post-button text-danger" data-toggle="tooltip" data-placement="top" title="Verwijderen">
                  <i class="fas fa-trash"></i>
                </button>
              </form>
              @endcan
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      {{ $registraties->links() }}
    </div>
  </div>
</x-layout>