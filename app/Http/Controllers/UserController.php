<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Mail\NewUserEmail;
use App\Models\Registratie;
use App\Models\Options;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Mail\ExpiredPasswordEmail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;

use function Laravel\Prompts\table;
use function Symfony\Component\String\b;
use App\Http\Controllers\TableController;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use App\Http\Controllers\PasswordController;

class UserController extends Controller
{
    // Nieuwe gebruiker aanmaken
    public function register(Request $request) {
        // validate the incoming request fields with rules
        $incomingFields = $request->validate([
            'lidnummer' => ['required', Rule::unique('users', 'lidnummer')],
            'naam' => ['required', 'min:2', 'max:20'],
            'achternaam' => ['required', 'min:2', 'max:20'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
        ]);
        
        // Strip the content of the incoming request from malicious html 
        // with php built in strip_tags function
        $incomingFields['lidnummer'] = strip_tags(($incomingFields['lidnummer']));
        $incomingFields['naam'] = strip_tags(($incomingFields['naam']));
        $incomingFields['achternaam'] = strip_tags(($incomingFields['achternaam']));
        $incomingFields['email'] = strip_tags(($incomingFields['email']));
        $incomingFields['password'] = $this->random_password(8);
        $incomingFields['verified'] = false;
        $incomingFields['password_updated_at'] = Carbon::now();
        
        // registers a user record in the DB
        User::create($incomingFields);

        // sends verification email
        Mail::to($incomingFields['email'])->send(new NewUserEmail(['password' => $incomingFields['password'], 'naam' => $incomingFields['naam'] . " " .  $incomingFields['achternaam']]));

        return redirect('/beheerder')->with('success','Account aangemaakt. Er is een verificatie e-mail verzonden naar het betreffende e-mail adres.');
    }

    function random_password( $length ) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
        $password = substr( str_shuffle( $chars ), 0, $length );
        return $password;
    }

    public function showCorrectHomepage(User $user, Registratie $registraties) {
        // Shows different homepage based on if the user is logged in 
        // or not
        if(auth()->check()) {
            // auth()->logout();
            return view('/homepage');
        } else {
            // auth()->logout();
            return view('/homepage');
        }
    }

    public function showModPage(User $users, Options $options, Registratie $registraties) {
        $users = User::with('registraties')->paginate(5)->fragment('users');
        $registraties = Registratie::with('gebruiker')->paginate(5)->fragment('registraties');
        $options = DB::table('options')->paginate(5)->fragment('options');
        
        return view('/beheerder', [
            'users' => $users,
            'options' => $options,
            'registraties' => $registraties
        ]);
    }

    public function logout() {
        // Terminates the current session
        if(session() === NULL) {
            return redirect('/');
        }

        auth()->logout();
        return redirect('/')->with('success','You are logged out');
    }

