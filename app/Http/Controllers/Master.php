<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;
use DB; 

class Master extends Controller
{
    public function index(){
    	
    	$projects = Project::all();
    	return view('welcome',compact('projects'));
    }

    public function getTasks(Request $request){
    	if($request->ajax()){
      $output = '';
      $getProjects = '';
      $query = $request->get('query');
      if($query != '' && $query != '5')
      {
       $data = Task::join('projects', 'projects.id', '=', 'tasks.project_id')
            ->where('projects.id', $query)
            ->orderBy('priority', 'ASC')
            ->paginate(30,array('tasks.*', 'projects.project_name'));
      }
      else
      {
       $data = DB::table('tasks')
         ->orderBy('priority', 'ASC')
         ->paginate(30);
      }
      $total_row = $data->count();
      if($total_row > 0)
      {
       foreach($data as $row)
       {
        $output .= '
                <div class="col-12 col-md-3 border p-4 m-4 get_task_id" id="'.$row->id.'" data-id="'.$row->id.'">
                    <span class="handle"></span>
                    <h4>'.$row->task_name.'</h4>
                    <p>#'.$row->priority.'</p>
                    <p>Scheduel : '.date('d F, Y', strtotime($row->date_time)).'</p>
                    <div class="row d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary edit" id="'.$row->id.'">
                          Edit Task
                        </button>
                        <button class="btn btn-danger delete" id="'.$row->id.'">X</button>
                    </div>
                </div> 
	           ';
       }
      }
      else
      {
       $output = '
       <tr>
        <td align="center" colspan="5">No Task Found</td>
       </tr>
       ';
      }
       
      $number_of_task_row = Task::count();
      $data = array(
       'task_list'  => $output,
       'total_record'  => $total_row,
       'number_of_task_row' => $number_of_task_row
      );

      echo json_encode($data);
     }
    }

    public function addProject(Request $r){
      Project::create([
            'project_name' => $r->project_name,
        ]);

      $msg = 'success !';

      echo json_encode($msg); 
    }


    public function addTask(Request $r){
      Task::create([
            'task_name' => $r->task_name,
            'priority' => $r->priority,
            'date_time' => $r->date_time,
            'project_id' => $r->project_id,
        ]);

      $msg = 'success !';

      echo json_encode($msg); 
    }

    public function deleteTaskModal(Request $r,$id){
        $data=Task::findOrFail($id);
        return response()->json($data); 
    }

    public function deleteTask(Request $r,$id){
        Task::destroy(array('id',$id));

        $msg = 'success !';

        echo json_encode($msg);
    }


    public function sort(Request $request){
     
      $page_id_array = request()->input("page_id_array");

      
      // $sort = json_decode($data);

      // $data = array_values(json_decode($imageids, true));
      // dd($imageids);
      for($i=0; $i<count($page_id_array); $i++)
      {
       Task::where('id', $page_id_array[$i])->update([
            'priority' => $i,
        ]);
      } 
    	 
    }

     public function taskEditData($id){
        $taskValue=Task::findOrFail($id);
        return response()->json($taskValue); 
    }

    public function editTask(Request $request,$id){
      Task::where('id', $request->id)->update([
            'task_name' => $request->task_name,
            'priority' => $request->priority,
            'date_time' => $request->date_time,
            'project_id' => $request->project_id,
        ]);

      $msg = 'success !';

      echo json_encode($msg);
    }


}

