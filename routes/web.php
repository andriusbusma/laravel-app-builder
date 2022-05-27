<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/builder', function () {
    return view('builder');
})->name('builder');

Route::get('/information', function () {
    return view('information');
})->name('information');

Route::post('/generate', function (Request $request) {
    $data = $request->input('json');
    $app_name = $request->input('app_name') ? $request->input('app_name') : 'App';

    if(!isset(json_decode($data)->models)){
        return back();
    }

    if(!Storage::exists('/temp')){
        Storage::makeDirectory('/temp');
    }
    if(!Storage::exists('/temp/app')){
        Storage::makeDirectory('/temp/app');
    }

    if(!Storage::exists('/temp/app/Models')){
        Storage::makeDirectory('/temp/app/Models');
    }

    if(!Storage::exists('/temp/database')){
        Storage::makeDirectory('/temp/database');
    }
    if(!Storage::exists('/temp/database/migrations')){
        Storage::makeDirectory('/temp/database/migrations');
    }

    $controllers_data = \App\Generator::getControllers($data);

    if($controllers_data){

        if(!Storage::exists('/temp/app/Providers')){
            Storage::makeDirectory('/temp/app/Providers');
        }
    
        if(!Storage::exists('/temp/app/Http')){
            Storage::makeDirectory('/temp/app/Http');
        }
        if(!Storage::exists('/temp/app/Http/Controllers')){
            Storage::makeDirectory('/temp/app/Http/Controllers');
        }

        if(!Storage::exists('/temp/routes')){
            Storage::makeDirectory('/temp/routes');
        }

        if(!Storage::exists('/temp/resources')){
            Storage::makeDirectory('/temp/resources');
        }
        if(!Storage::exists('/temp/resources/views')){
            Storage::makeDirectory('/temp/resources/views');
        }
        if(!Storage::exists('/temp/resources/views/includes')){
            Storage::makeDirectory('/temp/resources/views/includes');
        }
        if(!Storage::exists('/temp/resources/views/layouts')){
            Storage::makeDirectory('/temp/resources/views/layouts');
        }
        if(!Storage::exists('/temp/resources/views/pages')){
            Storage::makeDirectory('/temp/resources/views/pages');
        }

        Storage::put('/temp/resources/views/layouts/default.blade.php', \App\Generator::generateLayout());
        Storage::put('/temp/resources/views/includes/head.blade.php', \App\Generator::generateHead($app_name));
        Storage::put('/temp/resources/views/includes/header.blade.php', \App\Generator::generateHeader($controllers_data, $app_name));
        Storage::put('/temp/resources/views/pages/home.blade.php', \App\Generator::generateHome($controllers_data));

        
        foreach ($controllers_data as $key => $value) {
            if(!Storage::exists('/temp/resources/views/pages/'.$value['name'])){
                Storage::makeDirectory('/temp/resources/views/pages/'.$value['name']);
            }
            Storage::put('/temp/app/Http/Controllers/'.$value['controller'].'.php', \App\Generator::generateController($value));
            Storage::put('/temp/resources/views/pages/'.$value['name'].'/index.blade.php', \App\Generator::generateIndexView($value));
            Storage::put('/temp/resources/views/pages/'.$value['name'].'/create.blade.php', \App\Generator::generateCreateView($value));
            Storage::put('/temp/resources/views/pages/'.$value['name'].'/edit.blade.php', \App\Generator::generateEditView($value));
        }

        Storage::put('/temp/routes/web.php', \App\Generator::generateRoutes(\App\Generator::getRoutes($data)));
        Storage::put('/temp/app/Providers/AppServiceProviders.php', \App\Generator::generateAppServiceProvider());
    }

    foreach (\App\Generator::getModels($data) as $key => $value) {
        Storage::put('/temp/app/Models/'.$key.'.php', \App\Generator::generateModel($value, $key));
    }

    foreach (\App\Generator::getTables($data) as $key => $value) {
        Storage::put('/temp/database/migrations/'.date('Y_m_d_His').'_'.$key.'.php', \App\Generator::generateTable($value, $key));
    }

    $zip_file = 'app.zip';
    $zip = new \ZipArchive();
    $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

    $path = storage_path('app/temp');
    $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
    foreach ($files as $name => $file)
    {
        if (!$file->isDir()) {
            $filePath     = $file->getRealPath();
            $relativePath = substr($filePath, strlen($path) + 1);
            $zip->addFile($filePath, $relativePath);
        }
    }
    $zip->close();

    Storage::deleteDirectory('/temp');
    return response()->file($zip_file);
})->name('generate');
