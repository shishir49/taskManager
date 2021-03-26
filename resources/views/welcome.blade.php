@extends('layout.app')

@section('content')

<section class="container">
    <div class="row">
        <div class="col-12 col-md-6">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#project">
              Add New Project
            </button>
            <button type="button" class="btn btn-primary add">
              Add New Task
            </button>
            
        </div>
        <div class="col-12 col-md-6">
            <form>
                <select class="form-control search select2" id="projects">
                       <option value="">All</option>
                    @foreach($projects as $project)
                      <option value="{{$project->id}}">{{$project->project_name}}</option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>
</section>

<section class="container">
    <div class="row d-flex justify-content-between sort_task" id="sort_task">
        
    </div>

    <div class="row">
       <b>Total Tasks : <span id="total_records"></span></b>
    </div>

    <span id="total_task_row" style="display: none"></span>

</section>





<!-- Project Modal -->
<div class="modal fade addProject" id="project" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
       <form id="addProjectForm">
           @csrf
           <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add New Project</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
             <div class="form-group">
                <label>Project Name</label>
                <input type="text" name="project_name" id="project_name" class="form-control clear">
             </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Add Project</button>
          </div>
       </form>
    </div>
  </div>
</div>

<!-- Add Task Modal -->
<div class="modal fade addTask" id="addTask" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="addTaskForm">
           @csrf
           <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add New Task</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
             <div class="form-group">
                <label>Task Name</label>
                <input type="text" id="task_name" name="task_name" class="form-control clear">
             </div>
             <div class="form-group">
                <label>Select Project</label>
                <select name="project_id" id="project_id" class="form-control">
                    @foreach($projects as $project)
                      <option value="{{$project->id}}">{{$project->project_name}}</option>
                    @endforeach
                </select>
             </div>
             <div class="form-group">
                <label>Scheduel</label>
                <input type="date" name="date_time" id="date_time" class="form-control clear">
             </div>
             <div class="form-group">
                <label>Priority</label>
                <input type="text" name="priority" id="priority" class="form-control clear" disabled="disabled"><span id="total_task_row"></span>
             </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" id="add" class="btn btn-primary addButtonShow">Add Task</button>
          </div>
       </form>
    </div>
  </div>
</div>

<!-- Delete Task Modal -->
<div class="modal fade deleteTask" id="deleteTask" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="deleteTaskForm">
           @csrf
           <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Delete Task</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <p>Are you sure You want to Delete <span id="delete_task_name"></span> ?</p>
              <span id="delete_task_id" style="display: none"></span>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" id="delete" class="btn btn-danger">Confirm Delete</button>
          </div>
       </form>
    </div>
  </div>
</div>

<!-- Edit Task Modal -->
<div class="modal fade editTask" id="editTask" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="editTaskForm">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Task</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
             <span id="edit_task_id" style="display: none"></span>
             <div class="form-group">
                <label>Task Name</label>
                <input type="text" id="edit_task_name" name="task_name" class="form-control clear">
             </div>
             <div class="form-group">
                <label>Select Project</label>
                <select name="project_id" id="edit_project_id" class="form-control">
                    @foreach($projects as $project)
                      <option value="{{$project->id}}">{{$project->project_name}}</option>
                    @endforeach
                </select>
             </div>
             <div class="form-group">
                <label>Scheduel</label>
                <input type="date" name="date_time" id="edit_date_time" class="form-control clear">
             </div>
             <div class="form-group">
                <label>Priority</label>
                <input type="text" name="priority" id="edit_priority" class="form-control clear" disabled="disabled">
             </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
      </form>  
    </div>
  </div>
</div>

<script>

$(document).ready(function(){

  $('.select2').select2({
    placeholder:'Select Category',
    theme:'bootstrap4',
    tags:true,
  })

});

</script>
 
@endsection