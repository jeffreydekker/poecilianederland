<x-layout>
    {{-- Table all registrations --}}
    <div class="container-xxl container--wide">
        <br>
        <h1 style="text-align:center; margin-top:0% "><strong>Overzicht registraties</strong></h1>
        <br>

        {{-- Search and export container --}}
        <div style="" class="container-sm">
            {{-- Search container --}}
            <div class="d-flex justify-content-between align-items-center" style="margin-bottom: 3px">
                {{-- Search Form --}}
                <div class="search-container">
                    <form action="{{ route('showTableAll') }}" method="GET">
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
                <table class="table table-hover" id="tableAll">
                    <thead>
                        <tr>
                            <th onclick="sortTableAllLidnr(0)"style="width: 70px"><strong>Lidnummer</strong></th>
                            <th onclick="sortAll(1)" style="width: 120px"><strong>Geslachtsnaam</strong></th>
                            <th onclick="sortAll(2)"style="width: 125px"><strong>Soortnaam</strong></th>
                            <th onclick="sortAll(3)"style="width: 125px"><strong>Ondersoort</strong></th>
                            <th onclick="sortAll(4)"style="width: 200px"><strong>Vangplaats</strong></th>
                            <th onclick="sortAll(5)"style="width: 40px"><strong>AS</strong></th>
                            <th onclick="sortAll(6)"style="width: 40px"><strong>KV</strong></th>
                            <th onclick="sortAll(7)"style="width: 40px"><strong>NB</strong></th>
                            <th onclick="sortAll(8)" style="width: 40px; text-align:center"><strong><i class="fa-solid fa-circle-question"></i></strong></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($registraties as $registratie)
                        <tr>
                            <td>@if ($registratie->gebruiker)<a href="mailto:{{ $registratie->gebruiker->email }}">{{ $registratie->gebruiker->lidnummer }}</a>@endif</td>
                            <td>{{ $registratie->geslachtsnaam }}</td>
                            <td>{{ $registratie->soortnaam }}</td>
                            <td>{{ $registratie->ondersoort }}</td>
                            <td>{{ $registratie->vangplaats }}</td>
                            <td>{{ $registratie->AS }}</td>
                            <td>{{ $registratie->KV }}</td>
                            <td>{{ $registratie->jongen }}</td>
                            <td style="text-align:center">
                                @if($registratie->notitie != NULL)
                                <div class="tooltip-container">
                                    <i class="fa-solid fa-circle-question"></i>
                                    <span class="tooltip-text">{{ $registratie->notitie }}</span>
                                </div>
                                @else
                                <span>-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div style="text-align: right; color:black" class="d-flex justify-content-end">
                    {{ $registraties->appends(request()->all())->links() }}
                </div>
            </div>
        </div>
    </div>
    <br>

</x-layout>
