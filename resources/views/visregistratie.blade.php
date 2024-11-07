<x-layout>

    <div class="container py-md-5 container--narrow">
      <h1 class="text-center"><strong>Visregistratie</strong></h1>
      
      <form action="/registratie-opslaan" method="POST">
        @csrf
        <div class="form-group">
          
          <label for="geslachtsnaam"><strong>Geslachtsnaam</strong></label>
          <select name="geslachtsnaam" id="geslachtsnaam" class="form-control mb-2" style="width: 100%">
            <option value="" disabled {{ old('geslachtsnaam') ? '' : 'selected' }}>---Selecteer een optie---</option>
            @foreach ($all as $row)
              @if ($row->geslachtsnaam != NULL)
                <option value="{{ $row->geslachtsnaam }}" {{ old('geslachtsnaam') == $row->geslachtsnaam ? 'selected' : '' }}>
                  {{ $row->geslachtsnaam }}
                </option>
              @endif
            @endforeach  
          </select>
          @error('geslachtsnaam')
            <p class="small alert alert-danger shadow-sm">{{ $message }}</p>
          @enderror
          
          <label for="soortnaam"><strong>Soortnaam</strong></label>
          <select name="soortnaam" id="soortnaam" class="form-control mb-2" style="width: 100%">
            <option value="" disabled {{ old('soortnaam') ? '' : 'selected' }}>---Selecteer een optie---</option>
            @foreach ($soortnamen as $row)
              @if ($row->soortnaam != NULL)
                <option value="{{ $row->soortnaam }}" {{ old('soortnaam') == $row->soortnaam ? 'selected' : '' }}>
                  {{ $row->soortnaam }}
                </option>
              @endif
            @endforeach  
          </select>
          @error('soortnaam')
            <p class="small alert alert-danger shadow-sm">{{ $message }}</p>
          @enderror
          
          <label for="ondersoort"><strong>Ondersoort</strong></label>
          <select name="ondersoort" id="ondersoort" class="form-control mb-2" style="width: 100%">
            <option value="" disabled {{ old('ondersoort') ? '' : 'selected' }}>---Selecteer een optie---</option>
            @foreach ($ondersoorten as $row)
              @if ($row->ondersoort != NULL)
                <option value="{{ $row->ondersoort }}" {{ old('ondersoort') == $row->ondersoort ? 'selected' : '' }}>
                  {{ $row->ondersoort }}
                </option>
              @endif
            @endforeach  
          </select>
          @error('ondersoort')
            <p class="small alert alert-danger shadow-sm">{{ $message }}</p>
          @enderror
          
          <label for="vangplaats"><strong>Vangplaats</strong></label>
          <select name="vangplaats" id="vangplaats" class="form-control mb-2" style="width: 100%">
            <option value="" disabled {{ old('vangplaats') ? '' : 'selected' }}>---Selecteer een optie---</option>
            @foreach ($vangplaatsen as $row)
              @if ($row->vangplaats != NULL)
                <option value="{{ $row->vangplaats }}" {{ old('vangplaats') == $row->vangplaats ? 'selected' : '' }}>
                  {{ $row->vangplaats }}
                </option>
              @endif
            @endforeach  
          </select>
          @error('vangplaats')
            <p class="small alert alert-danger shadow-sm">{{ $message }}</p>
          @enderror
  
          <fieldset class="mt-3">
            <strong>Aquariumstam</strong>
            <div class="form-check">
              <input class="form-check-input" type="radio" id="jaAS" name="AS" value="Ja" {{ old('AS') == 'Ja' ? 'checked' : '' }}>
              <label class="form-check-label" for="jaAS">Ja</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" id="neeAS" name="AS" value="Nee" {{ old('AS') == 'Nee' ? 'checked' : '' }}>
              <label class="form-check-label" for="neeAS">Nee</label>
            </div>
            @error('AS')
              <p class="small alert alert-danger shadow-sm">{{ $message }}</p>
            @enderror
          </fieldset>
  
          <fieldset class="mt-3">
            <strong>Kweekvorm</strong>
            <div class="form-check">
              <input class="form-check-input" type="radio" id="jaKV" name="KV" value="Ja" {{ old('KV') == 'Ja' ? 'checked' : '' }}>
              <label class="form-check-label" for="jaKV">Ja</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" id="neeKV" name="KV" value="Nee" {{ old('KV') == 'Nee' ? 'checked' : '' }}>
              <label class="form-check-label" for="neeKV">Nee</label>
            </div>
            @error('KV')
              <p class="small alert alert-danger shadow-sm">{{ $message }}</p>
            @enderror
          </fieldset>
  
          <fieldset class="mt-3">
            <strong>Nakweek beschikbaar</strong>
            <div class="form-check">
              <input class="form-check-input" type="radio" id="jongenJa" name="jongen" value="Ja" {{ old('jongen') == 'Ja' ? 'checked' : '' }}>
              <label class="form-check-label" for="jongenJa">Ja</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" id="jongenNee" name="jongen" value="Nee" {{ old('jongen') == 'Nee' ? 'checked' : '' }}>
              <label class="form-check-label" for="jongenNee">Nee</label>
            </div>
            @error('jongen')
              <p class="small alert alert-danger shadow-sm">{{ $message }}</p>
            @enderror
          </fieldset>
  
          <label for="notitie" class="text-muted mt-4 mb-2"><small><strong>Notitie</strong></small></label>
          <textarea name="notitie" id="notitie" class="form-control" maxlength="100" placeholder="..." autocomplete="off">{{ old('notitie') }}</textarea>
          @error('notitie')
            <p class="small alert alert-danger shadow-sm">{{ $message }}</p>
          @enderror
  
          <div class="mt-4">
            <button class="btn btn-primary">Opslaan</button>
          </div>
  
          <p class="mt-4"><small><strong>Let op:</strong> staan de gewenste opties uit de dropdown menu's er niet tussen? Neem dan contact op met een van de beheerders.</small></p>
        </div>
      </form>
    </div>
  
  </x-layout>
  