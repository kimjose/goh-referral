<?php

/**
 * @var Umb\Mentorship\Models\User $currUser
 */

use Infinitops\Referral\Models\User;
use Infinitops\Referral\Models\Facility;
use Infinitops\Referral\Models\UserCategory;

if (!hasPermission(PERM_USER_MANAGEMENT, $currUser)) :
?>
	<script>
		window.location.replace("index")
	</script>
<?php endif; ?>
<?php


$id = '';
if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$u = User::findOrFail($id);
}

/** @var Facility[] $facilities */
$facilities = Facility::orderBy('name', 'asc')->get();
$categories = UserCategory::all();

?>
<div class="col-lg-12">
	<div class="card">
		<div class="card-body">
			<form action="" id="manage_user">
				<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
				<div class="row">
					<div class="col-md-6 border-right">
						<b class="text-muted">Personal Information</b>

						<div class="form-group">
							<label for="" class="control-label">Surname</label>
							<input type="text" name="surname" class="form-control form-control-sm" required value="<?php echo $id != '' ? $u->surname : '' ?>">
						</div>
						<div class="form-group">
							<label for="" class="control-label">First Name</label>
							<input type="text" name="first_name" class="form-control form-control-sm" required value="<?php echo $id != '' ? $u->first_name : '' ?>">
						</div>
						<div class="form-group">
							<label for="" class="control-label">Middle Name</label>
							<input type="text" name="middle_name" class="form-control form-control-sm" value="<?php echo $id != '' ? $u->middle_name : '' ?>">
						</div>

						<div class="form-group">
							<label for="selectCategory">User category</label>
							<select name="category_id" id="selectCategory" class="form-control select2">
								<option value="" hidden selected>Select access level first</option>
								<?php
								foreach ($categories as $category) : ?>
									<option value="<?php echo $category->id ?>" <?php echo $category->id === $u->category_id ? ' selected' : '' ?>> <?php echo $category->name ?> </option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="" class="control-label">Phone No.</label>
							<input type="number" name="phone_number" class="form-control form-control-sm" required value="<?php echo $id != '' ? $u->phone_number : '' ?>">
						</div>
						<input type="hidden" name="type" value="3">
						<div class="form-group">
							<label class="control-label">Email</label>
							<input type="email" class="form-control form-control-sm" name="email" required value="<?php echo $id != '' ? $u->email : '' ?>">
							<small id="#msg"></small>
						</div>
						<div class="form-group">
							<label class="control-label">Password</label>
							<input type="password" class="form-control form-control-sm" name="password" <?php echo isset($id) ? "" : 'required' ?>>
							<small><i><?php echo isset($id) ? "Leave this blank if you dont want to change you password" : '' ?></i></small>
						</div>
						<div class="form-group">
							<label class="label control-label">Confirm Password</label>
							<input type="password" class="form-control form-control-sm" name="cpass" <?php echo isset($id) ? "" : 'required' ?>>
							<small id="pass_match" data-status=''></small>
						</div>
					</div>
				</div>
				<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
					<button class="btn btn-primary mr-2" id="btnSave">Save</button>
					<button class="btn btn-secondary" type="button" onclick="location.href = 'index?page=users'">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	const formManageUser = document.querySelector('#manage_user')
	const selectCategory = document.querySelector('#selectCategory')
	const btnSave = document.querySelector('#btnSave')
	const id = '<?php echo $id ?>'
	const categories = JSON.parse('<?php echo json_encode($categories) ?>')
	console.log(categories);
	$('[name="password"],[name="cpass"]').keyup(function() {
		var pass = $('[name="password"]').val()
		var cpass = $('[name="cpass"]').val()
		if (cpass == '' || pass == '') {
			$('#pass_match').attr('data-status', '')
		} else {
			if (cpass == pass) {
				$('#pass_match').attr('data-status', '1').html('<i class="text-success">Password Matched.</i>')
			} else {
				$('#pass_match').attr('data-status', '2').html('<i class="text-danger">Password does not match.</i>')
			}
		}
	})



	function displayImg(input, _this) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#cimg').attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]);
		}
	}
	$('#manage_user').submit(function(e) {
		e.preventDefault()
		$('input').removeClass("border-danger")
		start_load()
		$('#msg').html('')
		if ($('#pass_match').attr('data-status') != 1) {
			if ($("[name='password']").val() != '') {
				$('[name="password"],[name="cpass"]').addClass("border-danger")
				end_load()
				return false;
			}
		}

		let formData = new FormData(formManageUser)
		let userData = {};
		for (let [key, value] of formData.entries()) {
			userData[key] = value
		}

		fetch(id == '' ? 'user/create' : `user/update/${id}`, {
				method: 'POST',
				body: JSON.stringify(userData),
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
						window.location.replace('index?page=users')
					}, 800)
				} else throw new Error(response.message)
			})
			.catch(error => {
				end_load()
				console.log(error.message);
				toastr.error(error.message)
			})
	})
</script>