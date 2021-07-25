<?php 

namespace App\Classes;
 
use App\Models\Task;

class TaskPlan 
{
    const WEEKLY_WORKING_HOURS  = 45; 

    private $level;
    private $weeks = [];  
    private $maxCreatedWeekNumber;  

    public function setLevel(int $level){
        if($level <= 0){
           throw new \InvalidArgumentException('The level is must be positive'); 
        }
        $this->level = $level; 
    } 

    public function setWeeklyTasksPlan(){
        if(is_null($this->level)){
           throw new \Exception('Task level is null'); 
        }
        $this->createWeeklyTasks();
    }

    public function getWeeks(){
        return $this->weeks;
    }

    private function createWeeklyTasks(){ 
        $tasks = Task::select(['id','name','duration','level'])->level($this->level)->durationDesc()->get();
        foreach ($tasks as $task) {   
             $this->addTaskToWeek($task);
        }
    }

    private function addTaskToWeek(Task $task){  

        $weekNumber = 1;
        while(true){

            if (!$this->hasCreatedWeek($weekNumber)) {
                $this->createNewWeek($weekNumber); 
            }

            if($this->weeks[$weekNumber]['duration'] + $task->duration <= self::WEEKLY_WORKING_HOURS){ 
        
                $this->weeks[$weekNumber]['duration'] += $task->duration;
                $this->weeks[$weekNumber]['tasks'][] = $task->toArray();
                break;
            
            } 
            
            ++$weekNumber;
        } 
    }

    private function createNewWeek(int $weekNumber){
        $this->weeks[$weekNumber]['duration'] = 0; 
        $this->weeks[$weekNumber]['tasks'] = [];
        $this->maxCreatedWeekNumber = $weekNumber;
    }

    private function hasCreatedWeek(int $weekNumber){
        if(is_null($this->maxCreatedWeekNumber)){
            return false;
        } 
        return $this->maxCreatedWeekNumber >= $weekNumber;
    } 

    public function getTotalWeekNumber(){
        return $this->maxCreatedWeekNumber;
    }
}
