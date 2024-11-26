<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CheckupController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('language/{lang}', [LanguageController::class, 'switchLang'])->name('language.switch');

Route::get('/dashboard', function () {
    return redirect('/admin');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    // Users
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/admin/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    Route::get('/admin/users/{user}', [AdminController::class, 'showUser'])->name('admin.users.show');
    // Roles
    Route::get('/admin/roles', [AdminController::class, 'roles'])->name('admin.roles');
    Route::get('/admin/roles/create', [AdminController::class, 'createRole'])->name('admin.roles.create');
    Route::post('/admin/roles', [AdminController::class, 'storeRole'])->name('admin.roles.store');
    Route::get('/admin/roles/{role}/edit', [AdminController::class, 'editRole'])->name('admin.roles.edit');
    Route::put('/admin/roles/{role}', [AdminController::class, 'updateRole'])->name('admin.roles.update');
    Route::delete('/admin/roles/{role}', [AdminController::class, 'deleteRole'])->name('admin.roles.delete');
    Route::get('/admin/roles/{role}', [AdminController::class, 'showRole'])->name('admin.roles.show');
    // Permissions
    Route::get('/admin/permissions', [AdminController::class, 'permissions'])->name('admin.permissions');
    Route::get('/admin/permissions/create', [AdminController::class, 'createPermission'])->name('admin.permissions.create');
    Route::post('/admin/permissions', [AdminController::class, 'storePermission'])->name('admin.permissions.store');
    Route::get('/admin/permissions/{permission}/edit', [AdminController::class, 'editPermission'])->name('admin.permissions.edit');
    Route::put('/admin/permissions/{permission}', [AdminController::class, 'updatePermission'])->name('admin.permissions.update');
    Route::delete('/admin/permissions/{permission}', [AdminController::class, 'deletePermission'])->name('admin.permissions.delete');
    // Wilayas
    Route::get('/admin/wilayas', [AdminController::class, 'wilayas'])->name('admin.wilayas');
    Route::get('/admin/wilayas/create', [AdminController::class, 'createWilaya'])->name('admin.wilayas.create');
    Route::post('/admin/wilayas', [AdminController::class, 'storeWilaya'])->name('admin.wilayas.store');
    Route::get('/admin/wilayas/{wilaya}/edit', [AdminController::class, 'editWilaya'])->name('admin.wilayas.edit');
    Route::put('/admin/wilayas/{wilaya}', [AdminController::class, 'updateWilaya'])->name('admin.wilayas.update');
    Route::delete('/admin/wilayas/{wilaya}', [AdminController::class, 'deleteWilaya'])->name('admin.wilayas.delete');
    Route::get('/admin/wilayas/{wilaya}', [AdminController::class, 'showWilaya'])->name('admin.wilayas.show');
    // Moughataas
    Route::get('/admin/moughataas', [AdminController::class, 'moughataas'])->name('admin.moughataas');
    Route::get('/admin/moughataas/create', [AdminController::class, 'createMoughataa'])->name('admin.moughataas.create');
    Route::post('/admin/moughataas', [AdminController::class, 'storeMoughataa'])->name('admin.moughataas.store');
    Route::get('/admin/moughataas/{moughataa}/edit', [AdminController::class, 'editMoughataa'])->name('admin.moughataas.edit');
    Route::put('/admin/moughataas/{moughataa}', [AdminController::class, 'updateMoughataa'])->name('admin.moughataas.update');
    Route::delete('/admin/moughataas/{moughataa}', [AdminController::class, 'deleteMoughataa'])->name('admin.moughataas.delete');
    Route::get('/admin/moughataas/{moughataa}', [AdminController::class, 'showMoughataa'])->name('admin.moughataas.show');
    // Municipalities
    Route::get('/admin/municipalities', [AdminController::class, 'municipalities'])->name('admin.municipalities');
    Route::get('/admin/municipalities/create', [AdminController::class, 'createMunicipality'])->name('admin.municipalities.create');
    Route::post('/admin/municipalities', [AdminController::class, 'storeMunicipality'])->name('admin.municipalities.store');
    Route::get('/admin/municipalities/{municipality}/edit', [AdminController::class, 'editMunicipality'])->name('admin.municipalities.edit');
    Route::put('/admin/municipalities/{municipality}', [AdminController::class, 'updateMunicipality'])->name('admin.municipalities.update');
    Route::delete('/admin/municipalities/{municipality}', [AdminController::class, 'deleteMunicipality'])->name('admin.municipalities.delete');
    Route::get('/admin/municipalities/{municipality}', [AdminController::class, 'showMunicipality'])->name('admin.municipalities.show');
    // Neighbourhoods
    Route::get('/admin/neighbourhoods', [AdminController::class, 'neighbourhoods'])->name('admin.neighbourhoods');
    Route::get('/admin/neighbourhoods/create', [AdminController::class, 'createNeighbourhood'])->name('admin.neighbourhoods.create');
    Route::post('/admin/neighbourhoods', [AdminController::class, 'storeNeighbourhood'])->name('admin.neighbourhoods.store');
    Route::get('/admin/neighbourhoods/{neighbourhood}/edit', [AdminController::class, 'editNeighbourhood'])->name('admin.neighbourhoods.edit');
    Route::put('/admin/neighbourhoods/{neighbourhood}', [AdminController::class, 'updateNeighbourhood'])->name('admin.neighbourhoods.update');
    Route::delete('/admin/neighbourhoods/{neighbourhood}', [AdminController::class, 'deleteNeighbourhood'])->name('admin.neighbourhoods.delete');
    Route::get('/admin/neighbourhoods/{neighbourhood}', [AdminController::class, 'showNeighbourhood'])->name('admin.neighbourhoods.show');
    // Consumers
    Route::get('/admin/consumers', [AdminController::class, 'consumers'])->name('admin.consumers');
    Route::get('/admin/consumers/create', [AdminController::class, 'createConsumer'])->name('admin.consumers.create');
    Route::post('/admin/consumers', [AdminController::class, 'storeConsumer'])->name('admin.consumers.store');
    Route::get('/admin/consumers/{consumer}/edit', [AdminController::class, 'editConsumer'])->name('admin.consumers.edit');
    Route::put('/admin/consumers/{consumer}', [AdminController::class, 'updateConsumer'])->name('admin.consumers.update');
    Route::delete('/admin/consumers/{consumer}', [AdminController::class, 'deleteConsumer'])->name('admin.consumers.delete');
    Route::get('/admin/consumers/{consumer}', [AdminController::class, 'showConsumer'])->name('admin.consumers.show');
    // Merchants
    Route::get('/admin/merchants', [AdminController::class, 'merchants'])->name('admin.merchants');
    Route::get('/admin/merchants/create', [AdminController::class, 'createMerchant'])->name('admin.merchants.create');
    Route::post('/admin/merchants', [AdminController::class, 'storeMerchant'])->name('admin.merchants.store');
    Route::get('/admin/merchants/{merchant}/edit', [AdminController::class, 'editMerchant'])->name('admin.merchants.edit');
    Route::put('/admin/merchants/{merchant}', [AdminController::class, 'updateMerchant'])->name('admin.merchants.update');
    Route::delete('/admin/merchants/{merchant}', [AdminController::class, 'deleteMerchant'])->name('admin.merchants.delete');
    Route::get('/admin/merchants/{merchant}', [AdminController::class, 'showMerchant'])->name('admin.merchants.show');
    // Entreprises
    Route::get('/admin/entreprises', [AdminController::class, 'entreprises'])->name('admin.entreprises');
    Route::get('/admin/entreprises/create', [AdminController::class, 'createEntreprise'])->name('admin.entreprises.create');
    Route::post('/admin/entreprises', [AdminController::class, 'storeEntreprise'])->name('admin.entreprises.store');
    Route::get('/admin/entreprises/{entreprise}/edit', [AdminController::class, 'editEntreprise'])->name('admin.entreprises.edit');
    Route::put('/admin/entreprises/{entreprise}', [AdminController::class, 'updateEntreprise'])->name('admin.entreprises.update');
    Route::delete('/admin/entreprises/{entreprise}', [AdminController::class, 'deleteEntreprise'])->name('admin.entreprises.delete');
    Route::get('/admin/entreprises/{entreprise}', [AdminController::class, 'showEntreprise'])->name('admin.entreprises.show');
    // Checkups
    Route::get('/admin/checkups', [CheckupController::class, 'index'])->name('admin.checkups.index');
    Route::get('/admin/checkups/create', [CheckupController::class, 'create'])->name('admin.checkups.create');
    Route::post('/admin/checkups', [CheckupController::class, 'store'])->name('admin.checkups.store');
    Route::get('/admin/checkups/{checkup}/edit', [CheckupController::class, 'index'])->name('admin.checkups.edit');
    Route::put('/admin/checkups/{checkup}', [CheckupController::class, 'index'])->name('admin.checkups.update');
    Route::delete('/admin/checkups/{checkup}', [CheckupController::class, 'index'])->name('admin.checkups.delete');
    Route::get('/admin/checkups/{checkup}', [CheckupController::class, 'index'])->name('admin.checkups.show');
    // Complaints
    Route::get('/admin/complaints', [AdminController::class, 'complaints'])->name('admin.complaints');
    Route::get('/admin/complaints/create', [AdminController::class, 'createComplaint'])->name('admin.complaints.create');
    Route::post('/admin/complaints', [AdminController::class, 'storeComplaint'])->name('admin.complaints.store');
    Route::get('/admin/complaints/{complaint}/edit', [AdminController::class, 'editComplaint'])->name('admin.complaints.edit');
    Route::put('/admin/complaints/{complaint}', [AdminController::class, 'updateComplaint'])->name('admin.complaints.update');
    Route::delete('/admin/complaints/{complaint}', [AdminController::class, 'deleteComplaint'])->name('admin.complaints.delete');
    Route::get('/admin/complaints/{complaint}', [AdminController::class, 'showComplaint'])->name('admin.complaints.show');
    // Infractions
    Route::get('/admin/infractions', [AdminController::class, 'infractions'])->name('admin.infractions');
    Route::get('/admin/infractions/create', [AdminController::class, 'createInfraction'])->name('admin.infractions.create');
    Route::post('/admin/infractions', [AdminController::class, 'storeInfraction'])->name('admin.infractions.store');
    Route::get('/admin/infractions/{infraction}/edit', [AdminController::class, 'editInfraction'])->name('admin.infractions.edit');
    Route::put('/admin/infractions/{infraction}', [AdminController::class, 'updateInfraction'])->name('admin.infractions.update');
    Route::delete('/admin/infractions/{infraction}', [AdminController::class, 'deleteInfraction'])->name('admin.infractions.delete');
    Route::get('/admin/infractions/{infraction}', [AdminController::class, 'showInfraction'])->name('admin.infractions.show');
    // Summons
    Route::get('/admin/summons', [AdminController::class, 'summons'])->name('admin.summons');
    Route::get('/admin/summons/create', [AdminController::class, 'createSummon'])->name('admin.summons.create');
    Route::post('/admin/summons', [AdminController::class, 'storeSummon'])->name('admin.summons.store');
    Route::get('/admin/summons/{summon}/edit', [AdminController::class, 'editSummon'])->name('admin.summons.edit');
    Route::put('/admin/summons/{summon}', [AdminController::class, 'updateSummon'])->name('admin.summons.update');
    Route::delete('/admin/summons/{summon}', [AdminController::class, 'deleteSummon'])->name('admin.summons.delete');
    Route::get('/admin/summons/{summon}', [AdminController::class, 'showSummon'])->name('admin.summons.show');
    // Fines
    Route::get('/admin/fines', [AdminController::class, 'fines'])->name('admin.fines');
    Route::get('/admin/fines/create', [AdminController::class, 'createFine'])->name('admin.fines.create');
    Route::post('/admin/fines', [AdminController::class, 'storeFine'])->name('admin.fines.store');
    Route::get('/admin/fines/{fine}/edit', [AdminController::class, 'editFine'])->name('admin.fines.edit');
    Route::put('/admin/fines/{fine}', [AdminController::class, 'updateFine'])->name('admin.fines.update');
    Route::delete('/admin/fines/{fine}', [AdminController::class, 'deleteFine'])->name('admin.fines.delete');
    Route::get('/admin/fines/{fine}', [AdminController::class, 'showFine'])->name('admin.fines.show');
});

Route::middleware(['auth', 'role:higher-mgmt,admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

require __DIR__.'/auth.php';
