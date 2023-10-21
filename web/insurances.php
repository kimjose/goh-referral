<?php

/** @var Umb\EventsManager\Models\User $currUser */

use Infinitops\Referral\Models\Insurance;

?>
<?php


$insurances = Insurance::where('deleted', 0)->get();
?>


<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between">
    <ol class="breadcrumb mb-4 transparent">
        <li class="breadcrumb-item">
            <a href="index">Home</a>
        </li>
        <li class="breadcrumb-item active"> Insurances </li>
    </ol>

</div>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <button class="btn btn-primary ml-auto float-right btn-icon-split" data-toggle="modal" data-target="#modalInsurance" id="btnAddInsurance">
            <span class="icon text-white-50"><i class="fa fa-plus"></i> </span>
            <span class="text"> Add Insurance</span>
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="tableInsurances">
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
                    foreach ($insurances as $insurance) :
                    ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $insurance->name ?></td>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-flat" data-tooltip="tooltip" title="Edit Insurance" onclick='editInsurance(<?php echo json_encode($insurance); ?>)' data-toggle="modal" data-target="#modalInsurance">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-flat delete_insurance" data-tooltip="tooltip" title="Delete Insurance" data-id="<?php echo $insurance->id ?>" onclick='deleteInsurance(<?php echo json_encode($insurance); ?>)'>
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

<!-- Insurance Dialog -->
<div class="modal fade" id="modalInsurance" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Insurance Dialog</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="" method="POST" onsubmit="event.preventDefault();" id="formInsurance">

                <div class="modal-body">

                    <div class="form-group">
                        <label for="inputName">Insurance Name</label>
                        <input type="text" class="form-control" id="inputName" name="name" placeholder="Enter insurance name" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" name="savebtn" id="btnSaveInsurance" class="btn btn-primary" onclick="saveInsurance()">Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Insurance Dialog end-->

<script type="text/javascript">
    const inputName = document.querySelector("#inputName");
    let editedId = "";

    $(document).ready(function() {
        $('#tableInsurances').dataTable()
    })

    function initialize() {
        $("#modalInsurance").on("hide.bs.modal", () => {
            editedId = ''
            document.querySelector("#formInsurance").reset()
        });
    }

    function editInsurance(insurance) {
        editedId = insurance.id;
        inputName.value = insurance.name
    }

    function saveInsurance() {
        let btnSaveInsurance = document.getElementById('btnSaveInsurance')
        let name = inputName.value.trim();
        if (name === '') {
            inputUsername.focus()
            return
        }
        let data = {
            name: name,
        }
        let saveUrl = 'insurance/create'
        let updateUrl = 'insurance/update/' + editedId
        btnSaveInsurance.setAttribute('disabled', '')
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
                    toastr.success("insurance saved successfully.")
                    window.location.reload()
                } else throw new Error(response.message)
                // hideModal(dialogId)
            })
            .catch(error => {
                btnSaveInsurance.removeAttribute('disabled')
                console.log(error.message);
                toastr.error(error.message)
            })

    }



    function deleteInsurance(insurance) {
        let r = confirm('Are you sure you want to delete this insurance?')
        if (r) {
            fetch("insurance/delete", {
                    headers: {
                        "content-type": "application/x-www-form-urlencoded"
                    },
                    method: 'POST',
                    body: JSON.stringify({
                        id: insurance.id
                    })
                })
                .then(response => response.json())
                .then(response => {
                    if (response.code == 200) {
                        toastr.success("insurance deleted successfully.")
                        setTimeout(() => location.reload(), 897)
                    } else throw new Exception(response.message)
                })
                .error(err => {
                    toastr.error(err.message)
                })
        }
    }

    initialize()
</script>