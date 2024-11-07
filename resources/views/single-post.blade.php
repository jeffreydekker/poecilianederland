<x-layout>
    <div class="container py-md-5 container--narrow">
        <div class="card border-0 shadow-sm">
            <div style="background-color: #555" class="card-header text-white d-flex justify-content-between align-items-center">
                <h2 class="m-0">{{ $registratie->geslachtsnaam . " " . $registratie->soortnaam }}</h2>
                @can('update', $registratie)
                <span>
                    <a href="/registratie-wijzigen/{{$registratie->id}}/wijzigen" class="text-white me-3" data-toggle="tooltip" data-placement="top" title="Wijzigen">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form class="delete-post-form d-inline" action="/registratie/{{$registratie->id}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-link text-white p-0" data-toggle="tooltip" data-placement="top" title="Verwijderen">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </span>
                @endcan
            </div>

            <div class="card-body">
                <ul class="list-unstyled">
                    <li style="line-height:40px"><strong>Geslachtsnaam:</strong> {{ $registratie->geslachtsnaam }}</li>
                    <li style="line-height:40px"><strong>Soortnaam:</strong> {{ $registratie->soortnaam }}</li>
                    <li style="line-height:40px"><strong>Ondersoort:</strong> {{ $registratie->ondersoort }}</li>
                    <li style="line-height:40px"><strong>Vangplaats:</strong> {{ $registratie->vangplaats }}</li>
                    <li style="line-height:40px"><strong>Aquariumstam:</strong> {{ $registratie->AS }}</li>
                    <li style="line-height:40px"><strong>Kweekvorm:</strong> {{ $registratie->KV }}</li>
                    <li style="line-height:40px"><strong>Nakweek beschikbaar:</strong> {{ $registratie->jongen }}</li>
                    <li style="line-height:40px; margin-bottom:0px"><strong>Notitie:</strong> {{ $registratie->notitie }}</li>
                </ul>
            </div>

            <div class="card-footer text-muted small">
                Aangemaakt door <a href="#">{{ $registratie->gebruiker->lidnummer }}</a> op {{ $registratie->created_at->format('d-m-Y') }}
            </div>
        </div>
    </div>
</x-layout>
