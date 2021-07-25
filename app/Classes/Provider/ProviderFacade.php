<?php


namespace App\Classes\Provider;

use App\Models\Task;

class ProviderFacade
{ 
    private $tasks = [];
    private $tasksCount = 0;

    public function fetchTasks(){ 

        $providerOne = new \App\Classes\Provider\ProviderOne();
        $providerOneTasks = $providerOne->fetch();  
        $this->addTasks($providerOneTasks); 
    
        $providerTwo = new \App\Classes\Provider\ProviderTwo();
        $providerTwoTasks = $providerTwo->fetch();   
        $this->addTasks($providerTwoTasks);    
    }

    public function saveTasks(){ 
        if($this->tasksCount){ 
            Task::insert($this->tasks);
            return true;
        }
        return false;
    }

    private function addTasks(array $tasks){ 
        foreach ($tasks as $key => $task) { 
            array_push($this->tasks, $task);
            $this->tasksCount++;
        } 
    }

    public function getTasksCount(){
        return $this->tasksCount;
    }
}
