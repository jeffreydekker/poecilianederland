<x-layout>

  <div class="container-xxl  container--wide">
    <br>
    <h1 style="text-align:center; margin-top:0%"><strong>{{$username}}</strong></h1>
    <br>

    {{-- Table user registrations --}}
    <div style="" class="container-sm">
      <div style="margin-bottom: 3px" class="d-flex justify-content-between align-items-center">
          {{-- Search and import options --}}
          <div style="display: inline-block" class="search-container">
              <form action="{{ route('profiel', ['user' => $user->lidnummer]) }}" method="GET">
                  <input type="text" name="search" value="{{ request()->input('search') }}" placeholder="Zoeken">
                  <button type="submit"><i class="fas fa-search"></i></button>
              </form>
          </div>

          {{-- Export buttons --}}
          <div class="export-table" style="display: inline-block; font-family: Arial, sans-serif;">
            <span style="margin-right: 10px; font-weight: bold; color: #333;">Exporteer opties</span>
            <button type="button" id="btnXlsx" class="export-btn">XLSX</button>
            <button type="button" id="btnXls" class="export-btn">XLS</button>
            <button type="button" id="btnCsv" class="export-btn">CSV</button>
        </div>
      </div>

      <div>
        <table class="table table-hover" id="tableUser" style="cursor: pointer">
          <thead>
            <tr>
              <th onclick="sortTableUser(0)"style="width: 70px"><strong>Aangemaakt</strong></th>
              <th onclick="sortTableUser(1)" style="width: 100px"><strong>Geslachtsnaam</strong></th>
              <th onclick="sortTableUser(2)"style="width: 150px"><strong>Soortnaam</strong></th>
              <th onclick="sortTableUser(3)"style="width: 150px"><strong>Ondersoort</strong></th>
              <th onclick="sortTableUser(4)"style="width: 150px"><strong>Vangplaats</strong></th>
              <th onclick="sortTableUser(5)"style="width: 40px"><strong>AS</strong></th>
              <th onclick="sortTableUser(6)"style="width: 40px"><strong>KV</strong></th>
              <th onclick="sortTableUser(7)"style="width: 40px"><strong>NB</strong></th>
              <th onclick="sortTableUser(8)" style="width: 10px; text-align:center"><strong><i class="fa-solid fa-circle-question"></i></strong></th>
              <th style="width: 40px"><strong><i style="color:white; text-align:center; align-items:center" class="fas fa-trash center"></i></strong></th>
            </tr>
          </thead>

      @foreach ($registraties as $registratie)
        <tr class="clickable-row" data-href="{{ route('registratie.show', $registratie->id) }}">
          <td>{{ $registratie->created_at->format('d-m-Y') }}</td>
          <td>{{ $registratie->geslachtsnaam }}</td>
          <td>{{ $registratie->soortnaam }}</td>
          <td>{{ $registratie->ondersoort }}</td>
          <td>{{ $registratie->vangplaats }}</td>
          <td>{{ $registratie->AS }}</td>
          <td>{{ $registratie->KV }}</td>
          <td>{{ $registratie->jongen }}</td>
          <td style="text-align: center">
            @if($registratie->notitie != NULL)
            <div class="tooltip-container">
                <i class="fa-solid fa-circle-question"></i>
                <span class="tooltip-text">{{ $registratie->notitie }}</span>
            </div>
            @else
            <span>-</span>
            @endif
          </td>
          @can('delete', $registratie)
          <td style="text-align:center; vertical-align:middle">            
            <form class="delete-post-form d-inline" action="/registratie/{{ $registratie->id }}" method="POST">
              @csrf
              @method('DELETE')
              <button class="delete-post-button text-danger" data-toggle="tooltip" data-placement="top" title="Verwijderen"><i style="color:red" class="fas fa-trash"></i></button>
            </form>
          </td>
          @endcan
        </tr>
        @endforeach
      </table>
    
      {{-- pagination: --}}
      <div style="text-align: right; color:black" class="d-flex justify-content-end">
        {{ $registraties->appends(request()->all())->links() }}
      </div>
    </div>
  
</x-layout>