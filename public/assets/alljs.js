$(document).ready(function(){
    const Msg = Swal.mixin({
            toast: true
            , position: 'top-end'
            , icon: 'success'
            , showConfirmButton: false
            , timer: 1500
        })

    fetch_task();

    $(document).on('change', '.search', function(){
        event.preventDefault();
        $('#sort_task').append('<img style="position: fixed; left: 45%; top: 20%; z-index: 100000;" src="images/load.gif" />');
        var query = $(this).val();

        fetch_task(query);
    });


     //-----------------------Get All Task Info ------------------------



     function fetch_task(query = '')
     {
      $.ajax({
       url:"getTasks",
       method:'GET',
       data:{query:query},
       dataType:'json',
       success:function(data)
       {
        $('#sort_task').html(data.task_list);
        $('#total_records').text(data.total_record);
        $('#total_task_row').text(data.number_of_task_row);
       }
      })
     }

     //---------------Clear Input Fields ------------------


    function clearData() {
        $('.clear').val('');
    }

    //--------------Add Project -----------------------

     
    $('#addProjectForm').on('submit',function(event){
        event.preventDefault();

        let project_name = $('#project_name').val();
        
        $.ajax({
          url: "/addProject",
          type:"POST",
          data:{
            project_name:project_name,
          },
          success:function(response){
            console.log(response);
            $('.addProject').modal('hide');
            fetch_task();
            clearData();
            Msg.fire({
                type: 'success'
                , icon: 'success'
                , title: 'Task Edited !'
            }),
            location.reload();
          },
        });
    });

     //----------- Add Task --------------------
    
    $(document).on('click', '.add', function(){
        event.preventDefault();
    
        let create_priority = $('#total_task_row').html();
        $('#priority').val(create_priority);
        $('#addTask').modal('show');

        
    });
     
    $('#addTaskForm').on('submit',function(event){
        event.preventDefault();

        let task_name = $('#task_name').val();
        let project_id = $('#project_id').val();
        let date_time = $('#date_time').val();
        let priority = $('#priority').val();

        $.ajax({
          url: "/addTask",
          type:"POST",
          data:{
                task_name:task_name,
                project_id:project_id,
                date_time:date_time,
                priority:priority,
          },
          success:function(response){
            console.log(response);
            $('.addTask').modal('hide');
            fetch_task();
            clearData();
            Msg.fire({
                type: 'success'
                , icon: 'success'
                , title: 'Task Added !'
            })
          }, error: function (error) {
                Msg.fire({
                    type: 'info'
                    , icon: 'error'
                    , title: 'Something went wrong!'
                })
            }
        });
    });

    //----------- Update Task --------------------

    $(document).on('click', '.edit', function(){
        event.preventDefault();

        let id = $(this).attr('id');
        
        $.ajax({
          url: "/editTaskModal/"+id,
          dataType:"json",
               success:function(taskValue){
                $('#edit_task_id').html(taskValue.id);
                $('input#edit_task_name').val(taskValue.task_name);
                $('input#edit_priority').val(taskValue.priority);
                $('input#edit_date_time').val(taskValue.date_time);
                $('select#edit_project_id').val(taskValue.project_id);
                $('#editTask').modal('show');
               }
          })
    });
  
    $('#editTaskForm').on('submit',function(event){
        event.preventDefault();

        let id = $('#edit_task_id').html();
        let task_name = $('#edit_task_name').val();
        let priority = $('#edit_priority').val();
        let project_id = $('#edit_project_id').val();
        let date_time = $('#edit_date_time').val();

        console.log(task_name);
        
        $.ajax({
          url: "/editTask/"+id,
          type:"POST",
          data:{
                task_name : task_name,
                priority : priority,
                project_id : project_id,
                date_time : date_time,
          },
               success:function(data){
                $('.editTask').modal('hide');
                fetch_task();
                clearData();
                Msg.fire({
                    type: 'success'
                    , icon: 'success'
                    , title: 'Task Edited !'
                })
               }, error: function (error) {
                 
                    Msg.fire({
                        type: 'info'
                        , icon: 'error'
                        , title: 'Something went wrong!'
                    })
                }
          })
    });

    //----------- Delete A Task --------------------

    $(document).on('click', '.delete', function(){
        event.preventDefault();

        let id = $(this).attr('id');
        
        $.ajax({
          url: "/deleteTaskModal/"+id,
          dataType:"json",
               success:function(data){
                $('#delete_task_name').html(data.task_name);
                $('#delete_task_id').html(data.id);
                $('#deleteTask').modal('show');
               }
          })
    });
  
    $('#deleteTaskForm').on('submit',function(event){
        event.preventDefault();

        let id = $('#delete_task_id').html();

        $.ajax({
          url: "/deleteTask/"+id,
          type:"POST",
          data:{
                id:id
          },
               success:function(data){
                $('.deleteTask').modal('hide');
                fetch_task();
                clearData();
                Msg.fire({
                    type: 'success'
                    , icon: 'success'
                    , title: 'Task Deleted !'
                })
               }, error: function (error) {
                Msg.fire({
                    type: 'info'
                    , icon: 'error'
                    , title: 'Something went wrong!'
                })
             }
          })
    });

    //----------------------Sort Tasks -----------------------

    $( "#sort_task" ).sortable({
      placeholder : "ui-state-highlight",
      update  : function(event, ui)
      {
       var page_id_array = new Array();
       $('#sort_task .get_task_id').each(function(){
        page_id_array.push($(this).attr("id"));
       });
       $.ajax({
        url:"sortTasks",
        method:"POST",
        data:{page_id_array:page_id_array},
        success:function(data){
            fetch_task();
             Msg.fire({
                type: 'success'
                , icon: 'success'
                , title: 'Tasks Reordered !'
            })
        }, error: function (error) {
                Msg.fire({
                    type: 'info'
                    , icon: 'error'
                    , title: 'Something went wrong!'
                })
            }
       });
      }
    });
});