<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Options;
use App\Models\Registratie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TableController extends Controller
{
    public function registratieFormulier() {
        $all = DB::table('options')
        ->orderByRaw('geslachtsnaam COLLATE utf8mb4_unicode_ci ASC')
        ->get();

        $soortnamen = DB::table('options')
        ->orderByRaw('soortnaam COLLATE utf8mb4_unicode_ci ASC')
        ->get();

        $ondersoorten = DB::table('options')
        ->orderByRaw('ondersoort COLLATE utf8mb4_unicode_ci ASC')
        ->get();

        $vangplaatsen = DB::table('options')
        ->orderByRaw('vangplaats COLLATE utf8mb4_unicode_ci ASC')
        ->get();

        return view('visregistratie', ['all' => $all, 'soortnamen' => $soortnamen, 'ondersoorten' => $ondersoorten, 'vangplaatsen' => $vangplaatsen]);
    }

    public function showTableAll(User $user, Registratie $registraties)
    {
        // Fetch registrations and enforce alphabetical sorting by 'geslachtsnaam'
        $registraties = Registratie::with('gebruiker')
            ->getQuery() // Reset any previous sorting
            ->orders = null;

        $registraties = Registratie::with('gebruiker')
            ->orderBy('geslachtsnaam', 'asc')
            ->paginate(5);

            dd(
                Registratie::with('gebruiker')->orderBy('geslachtsnaam', 'asc')->toSql()
            );

        return view('table-all', [
            'registraties' => $registraties
        ]);
    }

    public function profiel(User $user, Registratie $registratie) {
        return view('table-user', [
            'username' => $user->username,
            'registraties' => Registratie::with('gebruiker')->paginate(5)
        ]);
    }

    public function registratieOpslaan(Request $request) {
        // validate the incoming request
        $incomingFields = $request->validate([
            'geslachtsnaam' => ['required'],
            'soortnaam' => ['required'],
            'vangplaats'=> ['required'],
            'ondersoort' => ['required'],
            'AS'=> ['required'],
            'KV'=> ['required'],
            'notitie' => ['nullable'],
            'jongen' => ['required']
        ]);

        // Strip the incoming request from malicious html with php strip_tags function
        $incomingFields['geslachtsnaam'] = strip_tags($incomingFields['geslachtsnaam']);
        $incomingFields['soortnaam'] = strip_tags($incomingFields['soortnaam']);
        $incomingFields['vangplaats'] = strip_tags($incomingFields['vangplaats']);
        $incomingFields['ondersoort'] = strip_tags($incomingFields['ondersoort']);
        $incomingFields['AS'] = strip_tags($incomingFields['AS']);
        $incomingFields['KV'] = strip_tags($incomingFields['KV']);
        $incomingFields['jongen'] = strip_tags($incomingFields['jongen']);
        $incomingFields['notitie'] = strip_tags($incomingFields['notitie']);

        $incomingFields['user_id'] = auth() ->user()->id;

        // registers a blog post in the DB
        Registratie::create($incomingFields);

        return redirect('/profiel/' . auth()->user()->lidnummer)->with('success','Registratie voltooid.');
    }

    public function optiesOpslaan (Request $request) {

        $incomingFields = $request->validate([
            'geslachtsnaam' => ['nullable'],
            'soortnaam' => ['nullable'],
            'vangplaats'=> ['nullable'],
            'ondersoort' => ['nullable']
        ]);

        Options::create($incomingFields);
        return redirect('/beheerder')->with('success','Opties opgeslagen.');
    }

    public function deleteRegistratie(Registratie $registratie ) {

        if(auth()->user()->cannot('delete', $registratie)) {

            return 'U heeft niet de bevoegdheden om dat uit te voeren.';
        }

        $registratie->delete();
        return redirect('/profiel/' . auth()->user()->lidnummer)->with('success', 'Registratie verwijderd.');
    }

    public function deleteUser(User $user) {
        // $user = User::where('id', $id);
        $user->delete();

        return redirect('/beheerder#gebruikers')->with('success', 'Gebruiker verwijderd.');
    }

    public function importCSV()
    {
        // Read the CSV file
        $csvData = array_map('str_getcsv', file('data.csv'));

        // Remove header row if exists
        array_shift($csvData);

        // Iterate through each row and insert into database
        foreach ($csvData as $row) {
            Options::create([
                'geslachtsnaam' => $row[0], // adjust column indexes according to your CSV structure
                'soortnaam' => $row[0],
                // Add more columns as needed
            ]);
        }

        return "CSV data imported successfully!";
    }
}
