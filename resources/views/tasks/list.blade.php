<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>To Do -List</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
  crossorigin="anonymous"></script>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

        

            /*UL scripts*********************************************************UL scripts*/
            
            ul li:hover {
              background: #ddd;
              cursor: pointer;
            }

            /*WHEN IS CHECKED*/
            ul li.checked { 
              background: #888;
              color: #fff;
              text-decoration: line-through;
            }

            /* CLOSE BOTTON TO THE RIGHT */
            .close {
              position: absolute;
              padding: 12px !important;
              right: 0;
              top: 0;              
            }

            .close:hover {
              background-color: #ff8080;
              color: white;
            }
        </style>

        <script>
          var host = location.protocol + '//' + location.host + '/';     

        </script>
        
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    To do -List
                </div>               
                <div id="myDIV" class="header">					
			
        					<div class="input-group mb-3">
                      <input id="token" type="hidden" name="_token" value="{{ csrf_token() }}">
          						<input id="scanbox" type="text" class="form-control" placeholder="Put here the task..." aria-label="Put here the task..." aria-describedby="button-addon2">
          						<div class="input-group-append">
          							<button class="btn btn-outline-secondary" type="button" id="button-addon2" onClick="createTask()">Add</button>
          						</div>
        					</div>
				        </div>
                <div >
                  <ul id="myUL" class="list-group list-group-flush">
        					 {{--  <li id="li-3" class="list-group-item list-group-item-success">Pick up my son.
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close" onClick="closeTask(3)">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </li> --}}
                    @foreach($tasks as $task)
                      @if($task->status == 1)
                        <li id="li-{{$task->id}}" class="list-group-item" onclick="taskDone({{$task->id}})">{{$task->name}}
                      @else
                        <li id="li-{{$task->id}}" class="list-group-item list-group-item-success" onclick="taskDone({{$task->id}})">{{$task->name}}
                      @endif
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close" onClick="closeTask({{$task->id}})">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </li>
                    @endforeach
        					</ul>
                          
                </div>
                <script>
                    
                    function closeTask(number) {
                      var route = host + "to-do-delete";
                      var token = $("#token").val();

                      $.ajax({
                        url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                        dataType: 'json',
                        data: {id: number},


                        success:function(e){
                          console.log(e);
                          if (e.success == true) {
                            $('#li-'+e.id).remove();
                          }
                          
                        } 
                      });

                    }                

                    function createTask() {
                      var route = host + "to-do-create";
                      var scantask = $( "#scanbox" ).val();
                      var token = $("#token").val();

                      $.ajax({
                        url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                        dataType: 'json',
                        data: {text: scantask},


                        success:function(e){
                          //console.log(e);
                          var litxt = '<li id="li-'+e.id+'" class="list-group-item" onclick="taskDone(e.id)">'+e.text+'<button type="button" class="close" data-dismiss="alert" aria-label="Close" onClick="closeTask('+e.id+')"><span aria-hidden="true">&times;</span></button></li>';
                           $('#myUL').append(litxt);
                          $( "#scanbox" ).val("");
                        } 
                      });
                    }

                     $('#scanbox').on('keypress', function (e) {
                       if(e.which === 13){
                          createTask();
                       }
                     });

                     function taskDone(number){
                     // console.log('Done: '+number);
                      var route = host + "to-do-done";
                      var token = $("#token").val();

                      $.ajax({
                        url: route,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                        dataType: 'json',
                        data: {id: number},


                        success:function(e){
                          //console.log(e);
                          if (e.success == true) {
                            if (e.status == 1) {
                              $('#li-'+e.id).removeClass('list-group-item-success');
                            }else{
                              $('#li-'+e.id).addClass('list-group-item-success');
                            }                            
                          }
                          
                        } 
                      });
                     }


                </script>

            </div>
      </div>
    </body>
</html>