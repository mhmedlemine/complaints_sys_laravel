<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Consumer;
use App\Models\Entreprise;
use App\Models\Fine;
use App\Models\Infraction;
use App\Models\Merchant;
use App\Models\Moughataa;
use App\Models\Municipality;
use App\Models\Neighbourhood;
use App\Models\Summon;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Wilaya;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminController extends Controller
{
    public function dashboard()
    {
        $merchantCount = Merchant::count();
        $entrepriseCount = Entreprise::count();
        $fineCount = Fine::count();
        $summonCount = Summon::count();
        $complaintCount = Complaint::count();
        $infractionCount = Infraction::count();

        return view('admin.dashboard', compact('merchantCount', 'entrepriseCount', 'fineCount', 'summonCount', 'complaintCount', 'infractionCount'));
    }

    // Users
    public function users(Request $request)
    {
        $search = $request->input('search');
        $users = User::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        })->paginate(10);
        return view('admin.users.index', compact('users', 'search'));
    }

    public function createUser()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users',
            'phonenumber' => 'sometimes|string|max:8|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required|array',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $roleNames = Role::whereIn('id', $request->roles)->pluck('name');

        $user->assignRole($roleNames);

        return redirect()->route('admin.users')->with('success', 'User created successfully.');
    }

    public function editUser(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
            'phonenumber' => 'sometimes|string|max:8|unique:users,phonenumber,' . $user->id,
            'roles' => 'required|array',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phonenumber' => $request->phonenumber,
        ]);

        $roleNames = Role::whereIn('id', $request->roles)->pluck('name');

        $user->syncRoles($roleNames);

        return redirect()->route('admin.users')->with('success', 'User updated successfully.');
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }

    public function showUser(User $user)
    {
        $roles = Role::all();
        return view('admin.users.show', compact('user', 'roles'));
    }

    // Roles
    public function roles()
    {
        $roles = Role::with('permissions')->paginate(10);
        return view('admin.roles.index', compact('roles'));
    }

    public function createRole()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    public function storeRole(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'required|array'
        ]);

        $role = Role::create(['name' => $request->name]);

        $permissionNames = Permission::whereIn('id', $request->permissions)->pluck('name');
        $role->syncPermissions($permissionNames);

        return redirect()->route('admin.roles')
            ->with('success', 'Role created successfully');
    }

    public function editRole(Role $role)
    {
        $permissions = Permission::all();
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function updateRole(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'required|array'
        ]);

        $role->update(['name' => $request->name]);

        $permissionNames = Permission::whereIn('id', $request->permissions)->pluck('name');
        $role->syncPermissions($permissionNames);

        return redirect()->route('admin.roles')
            ->with('success', 'Role updated successfully');
    }

    public function deleteRole(Role $role)
    {
        $role->delete();
        return redirect()->route('admin.roles')
            ->with('success', 'Role deleted successfully');
    }

    public function showRole(Role $role)
    {
        $role->load('permissions');
        return view('admin.roles.show', compact('role'));
    }

    // Persmissions
    public function permissions()
    {
        $permissions = Permission::paginate(10);
        return view('admin.permissions.index', compact('permissions'));
    }

    public function createPermission()
    {
        return view('admin.permissions.create');
    }

    public function storePermission(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        $permission = Permission::create(['name' => $request->name]);

        return redirect()->route('admin.permissions')
            ->with('success', 'Permission created successfully');
    }

    public function editPermission(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    public function updatePermission(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        $permission->update(['name' => $request->name]);

        return redirect()->route('admin.permissions')
            ->with('success', 'Permission updated successfully');
    }

    public function deletePermission(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('admin.permissions')
            ->with('success', 'Permission deleted successfully');
    }

    // Wilayas
    public function wilayas(Request $request)
    {
        $search = $request->input('search');
        $wilayas = Wilaya::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhere('name_ar', 'like', "%{$search}%");
        })->paginate(10);
        return view('admin.wilayas.index', compact('wilayas', 'search'));
    }

    public function createWilaya()
    {
        return view('admin.wilayas.create');
    }

    public function storeWilaya(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:wilayas',
            'name' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'lat' => 'required|numeric',
            'lon' => 'required|numeric',
        ]);

        Wilaya::create($request->all());

        return redirect()->route('admin.wilayas')->with('success', 'Wilaya created successfully.');
    }

    public function editWilaya(Wilaya $wilaya)
    {
        return view('admin.wilayas.edit', compact('wilaya'));
    }

    public function updateWilaya(Request $request, Wilaya $wilaya)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:wilayas,code,' . $wilaya->id,
            'name' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'lat' => 'required|numeric',
            'lon' => 'required|numeric',
        ]);

        $wilaya->update($request->all());

        return redirect()->route('admin.wilayas')->with('success', 'Wilaya updated successfully.');
    }

    public function deleteWilaya(Wilaya $wilaya)
    {
        $wilaya->delete();
        return redirect()->route('admin.wilayas')->with('success', 'Wilaya deleted successfully.');
    }

    public function showWilaya(Wilaya $wilaya)
    {
        return view('admin.wilayas.show', compact('wilaya'));
    }

    // Moughataas
    public function moughataas(Request $request)
    {
        $search = $request->input('search');
        $moughataas = Moughataa::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhere('name_ar', 'like', "%{$search}%");
        })->paginate(10);
        return view('admin.moughataas.index', compact('moughataas', 'search'));
    }

    public function createMoughataa()
    {
        $wilayas = Wilaya::all();
        return view('admin.moughataas.create', compact('wilayas'));
    }

    public function storeMoughataa(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:moughataas',
            'name' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'lat' => 'required|numeric',
            'lon' => 'required|numeric',
        ]);

        Moughataa::create($request->all());

        return redirect()->route('admin.moughataas')->with('success', 'Moughataa created successfully.');
    }

    public function editMoughataa(Moughataa $moughataa)
    {
        $wilayas = Wilaya::all();
        return view('admin.moughataas.edit', compact('moughataa', 'wilayas'));
    }

    public function updateMoughataa(Request $request, Moughataa $moughataa)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:moughataas,code,' . $moughataa->id,
            'name' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'lat' => 'required|numeric',
            'lon' => 'required|numeric',
        ]);

        $moughataa->update($request->all());

        return redirect()->route('admin.moughataas')->with('success', 'Moughataa updated successfully.');
    }

    public function deleteMoughataa(Moughataa $moughataa)
    {
        $moughataa->delete();
        return redirect()->route('admin.moughataas')->with('success', 'Moughataa deleted successfully.');
    }

    public function showMoughataa(Moughataa $moughataa)
    {
        $moughataa->load('municipalities');
        return view('admin.moughataas.show', compact('moughataa'));
    }

    // Municipalitys
    public function municipalities(Request $request)
    {
        $search = $request->input('search');
        $municipalities = Municipality::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhere('name_ar', 'like', "%{$search}%");
        })->paginate(10);
        return view('admin.municipalities.index', compact('municipalities', 'search'));
    }

    public function createMunicipality()
    {
        $moughataas = Moughataa::all();
        return view('admin.municipalities.create', compact('moughataas'));
    }

    public function storeMunicipality(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:municipalities',
            'name' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'lat' => 'required|numeric',
            'lon' => 'required|numeric',
        ]);

        Municipality::create($request->all());

        return redirect()->route('admin.municipalities')->with('success', 'Municipality created successfully.');
    }

    public function editMunicipality(Municipality $municipality)
    {
        $moughataas = Moughataa::all();
        return view('admin.municipalities.edit', compact('municipality', 'moughataas'));
    }

    public function updateMunicipality(Request $request, Municipality $municipality)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:municipalities,code,' . $municipality->id,
            'name' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'lat' => 'required|numeric',
            'lon' => 'required|numeric',
        ]);

        $municipality->update($request->all());

        return redirect()->route('admin.municipalities')->with('success', 'Municipality updated successfully.');
    }

    public function deleteMunicipality(Municipality $municipality)
    {
        $municipality->delete();
        return redirect()->route('admin.municipalities')->with('success', 'Municipality deleted successfully.');
    }

    public function showMunicipality(Municipality $municipality)
    {
        return view('admin.municipalities.show', compact('municipality'));
    }


    // Neighbourhoods
    public function neighbourhoods(Request $request)
    {
        $search = $request->input('search');
        $neighbourhoods = Neighbourhood::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhere('name_ar', 'like', "%{$search}%");
        })->paginate(10);
        return view('admin.neighbourhoods.index', compact('neighbourhoods', 'search'));
    }

    public function createNeighbourhood()
    {
        $municipalities = Municipality::all();
        return view('admin.neighbourhoods.create', compact('municipalities'));
    }

    public function storeNeighbourhood(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:neighbourhoods',
            'name' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'lat' => 'required|numeric',
            'lon' => 'required|numeric',
        ]);

        Neighbourhood::create($request->all());

        return redirect()->route('admin.neighbourhoods')->with('success', 'Neighbourhood created successfully.');
    }

    public function editNeighbourhood(Neighbourhood $neighbourhood)
    {
        $municipalities = Municipality::all();
        return view('admin.neighbourhoods.edit', compact('neighbourhood', 'municipalities'));
    }

    public function updateNeighbourhood(Request $request, Neighbourhood $neighbourhood)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:neighbourhoods,code,' . $neighbourhood->id,
            'name' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'lat' => 'required|numeric',
            'lon' => 'required|numeric',
        ]);

        $neighbourhood->update($request->all());

        return redirect()->route('admin.neighbourhoods')->with('success', 'Neighbourhood updated successfully.');
    }

    public function deleteNeighbourhood(Neighbourhood $neighbourhood)
    {
        $neighbourhood->delete();
        return redirect()->route('admin.neighbourhoods')->with('success', 'Neighbourhood deleted successfully.');
    }

    public function showNeighbourhood(Neighbourhood $neighbourhood)
    {
        return view('admin.neighbourhoods.show', compact('neighbourhood'));
    }

    // Consumers
    public function consumers(Request $request)
    {
        $search = $request->input('search');
        $consumers = Consumer::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhere('name_ar', 'like', "%{$search}%");
        })->paginate(10);
        return view('admin.consumers.index', compact('consumers', 'search'));
    }

    public function createConsumer()
    {
        return view('admin.consumers.create');
    }

    public function storeConsumer(Request $request)
    {
        $request->validate([
            'nni' => 'required|string|max:255|unique:consumers',
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'phonenumber' => 'required|numeric',
            'address' => 'required|string|max:255',
        ]);

        Consumer::create($request->all());

        return redirect()->route('admin.consumers')->with('success', 'Consumer created successfully.');
    }

    public function editConsumer(Consumer $consumer)
    {
        return view('admin.consumers.edit', compact('consumer'));
    }

    public function updateConsumer(Request $request, Consumer $consumer)
    {
        $request->validate([
            'nni' => 'required|string|max:255|unique:consumers,nni,' . $consumer->id,
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'phonenumber' => 'required|numeric',
            'address' => 'required|string|max:255',
        ]);

        $consumer->update($request->all());

        return redirect()->route('admin.consumers')->with('success', 'Consumer updated successfully.');
    }

    public function deleteConsumer(Consumer $consumer)
    {
        $consumer->delete();
        return redirect()->route('admin.consumers')->with('success', 'Consumer deleted successfully.');
    }

    public function showConsumer(Consumer $consumer)
    {
        return view('admin.consumers.show', compact('consumer'));
    }

    // Merchants
    public function merchants(Request $request)
    {
        $search = $request->input('search');
        $merchants = Merchant::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhere('name_ar', 'like', "%{$search}%");
        })->paginate(10);
        return view('admin.merchants.index', compact('merchants', 'search'));
    }

    public function createMerchant()
    {
        return view('admin.merchants.create');
    }

    public function storeMerchant(Request $request)
    {
        $request->validate([
            'nni' => 'required|string|max:255|unique:merchants',
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'phonenumber' => 'required|numeric',
        ]);

        Merchant::create($request->all());

        return redirect()->route('admin.merchants')->with('success', 'Merchant created successfully.');
    }

    public function editMerchant(Merchant $merchant)
    {
        return view('admin.merchants.edit', compact('merchant'));
    }

    public function updateMerchant(Request $request, Merchant $merchant)
    {
        $request->validate([
            'nni' => 'required|string|max:255|unique:merchants,nni,' . $merchant->id,
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'phonenumber' => 'required|numeric',
        ]);

        $merchant->update($request->all());

        return redirect()->route('admin.merchants')->with('success', 'Merchant updated successfully.');
    }

    public function deleteMerchant(Merchant $merchant)
    {
        $merchant->delete();
        return redirect()->route('admin.merchants')->with('success', 'Merchant deleted successfully.');
    }

    public function showMerchant(Merchant $merchant)
    {
        return view('admin.merchants.show', compact('merchant'));
    }

    // Entreprises
    public function entreprises(Request $request)
    {
        $search = $request->input('search');
        $entreprises = Entreprise::with('owner', 'agent', 'neighbourhood')->when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhere('name_ar', 'like', "%{$search}%");
        })->paginate(10);
        return view('admin.entreprises.index', compact('entreprises', 'search'));
    }

    public function createEntreprise()
    {
        $merchants = Merchant::all();
        $neighbourhoods = Neighbourhood::all();
        $users = User::all();
        return view('admin.entreprises.create', compact('merchants', 'users', 'neighbourhoods'));
    }

    public function storeEntreprise(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:entreprises',
            'name' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'lat' => 'required|numeric',
            'lon' => 'required|numeric',
        ]);
        //dd($request->all());
        $params = ["code" => $request->code, "name" => $request->name, "name_ar" => $request->name_ar, "neighbourhood_id" => $request->neighbourhood_id, "owner_id" => $request->owner_id, "status" => $request->status, "type" => $request->type, "registeredon" => $request->registeredon, "registeredby" => $request->registeredby, "lat" => $request->lat, "lon" => $request->lon, "rg" => $request->rg, "notes" => $request->notes, "address" => $request->address];

        // logger("Request", $request->all());
        Entreprise::create($request->all());

        return redirect()->route('admin.entreprises')->with('success', 'Entreprise created successfully.');
    }

    public function editEntreprise(Entreprise $entreprise)
    {
        $merchants = Merchant::all();
        $neighbourhoods = Neighbourhood::all();
        $users = User::all();
        return view('admin.entreprises.edit', compact('entreprise', 'merchants', 'neighbourhoods', 'users'));
    }

    public function updateEntreprise(Request $request, Entreprise $entreprise)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:entreprises,code,' . $entreprise->id,
            'name' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'lat' => 'required|numeric',
            'lon' => 'required|numeric',
        ]);

        $entreprise->update($request->all());

        return redirect()->route('admin.entreprises')->with('success', 'Entreprise updated successfully.');
    }

    public function deleteEntreprise(Entreprise $entreprise)
    {
        $entreprise->delete();
        return redirect()->route('admin.entreprises')->with('success', 'Entreprise deleted successfully.');
    }

    public function showEntreprise(Entreprise $entreprise)
    {
        return view('admin.entreprises.show', compact('entreprise'));
    }

    // Complaints
    public function complaints(Request $request)
    {
        $search = $request->input('search');
        $complaints = Complaint::with('consumer', 'receiver', 'investigator', 'entreprise')->when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhere('name_ar', 'like', "%{$search}%");
        })->paginate(10);
        return view('admin.complaints.index', compact('complaints', 'search'));
    }

    public function createComplaint()
    {
        $entreprises = Entreprise::all();
        $consumers = Consumer::all();
        $users = User::all();
        return view('admin.complaints.create', compact('entreprises', 'users', 'consumers'));
    }

    public function storeComplaint(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:complaints',
        ]);

        Complaint::create($request->all());

        return redirect()->route('admin.complaints')->with('success', 'Complaint created successfully.');
    }

    public function editComplaint(Complaint $complaint)
    {
        $entreprises = Entreprise::all();
        $consumers = Consumer::all();
        $users = User::all();
        return view('admin.complaints.edit', compact('complaint', 'entreprises', 'consumers', 'users'));
    }

    public function updateComplaint(Request $request, Complaint $complaint)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:complaints,code,' . $complaint->id,
            'name' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'lat' => 'required|numeric',
            'lon' => 'required|numeric',
        ]);

        $complaint->update($request->all());

        return redirect()->route('admin.complaints')->with('success', 'Complaint updated successfully.');
    }

    public function deleteComplaint(Complaint $complaint)
    {
        $complaint->delete();
        return redirect()->route('admin.complaints')->with('success', 'Complaint deleted successfully.');
    }

    public function showComplaint(Complaint $complaint)
    {
        return view('admin.complaints.show', compact('complaint'));
    }

    // Infractions
    public function infractions(Request $request)
    {
        $search = $request->input('search');
        $infractions = Infraction::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhere('name_ar', 'like', "%{$search}%");
        })->paginate(10);
        return view('admin.infractions.index', compact('infractions', 'search'));
    }

    public function createInfraction()
    {
        return view('admin.infractions.create');
    }

    public function storeInfraction(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:infractions',
            'label' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        Infraction::create($request->all());

        return redirect()->route('admin.infractions')->with('success', 'Infraction created successfully.');
    }

    public function editInfraction(Infraction $infraction)
    {
        return view('admin.infractions.edit', compact('infraction'));
    }

    public function updateInfraction(Request $request, Infraction $infraction)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:infractions,code,' . $infraction->id,
            'label' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        $infraction->update($request->all());

        return redirect()->route('admin.infractions')->with('success', 'Infraction updated successfully.');
    }

    public function deleteInfraction(Infraction $infraction)
    {
        $infraction->delete();
        return redirect()->route('admin.infractions')->with('success', 'Infraction deleted successfully.');
    }

    public function showInfraction(Infraction $infraction)
    {
        return view('admin.infractions.show', compact('infraction'));
    }

    // Summons
    public function summons(Request $request)
    {
        $search = $request->input('search');
        $summons = Summon::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhere('name_ar', 'like', "%{$search}%");
        })->paginate(10);
        return view('admin.summons.index', compact('summons', 'search'));
    }

    public function createSummon()
    {
        $users = User::all();
        $infractions = Infraction::all();
        $complaints = Complaint::all();
        return view('admin.summons.create', compact('users', 'infractions', 'complaints'));
    }

    public function storeSummon(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:summons',
            'label' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        Summon::create($request->all());

        return redirect()->route('admin.summons')->with('success', 'Summon created successfully.');
    }

    public function editSummon(Summon $summon)
    {
        return view('admin.summons.edit', compact('summon'));
    }

    public function updateSummon(Request $request, Summon $summon)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:summons,code,' . $summon->id,
            'label' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        $summon->update($request->all());

        return redirect()->route('admin.summons')->with('success', 'Summon updated successfully.');
    }

    public function deleteSummon(Summon $summon)
    {
        $summon->delete();
        return redirect()->route('admin.summons')->with('success', 'Summon deleted successfully.');
    }

    public function showSummon(Summon $summon)
    {
        return view('admin.summons.show', compact('summon'));
    }

    // Fines
    public function fines(Request $request)
    {
        $search = $request->input('search');
        $fines = Fine::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhere('name_ar', 'like', "%{$search}%");
        })->paginate(10);
        return view('admin.fines.index', compact('fines', 'search'));
    }

    public function createFine()
    {
        return view('admin.fines.create');
    }

    public function storeFine(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:fines',
            'label' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        Fine::create($request->all());

        return redirect()->route('admin.fines')->with('success', 'Fine created successfully.');
    }

    public function editFine(Fine $fine)
    {
        return view('admin.fines.edit', compact('fine'));
    }

    public function updateFine(Request $request, Fine $fine)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:fines,code,' . $fine->id,
            'label' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        $fine->update($request->all());

        return redirect()->route('admin.fines')->with('success', 'Fine updated successfully.');
    }

    public function deleteFine(Fine $fine)
    {
        $fine->delete();
        return redirect()->route('admin.fines')->with('success', 'Fine deleted successfully.');
    }

    public function showFine(Fine $fine)
    {
        return view('admin.fines.show', compact('fine'));
    }
}
