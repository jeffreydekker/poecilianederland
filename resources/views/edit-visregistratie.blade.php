<x-layout>
    <div class="container py-md-5 container--narrow">
        <h1 class="text-center"><strong>Registratie Wijzigen</strong></h1>

        <form action="/registratie/{{$registratie->id}}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">

                <!-- Geslachtsnaam -->
                <label for="geslachtsnaam"><strong>Geslachtsnaam</strong></label>
                <select name="geslachtsnaam" id="geslachtsnaam" class="form-control mb-2" style="width: 100%">
                    <option value="{{ old('geslachtsnaam', $registratie->geslachtsnaam) }}" selected>{{ $registratie->geslachtsnaam }}</option>
                    @foreach ($all as $row)
                        @if ($row->geslachtsnaam && $row->geslachtsnaam != $registratie->geslachtsnaam)
                            <option value="{{ $row->geslachtsnaam }}">{{ $row->geslachtsnaam }}</option>
                        @endif
                    @endforeach
                </select>
                @error('geslachtsnaam')
                    <p class="small alert alert-danger shadow-sm">{{ $message }}</p>
                @enderror

                <!-- Soortnaam -->
                <label for="soortnaam"><strong>Soortnaam</strong></label>
                <select name="soortnaam" id="soortnaam" class="form-control mb-2" style="width: 100%">
                    <option value="{{ old('soortnaam', $registratie->soortnaam) }}" selected>{{ $registratie->soortnaam }}</option>
                    @foreach ($all as $row)
                        @if ($row->soortnaam && $row->soortnaam != $registratie->soortnaam)
                            <option value="{{ $row->soortnaam }}">{{ $row->soortnaam }}</option>
                        @endif
                    @endforeach
                </select>
                @error('soortnaam')
                    <p class="small alert alert-danger shadow-sm">{{ $message }}</p>
                @enderror

                <!-- Ondersoort -->
                <label for="ondersoort"><strong>Ondersoort</strong></label>
                <select name="ondersoort" id="ondersoort" class="form-control mb-2" style="width: 100%">
                    <option value="{{ old('ondersoort', $registratie->ondersoort) }}" selected>{{ $registratie->ondersoort }}</option>
                    @foreach ($all as $row)
                        @if ($row->ondersoort && $row->ondersoort != $registratie->ondersoort)
                            <option value="{{ $row->ondersoort }}">{{ $row->ondersoort }}</option>
                        @endif
                    @endforeach
                </select>
                @error('ondersoort')
                    <p class="small alert alert-danger shadow-sm">{{ $message }}</p>
                @enderror

                <!-- Vangplaats -->
                <label for="vangplaats"><strong>Vangplaats</strong></label>
                <select name="vangplaats" id="vangplaats" class="form-control mb-2" style="width: 100%">
                    <option value="{{ old('vangplaats', $registratie->vangplaats) }}" selected>{{ $registratie->vangplaats }}</option>
                    @foreach ($all as $row)
                        @if ($row->vangplaats && $row->vangplaats != $registratie->vangplaats)
                            <option value="{{ $row->vangplaats }}">{{ $row->vangplaats }}</option>
                        @endif
                    @endforeach
                </select>
                @error('vangplaats')
                    <p class="small alert alert-danger shadow-sm">{{ $message }}</p>
                @enderror

                <!-- Radio Options -->
                @php
                    $fields = [
                        'AS' => 'Aquariumstam',
                        'KV' => 'Kweekvorm',
                        'jongen' => 'Nakweek Beschikbaar'
                    ];
                @endphp

                @foreach ($fields as $field => $label)
                    <fieldset class="mt-3">
                        <strong>{{ $label }}</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="{{ $field }}Ja" name="{{ $field }}" value="Ja" {{ $registratie->$field == 'Ja' ? 'checked' : '' }}>
                            <label class="form-check-label" for="{{ $field }}Ja">Ja</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="{{ $field }}Nee" name="{{ $field }}" value="Nee" {{ $registratie->$field == 'Nee' ? 'checked' : '' }}>
                            <label class="form-check-label" for="{{ $field }}Nee">Nee</label>
                        </div>
                        @error($field)
                            <p class="small alert alert-danger shadow-sm">{{ $message }}</p>
                        @enderror
                    </fieldset>
                @endforeach

                <!-- Notitie -->
                <label for="notitie" class="text-muted mt-4 mb-2"><small><strong>Notitie</strong></small></label>
                <textarea name="notitie" id="notitie" class="form-control" maxlength="100" rows="4">{{ old('notitie', $registratie->notitie) }}</textarea>
                @error('notitie')
                    <p class="small alert alert-danger shadow-sm">{{ $message }}</p>
                @enderror

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary w-100">Wijzigen</button>
                </div>

                <p class="mt-4 text-center text-muted small">
                    <strong>Let op:</strong> Staan de gewenste opties niet in de dropdownmenu's? Neem contact op met een beheerder.
                </p>
            </div>
        </form>
    </div>
</x-layout>
