<?php


use Infinitops\Referral\Models\UserCategory;
use Infinitops\Referral\Models\UserPermission;

$categories = UserCategory::where('deleted', 0)->get();
$permissions = UserPermission::all();

if (!hasPermission(PERM_USER_MANAGEMENT, $currUser)) :
	?>
		<script>
			window.location.replace("index")
		</script>
	<?php endif; ?>


<div class="col-lg-12">
	<div class="card card-outline card-success">
		<div class="card-header">
			<?php if (hasPermission(PERM_SYSTEM_ADMINISTRATION, $currUser)) : ?>
				<div class="card-tools">
					<button class="btn btn-block btn-sm btn-default btn-flat border-primary" data-toggle="modal" data-target="#modalUserCategory"><i class="fa fa-plus"></i> Add New Category</button>
				</div>
			<?php endif; ?>
		</div>
		<div class="card-body">
			<table class="table table-hover table-bordered" id="tableCategories">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Name</th>
						<th>Description</th>
						<th>Permissions</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					foreach ($categories as $category) :
					?>
						<tr>
							<th class="text-center"><?php echo $i++ ?></th>
							<td><b><?php echo ucwords($category->name) ?></b></td>
							<td><b><?php echo $category->description ?></b></td>
							<td>
								<ul class="list-inline">
									<?php foreach ($permissions as $permission) :
										$categoryPermissions = explode(',', $category->permissions);
										if (in_array($permission->id, $categoryPermissions)) :
									?>
											<li class="list-inline-item permission-tag"> <?php echo $permission->name ?></li>
									<?php
										endif;
									endforeach; ?>
								</ul>
							</td>
							<td class="text-center">
								<?php if (hasPermission(PERM_SYSTEM_ADMINISTRATION, $currUser)) : ?>

									<button data-tooltip="tooltip" title="Edit Category" class="btn btn-light btn-circle btn-sm" onclick='editUserCategory(<?php echo json_encode($category); ?>)' data-toggle="modal" data-target="#modalUserCategory">
										<i class="fa fa-edit text-primary"></i></button>
									<button class="btn btn-light btn-circle btn-sm" data-tooltip="tooltip" title="Delete User" onclick='deleteUserCategory(<?php echo json_encode($category); ?>)'><i class="text-danger fa fa-trash"></i></button>
								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- Categories Dialog -->
<div class="modal fade" id="modalUserCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">User Category Dialog</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form action="" method="POST" onsubmit="event.preventDefault();" id="formUserCategory">

				<div class="modal-body">

					<div class="form-group">
						<label for="inputName">Name</label>
						<input type="text" class="form-control" id="inputName" name="name" placeholder="Enter categories name" required>
					</div>

					<div class="form-group">
						<label for="inputDescription">Description</label>
						<textarea name="description" id="inputDescription" class="form-control" cols="30" rows="5" placeholder="Category Description" required></textarea>
					</div>
					<hr>

					<h6>Permissions</h6>
					<div id="divPermissions">
						<?php foreach ($permissions as $permission) : ?>
							<div class="">
								<input name="permissions[]" id="<?php echo 'checkbox' . $permission->id ?>" type="checkbox" data-id="<?php echo $permission->id ?>">
								<label for="<?php echo 'checkbox' . $permission->id ?>"><?php echo $permission->name ?></label>
							</div>
						<?php endforeach; ?>
					</div>
					<hr>


				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<button type="submit" name="savebtn" id="btnSaveCategory" class="btn btn-primary" onclick="saveUserCategory()">Save
					</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Categories Dialog end-->

<style>
	.permission-tag {
		padding: 4px;
		background: #28a745;
		color: #ffffff;
		border-radius: 4px;
		margin-bottom: 5px;
		margin-right: 10px;
		-webkit-transition: all 200ms ease;
		-moz-transition: all 200ms ease;
		-ms-transition: all 200ms ease;
		-o-transition: all 200ms ease;
		transition: all 200ms ease;
	}
</style>

<script>
	const formUserCategory = document.getElementById('formUserCategory')
	const inputName = document.getElementById('inputName')
	const inputDescription = document.getElementById('inputDescription')
	const selectAccessLevel = document.getElementById('selectAccessLevel')
	const divPermissions = document.getElementById('divPermissions')
	const btnSaveCategory = document.getElementById('btnSaveCategory')
	const permissions = '<?php echo json_encode($permissions) ?>'
	let editedId = ''

	function initialize() {
		$("#modalUserCategory").on("hide.bs.modal", () => {
			editedId = ''
			document.querySelector("#formUserCategory").reset()
		});
		$("#tableCategories").dataTable()

	}

	function editUserCategory(category) {
		editedId = category.id
		let checkBoxes = divPermissions.querySelectorAll('input[type=checkbox]')
		inputName.value = category.name
		inputDescription.value = category.description
		$(selectAccessLevel).val(category.access_level)
		for (let i = 0; i < checkBoxes.length; i++) {
			let checkBox = checkBoxes[i]
			let dataId = checkBox.getAttribute('data-id')
			if (category.permissions.split(",").includes(dataId)) checkBox.checked = true
		}

	}

	function deleteUserCategory(category){
		customConfirm('Delete User category', "Are you sure you want to delete this user category? Note that you have to remove users under this category before deleting it.", () => {
		fetch('user_category/delete', {
				method: 'POST',
				body: JSON.stringify({id: category.id}),
				headers: {
					"content-type": "application/x-www-form-urlencoded"
				}
			})
			.then(response => {
				return response.json()
			})
			.then(response => {
				if (response.code === 200) {
					toastr.success(response.message)
					setTimeout(() => {
						window.location.reload();
					}, 800)
				} else throw new Error(response.message)
			})
			.catch(error => {
				console.log(error.message);
				toastr.error(error.message)
	})
}, () => {})
	}
	function saveUserCategory() {
		let formData = new FormData(formUserCategory)
		let categoryData = {};
		for (let [key, value] of formData.entries()) {
			categoryData[key] = value
		}

		let checkBoxes = divPermissions.querySelectorAll('input[type=checkbox]')
		let permissionIds = []
		for (let i = 0; i < checkBoxes.length; i++) {
			let checkBox = checkBoxes[i]
			if (checkBox.checked) {
				permissionIds.push(checkBox.getAttribute('data-id'))
			}
		}
		categoryData.permissions = permissionIds.toString();


		fetch(editedId == '' ? 'user_category/create' : `user_category/update/${editedId}`, {
				method: 'POST',
				body: JSON.stringify(categoryData),
				headers: {
					"content-type": "application/x-www-form-urlencoded"
				}
			})
			.then(response => {
				return response.json()
			})
			.then(response => {
				if (response.code === 200) {
					toastr.success(response.message)
					setTimeout(() => {
						window.location.reload();
					}, 800)
				} else throw new Error(response.message)
			})
			.catch(error => {
				console.log(error.message);
				toastr.error(error.message)
			})
	}

	initialize()
</script>