    public function showTableAll(Request $request) {
        // Redirect to homepage if session is null
        if (session() === NULL) {
            return redirect('/');
        }
    
        // Get the search query
        $search = $request->input('search');
    
        // Define the query using Eloquent (to include relationships)
        $query = Registratie::with('gebruiker'); // Assuming 'gebruiker' is a relationship
    
        // Apply the search filter if a search query is present
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('geslachtsnaam', 'like', "%$search%")
                ->orWhere('soortnaam', 'like', "%$search%")
                ->orWhere('vangplaats', 'like', "%$search%")
                ->orWhere('ondersoort', 'like', "%$search%");
            })
            ->orWhereHas('gebruiker', function ($q) use ($search) {
                $q->where('lidnummer', 'like', "%$search%");
            });
        }
    
        // Sort by a column (if any) with default sorting
        $sortBy = $request->input('sort_by', 'created_at');  // Default column to sort
        $sortOrder = $request->input('sort_order', 'desc');  // Default sorting order
    
        // Apply ordering and pagination
        $registraties = $query->orderBy($sortBy, $sortOrder)->paginate(10);
    
        // Return the view with the results
        return view('table-all', compact('registraties', 'search', 'sortBy', 'sortOrder'));
    }
    

    public function profiel(User $user, Request $request) {
        // redirects to homepage of the app with the correct header
        if(session() === NULL) {
            return redirect('/');
        }
    
        // Get the search query
        $search = $request->input('search');
    
        // Define the query using Eloquent (allows chaining of methods like where and orderBy)
        $query = Registratie::where('user_id', $user->id); // Assuming each registration belongs to a user
    
        // Apply the search filter if a search query is present
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('geslachtsnaam', 'like', "%$search%")
                ->orWhere('soortnaam', 'like', "%$search%")
                ->orWhere('vangplaats', 'like', "%$search%")
                ->orWhere('ondersoort', 'like', "%$search%");
            });
        }
    
        // Sort by a column (if any) with default sorting
        $sortBy = $request->input('sort_by', 'created_at');  // Default column to sort
        $sortOrder = $request->input('sort_order', 'desc');  // Default sorting order
    
        // Apply ordering and pagination
        $registraties = $query->orderBy($sortBy, $sortOrder)->paginate(10);
        $username = $user->naam . ' ' .  $user->achternaam;
    
        return view('table-user', compact('username', 'registraties', 'search', 'sortBy', 'sortOrder', 'user'));
    }

    public function profilePasswordResetForm() {
        return view('profile-password-reset');
    }

    public function verificationPasswordResetPost(User $user, Request $request) {
            // Validate the incoming request fields
            $request->validate([
                'currentPassword' => 'required',
                'newPassword' => 'required', 'confirmed', Password::min(8)->numbers()->symbols()->uncompromised()
            ]);

            $user = Auth::user();

            if (!Hash::check($request->currentPassword, $user->password)) {
                return back()->with('error', 'Current password is incorrect.');
            }
            
            $user->password = Hash::make($request->newPassword);
            $user->verified = 1;
            
            /** @var \App\Models\User $user **/
            $user->save();
    
            return redirect()->back()->with('success', 'Password updated successfully.');
    }

    public function showSingleRegistratie(Registratie $registratie) {
        // redirects to homepage of the app with the correct header
        if (session() === NULL) {
            return redirect('/');
        }

        $gebruiker = $registratie->gebruiker('naam');
        return view('single-post', ['registratie' => $registratie, 'gebruiker' => $gebruiker]);
    }

    public function deleteSingleRegistratie(Registratie $registratie) {
        if(auth()->user()->cannot('delete', $registratie)) {
            return 'Er ging iets verkeerd.';
        }

        $registratie->delete();
        return redirect('/profile/' . auth()->user()->username)->with('success', 'Registratie verwijderd.');
    }

    public function deleteUser(User $user) {
        $user->delete();

        return redirect('/beheerder')->with('success', 'Gebruiker verwijderd.');
    }

    public function deleteOption(Options $option) {
        $option->delete();
        return redirect('/beheerder#opties')->with('success', 'Optie verwijderd.');
    }

    public function modDeleteSingleRegistratie(Registratie $registratie) {

        $registratie->delete();

        return redirect('/beheerder#registraties')->with('success', 'Registratie verwijderd.');
    }

    public function login(Request $request, User $user) {

        // Check if either log in field is empty
        if($request['loginemail'] == NULL || $request['loginpassword'] == NULL ) {
            redirect('/')->with('error', 'Vul alle velden in om in te loggen');
        }

        // Validate the incoming request fields
        $incomingFields = Validator::make($request->all(), [
            'loginemail' => 'required',
            'loginpassword'=> 'required'
        ]);

        $incomingFields = $request->validate([
            'loginemail' => 'required',
            'loginpassword'=> 'required'
        ]);

        // logs user in or not and redirects
        if(auth()->attempt(['email' => $incomingFields['loginemail'], 'password' => $incomingFields['loginpassword']])) {
            $request->session()->regenerate();

            // checks if the password is expired
            // $this->expiredCheck($user);
            return redirect('/');
        }

        return redirect('/')->with('error','De ingevoerde referenties werden niet herkend in de database. Probeer het nogmaals of klik op "wachtwoord vergeten"');
    }

    public function registratieWijzigenFormulier(Registratie $registratie) {
        $all = DB::table('options')->get();
        return view('edit-visregistratie', ['all' => $all, 'registratie' => $registratie]);
    }

    public function registratieWijzigen(Request $request, Registratie $registratie) {
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

        // Updates the database entry
        $registratie->update($incomingFields);

        return redirect('/profiel/' . auth()->user()->lidnummer)->with('success','Registratie gewijzigd.');
    }




    // PROFILE SETTINGS
     // Show profile settings page
    public function showSettings() {
        $user = auth()->user();
        return view('settings', compact('user'));
    }

     // Update name
    public function updateName(Request $request) {
        $request->validate([
            'name' => 'required|string|max:50',
        ]);

        $user = Auth::user();
        $user->naam = $request->name;
        $user->save();

        return redirect()->back()->with('success', 'Naam aangepast.');
    }

    // update achternaam
    public function updateAchternaam(Request $request) {
        $request->validate([
            'achternaam' => 'required|string|max:50',
        ]);

        $user = Auth::user();
        $user->achternaam = $request->achternaam;
        $user->save();

        return redirect()->back()->with('success', 'Naam aangepast.');
    }

    // Update email
    public function updateEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
        ]);

        $user = Auth::user();
        $user->email = $request->email;
        $user->save();

        return redirect()->back()->with('success', 'Email aangepast.');
    }

    // Update password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:7|confirmed',
        ]);

        $user = Auth::user();
        
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Huidige wachtwoord was incorrect.']);
        }

        $user->password = Hash::make($request->password);
        Auth::user()->verified = 1;
        $user->save();

        return redirect()->back()->with('success', 'Wachtwoord aangepast.');
    }

    // Delete account and posts
    public function deleteAccount()
    {
        $user = Auth::user();

        // Delete user posts
        Registratie::where('user_id', $user->id)->delete();

        // Delete user account
        $user->delete();

        Auth::logout();
        return redirect('/')->with('error', 'Account verwijderd.');
    }
}