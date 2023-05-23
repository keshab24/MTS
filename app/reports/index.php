
<div class="modal" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewModalLabel">View Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Content to display in the modal -->
        <div id="viewContent"></div>
      </div>
      <div class="modal-footer">
        <!-- Close button -->
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php
// Include the database configuration file  

// Database configuration  
$dbHost     = "localhost";  
$dbUsername = "root";  
$dbPassword = "";  
$dbName     = "mts_db";  
  
// Create database connection  
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);  
  
// Check connection  
if ($db->connect_error) {  
    die("Connection failed: " . $db->connect_error);  
}
if(isset($_GET['vid'])){

    $qry = $db->query("Delete FROM `report_images` where id = '{$_GET['vid']}'");
    $_settings->flashdata('success');
    http_response_code(200);
   
    
   
    }

?>

<table id="datatableid" class="table datatable table-striped table-hover dt-init">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Report image</th>
                        <th>Name</th>                       
                        
                        <th>Description</th>
                        
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                     <?php
                     $result = $db->query("SELECT * FROM report_images ORDER BY id DESC"); 

$cnt=1;
$row=mysqli_num_rows($result);
if($row>0){
while ($row=mysqli_fetch_array($result)) {

?>
<!--Fetch the Records -->
<tr>
<td><?php echo $cnt;?></td>
<td>
<div class="image-zoom-container">
    <img src="../assets/<?php  echo $row['image'];?>" width="130" height="100" >
</div></td>
<td><?php  echo $row['name'];?></td>
                      
 <td><?php  echo $row['description'];?></td>

<td>
<div class="dropdown">
<button class="btn btn-primary btn-sm bg-gradient rounded-0 mb-0" type="button" id="" data-bs-toggle="dropdown" aria-expanded="false">
    Action <span class="material-icons">keyboard_arrow_down</span>
</button>
    <ul class="dropdown-menu" aria-labelledby="">
        <li><a class="dropdown-item view_data w-100 d-flex align-items-center" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#viewModal" data-image="<?php echo $row['image']; ?>" data-name="<?php echo $row['name']; ?>" data-description="<?php echo $row['description']; ?>">
    <span class="material-icons me-2">wysiwyg</span> View
  </a></li>
        <li><a class="dropdown-item edit_data w-100 d-flex align-items-center" href="./?page=reports/manage_report&id=<?php echo $row['id'];?>"><span class="material-icons me-2" data-id="<?php echo $row['id'];?>">edit</span> Edit</a></li>
        <li><a class="dropdown-item  w-100 d-flex align-items-center" onclick="return confirm('are you sure to delete report')" data-id="<?php echo $row['id'];?>" href="./?page=reports&vid=<?php echo $row['id'];?>"><span class="material-icons me-2"<span>delete</span> Delete</a></li>
    </ul>
</div>

</tr>
<?php 
$cnt=$cnt+1;
} } else {?>
<tr>
<th style="text-align:center; color:red;" colspan="6">No Record Found</th>
</tr>
<?php } ?>                 
                
</tbody>

</table>
<!-- Bootstrap Modal 5 -->
<!-- The Modal -->

<!-- Bootstrap Modal -->
<script>
        $(document).ready(function () {
           


            $('#datatableid').DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search Your Data",
                }
            });

        });

        $('.view_data').on('click', function() {
      var image = $(this).data('image');
      var name = $(this).data('name');
      console.log(name);
      var description = $(this).data('description');
      
      // Set the content in the modal
      $('#viewContent').html('<img src="../assets/' + image + '" width="400" height="300"><p>Name: ' + name + '</p><p>Description: ' + description + '</p>');
    
    });
   
