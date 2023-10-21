  <aside class="main-sidebar sidebar-light-green elevation-4">
    <div class="dropdown">
      <a href="javascript:void(0)" class="brand-link dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
        <span class="brand-image img-circle elevation-3 d-flex justify-content-center align-items-center bg-primary text-white font-weight-500" style="width: 38px;height:50px"><?php echo strtoupper(substr($currUser->first_name, 0, 1) . substr($currUser->last_name, 0, 1)) ?></span>
        <span class="brand-text font-weight-light"><?php echo ucwords($currUser->first_name . ' ' . $currUser->last_name) ?></span>

      </a>
      <div class="dropdown-menu">
        <a class="dropdown-item manage_account" href="index?page=user_profile" data-id="<?php echo $currUser->id ?>">Manage Account</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="javascript:void(0)" onclick="logout()">Logout</a>
      </div>
    </div>
    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item dropdown">
            <a href="./" class="nav-link nav-home">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>

          </li>



          <li class="nav-item">
            <a href="./index?page=patients" class="nav-link nav-patients">
              <img src="assets/img/patients.png" class="nav-icon" alt="" srcset="">
              <p>
                Patients
              </p>
            </a>
          </li>


          <li class="nav-item">
            <a href="./index?page=referrals" class="nav-link nav-referrals">
              <i class="nav-icon fa fa-building"></i>
              <p>
                Referrals
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link nav-edit_user">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index?page=users-edit" class="nav-link nav-users-edit tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Add New</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index?page=users" class="nav-link nav-users tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index?page=users-categories" class="nav-link nav-users-categories tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Categories</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="./index?page=facilities" class="nav-link nav-facilities">
              <img src="assets/img/hospital.png" class="nav-icon" alt="" srcset="">
              <p>
                Facilities
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="./index?page=departments" class="nav-link nav-departments">
              <img src="assets/img/department.png" class="nav-icon" alt="" srcset="">
              <p>
                Departments
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="./index?page=insurances" class="nav-link nav-insurances">
              <img src="assets/img/health-insurance.png" class="nav-icon" alt="" srcset="">
              <p>
                Insurances
              </p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>
  <script>
    $(document).ready(function() {
      var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
      if ($('.nav-link.nav-' + page).length > 0) {
        $('.nav-link.nav-' + page).addClass('active')
        console.log($('.nav-link.nav-' + page).hasClass('tree-item'))
        if ($('.nav-link.nav-' + page).hasClass('tree-item') == true) {
          $('.nav-link.nav-' + page).closest('.nav-treeview').siblings('a').addClass('active')
          $('.nav-link.nav-' + page).closest('.nav-treeview').parent().addClass('menu-open')
        }
        if ($('.nav-link.nav-' + page).hasClass('nav-is-tree') == true) {
          $('.nav-link.nav-' + page).parent().addClass('menu-open')
        }

      }
      $('.manage_account').click(function() {
        uni_modal('Manage Account', 'manage_user?id=' + $(this).attr('data-id'))
      })
    })

    const logout = () => {
      fetch('../logout')
        .then(() => window.location.reload())

    }
  </script>