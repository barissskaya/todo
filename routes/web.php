<?php

use App\Classes\TaskPlan;
use App\Models\Developer;
use App\Models\Task;
use Illuminate\Support\Facades\Route;

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

Route::get('/developers', function () {   
    $json = new \stdClass();  
    try {

        $developers = Developer::get()->toArray(); 
        foreach ($developers as $key => $developer) {
            $taskPlan = new TaskPlan();
            $taskPlan->setLevel($developer['level']); 
            $taskPlan->setWeeklyTasksPlan(); 
            $developers[$key]['totalWeek'] = $taskPlan->getTotalWeekNumber();
            $developers[$key]['weeks'] = $taskPlan->getWeeks();
        }
    
        $json->datas        = $developers;
        $json->statusCode   = \Illuminate\Http\Response::HTTP_OK;
        $json->status       = 'ok';  
        $json->message      = '';  

    } catch (\Throwable $e) { 
        
        $json->statusCode   = \Illuminate\Http\Response::HTTP_NOT_FOUND;
        $json->status       = 'error';  
        $json->message      = 'Erişim geçersiz.';  
    }
    return response()->json($json, $json->statusCode);
})->name('developers'); 