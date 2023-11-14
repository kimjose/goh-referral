<?php

use Infinitops\Referral\Models\User;

$users = User::where('deleted', 0)->get();
$activeBadge = "<span class=\"badge badge-primary rounded-pill\">Active</span>";
$inactiveBadge = "<span class=\"badge badge-secondary rounded-pill\">Inactive</span>";

if (!hasPermission(PERM_USER_MANAGEMENT, $currUser)) :
?>
	<script>
		window.location.replace("index")
	</script>
<?php endif; ?>
<div class="col-lg-12">
	<div class="card card-outline card-success">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index?page=users-edit"><i class="fa fa-plus"></i> Add New User</a>
			</div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table tabe-hover table-bordered" id="list">
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th>Name</th>
							<th>Phone Number</th>
							<th>User category</th>
							<th>Email</th>
							<th>Status</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 1;
						foreach ($users as $user) :
						?>
							<tr>
								<th class="text-center"><?php echo $i++ ?></th>
								<td><b><?php echo ucwords($user->first_name . ' ' . $user->last_name) ?></b></td>
								<td><b><?php echo $user->phone_number ?></b></td>
								<td><b><?php echo $user->getCategory()->name ?></b></td>
								<td><b><?php echo $user->email ?></b></td>
								<td><?php echo $user->status == "Active" ? $activeBadge : $inactiveBadge ?></td>
								<td class="text-center">
									<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
										Action
									</button>
									<div class="dropdown-menu">
										<a class="dropdown-item" href="./index?page=users-edit&id=<?php echo $user->id ?>">Edit</a>
										<?php if ($user->status == "Inactive") : ?>
											<div class="dropdown-divider"></div>
											<a class="dropdown-item activate_user_account" href="javascript:void(0)" data-id="<?php echo $user->id ?>">Activate</a>
										<?php endif; ?>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item delete_user" href="javascript:void(0)" data-id="<?php echo $user->id ?>">Delete</a>
									</div>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
		$('#list').dataTable()
		// $('.view_user').click(function() {
		// 	uni_modal("<i class='fa fa-id-card'></i> User Details", "users/view?id=" + $(this).attr('data-id'))
		// })
		$('.delete_user').click(function() {
			_conf("Are you sure you want to delete this user?", "delete_user", [$(this).attr('data-id')])
		})
		$('.activate_user_account').click(() => {
			let el = document.querySelector(".activate_user_account")
			let userId = $(el).attr('data-id')
			let data = {
				id: userId
			}
			console.log(data);
			fetch('user/activate', {
					method: 'POST',
					body: JSON.stringify(data),
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
							window.location.reload()
						}, 800)
					} else throw new Error(response.message)
				})
				.catch(error => {
					end_load()
					console.log(error.message);
					toastr.error(error.message)
				})
		})
	})

	function delete_user(id) {
		let data = {
			id: id
		}
		start_load()
		fetch('user/delete', {
				method: 'POST',
				body: JSON.stringify(data),
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
						window.location.reload()
					}, 800)
				} else throw new Error(response.message)
			})
			.catch(error => {
				end_load()
				console.log(error.message);
				toastr.error(error.message)
			})

	}
</script>