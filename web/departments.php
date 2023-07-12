<?php

/** @var Umb\EventsManager\Models\User $currUser */

use Infinitops\Referral\Models\Department;

?>
<?php


$departments = Department::all();
?>


<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between">
    <ol class="breadcrumb mb-4 transparent">
        <li class="breadcrumb-item">
            <a href="index">Home</a>
        </li>
        <li class="breadcrumb-item active"> Departments </li>
    </ol>

</div>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <button class="btn btn-primary ml-auto float-right btn-icon-split" data-toggle="modal" data-target="#modalDepartment" id="btnAddDepartment">
            <span class="icon text-white-50"><i class="fa fa-plus"></i> </span>
            <span class="text"> Add Department</span>
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="tableDepartments">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($departments as $department) :
                    ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $department->name ?></td>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-flat" data-tooltip="tooltip" title="Edit Department" onclick='editDepartment(<?php echo json_encode($department); ?>)' data-toggle="modal" data-target="#modalDepartment">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-flat delete_survey" data-tooltip="tooltip" title="Delete Department" data-id="<?php echo $facility->id ?>" onclick='deleteDepartment(<?php echo json_encode($department); ?>)'>
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                    <?php $i++;
                    endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Department Dialog -->
<div class="modal fade" id="modalDepartment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Department Dialog</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="" method="POST" onsubmit="event.preventDefault();" id="formDepartment">

                <div class="modal-body">

                    <div class="form-group">
                        <label for="inputName">Department Name</label>
                        <input type="text" class="form-control" id="inputName" name="name" placeholder="Enter department name" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" name="savebtn" id="btnSaveDepartment" class="btn btn-primary" onclick="saveDepartment()">Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Department Dialog end-->

<script type="text/javascript">
    const inputName = document.querySelector("#inputName");
    let editedId = "";

    $(document).ready(function() {
        $('#tableDepartments').dataTable()
    })

    function initialize() {
        $("#modalDepartment").on("hide.bs.modal", () => {
            editedId = ''
            document.querySelector("#formDepartment").reset()
        });
    }

    function editDepartment(department) {
        editedId = department.id;
        inputName.value = department.name
    }

    function saveDepartment() {
        let btnSaveDepartment = document.getElementById('btnSaveDepartment')
        let name = inputName.value.trim();
        if (name === '') {
            inputUsername.focus()
            return
        }
        let data = {
            name: name,
        }
        let saveUrl = 'department/create'
        let updateUrl = 'department/update/' + editedId
        btnSaveDepartment.setAttribute('disabled', '')
        fetch(
                editedId === "" ? saveUrl : updateUrl, {
                    method: "POST",
                    body: JSON.stringify(data),
                    headers: {
                        "content-type": "application/x-www-form-urlencoded"
                    }
                }
            )
            .then(response => {
                return response.json()
            })
            .then(response => {
                if (response.code === 200) {
                    toastr.success("department saved successfully.")
                    window.location.reload()
                } else throw new Error(response.message)
                // hideModal(dialogId)
            })
            .catch(error => {
                btnSaveDepartment.removeAttribute('disabled')
                console.log(error.message);
                toastr.error(error.message)
            })

    }



    function deleteDepartment(department) {
        // TODO
    }

    initialize()
</script>