//delete 


  $('.delete_data').on('click', function() {
    // Get the ID of the data to be deleted
    // var id = // Retrieve the ID value from the row or data attribute
     var id = $(this).data("id");
     
     
    // Show a confirmation dialog to confirm the deletion
    if (confirm('Are you sure you want to delete this data?')) {
      // Perform the delete action using AJAX or navigate to a delete endpoint

      // Example using AJAX
      $.ajax({
        url: '../classes/Master.php?f=delete_report', // Replace with your server-side script URL
        method: 'POST',
        // data: { 'id': id }, // Pass the ID value as a parameter
        data: {
                'id': id
            },
            
        success: function(response) {
          // Handle the success response
          alert('Data deleted successfully');
          // Optionally, you can reload the page or update the UI as needed
          
        },
        error: function(xhr, status, error) {
          // Handle the error response
          alert('An error occurred while deleting the data');
          console.log(error);
        }
      });
    }
  });





        $('.dt-init').DataTable({
            processing: true,
            serverSide: true,
            // ajax: {
            //     url:"../classes/Master.php?f=dt_reports",
            //     method:"POST"
            // },
            columns: [{
                    data: 'no',
                    className: 'py-1 px-2 text-center',
                    width:"5%"
                },
                {
                    data: 'created_at',
                    className: 'py-1 px-2',
                    width:"15%"
                },
                {
                    data: 'name',
                    className: 'py-1 px-2',
                    width:"25%"
                },
                {
                    className: 'py-1 px-2',
                    render:function(data, type, row, meta){
                        return '<p class="m-0 text-truncate w-100">'+((row.description).substr(0,100))+'...</p>';
                        },
                    width:"35%"
                },
                {
                    data: null,
                    orderable: false,
                    className: 'text-center py-1 px-2',
                    render: function(data, type, row, meta) {
                        var el = $('<div>')
                        el.append($($('noscript#action-btn-clone').html()).clone())
                        el.attr('id','dropdown'+row.id)
                        el.find('.dropdown-menu').attr('aria-labelledby','dropdown'+row.id)
                        el.find('.edit_data,.delete_data,.view_data').attr('data-id',row.id).attr('data-name',row.name)
                        el.find('.edit_data').attr("href","./?page=medicines/manage_medicine&id="+row.id)
                        
                        return el.html();
                        
                    },
                    width:"10%"
                }
            ],
            columnDefs: [{
                orderable: false,
                targets: 4
            }],
            initComplete: function(settings, json) {
                $('table td, table th').addClass('px-2 py-1 align-middle')
            },
            drawCallback: function(settings) {
                $('table td, table th').addClass('px-2 py-1 align-middle')
                
                $('.delete_data').click(function(){
                    _conf("Are you sure to delete <b>"+$(this).attr('data-name')+"</b> from list?","delete_medicine",[$(this).attr('data-id')])
                })
            },
            language:{
                oPaginate: {
                    sNext: '<i class="fa fa-angle-right"></i>',
                    sPrevious: '<i class="fa fa-angle-left"></i>',
                    sFirst: '<i class="fa fa-step-backward"></i>',
                    sLast: '<i class="fa fa-step-forward"></i>'
                }
            }
        })
 
    // function delete_medicine($id){
    //     start_loader();
    //     var _this = $(this)
    //     $('.err-msg').remove();
    //     var el = $('<div>')
    //     el.addClass("alert alert-danger err-msg")
    //     el.hide()
    //     $.ajax({
    //         url: '../classes/Master.php?f=delete_medicine',
    //         method: 'POST',
    //         data: {
    //             id: $id
    //         },
    //         dataType: 'json',
    //         error: err => {
    //             console.log(err)
    //             el.text('An error occurred.')
    //             el.show('slow')
    //             end_loader()
    //         },
    //         success: function(resp) {
    //             if (resp.status == 'success') {
    //                 location.reload()
    //             } else if (!!resp.msg) {
    //                 el.text('An error occurred.')
    //                 el.show('slow')
    //             } else {
    //                 el.text('An error occurred.')
    //                 el.show('slow')
    //             }
    //             end_loader()
    //         }
    //     })
    // }
</script>


 
