<!-- Topbar Start -->
<div class="navbar-custom">
	<ul class="list-unstyled topbar-right-menu float-right mb-0">

		<?php
		if ($this->request->session()->check('Auth')) {
			?>
			<li class="dropdown notification-list">
				<a class="nav-link dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#" role="button"
					 aria-haspopup="false" aria-expanded="false">
					<i class="fe-bell noti-icon"></i>
					<span class="badge badge-danger rounded-circle noti-icon-badge">2</span>
				</a>
				<div class="dropdown-menu dropdown-menu-right dropdown-lg">

					<!-- item-->
					<div class="dropdown-item noti-title">
						<h5 class="m-0">
						<span class="float-right">
							<a href="" class="text-dark">
								<small>Clear All</small>
							</a>
						</span>Notification
						</h5>
					</div>

					<div class="slimscroll noti-scroll">

						<!-- item-->
						<a href="javascript:void(0);" class="dropdown-item notify-item">
							<div class="notify-icon">
								<img src="assets/images/users/avatar-2.jpg" class="img-fluid rounded-circle" alt=""/></div>
							<p class="notify-details">Cristina Pride</p>
							<p class="text-muted mb-0 user-msg">
								<small>Hi, How are you? What about our next meeting</small>
							</p>
						</a>

						<!-- item-->
						<a href="javascript:void(0);" class="dropdown-item notify-item active">
							<div class="notify-icon bg-warning"><i class="mdi mdi-comment-account-outline"></i></div>
							<p class="notify-details">Caleb Flakelar commented on Admin
								<small class="text-muted">1 min ago</small>
							</p>
						</a>

						<!-- item-->
						<a href="javascript:void(0);" class="dropdown-item notify-item">
							<div class="notify-icon bg-info"><i class="mdi mdi-account-plus"></i></div>
							<p class="notify-details">New user registered.
								<small class="text-muted">5 hours ago</small>
							</p>
						</a>

						<!-- item-->
						<a href="javascript:void(0);" class="dropdown-item notify-item">
							<div class="notify-icon">
								<img src="assets/images/users/avatar-4.jpg" class="img-fluid rounded-circle" alt=""/></div>
							<p class="notify-details">Karen Robinson</p>
							<p class="text-muted mb-0 user-msg">
								<small>Wow ! this admin looks good and awesome design</small>
							</p>
						</a>


						<!-- item-->
						<a href="javascript:void(0);" class="dropdown-item notify-item">
							<div class="notify-icon bg-danger"><i class="mdi mdi-comment-account-outline"></i></div>
							<p class="notify-details">Caleb Flakelar commented on Admin
								<small class="text-muted">4 days ago</small>
							</p>
						</a>

						<!-- item-->
						<a href="javascript:void(0);" class="dropdown-item notify-item">
							<div class="notify-icon bg-primary">
								<i class="mdi mdi-heart"></i>
							</div>
							<p class="notify-details">Carlos Crouch liked
								<b>Admin</b>
								<small class="text-muted">13 days ago</small>
							</p>
						</a>
					</div>

					<!-- All-->
					<a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
						View all
						<i class="fi-arrow-right"></i>
					</a>

				</div>
			</li>
			<?php
		}
		?>

		<li class="dropdown notification-list">
			<a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#"
				 role="button" aria-haspopup="false" aria-expanded="false">
				<?php
				if ($this->request->session()->check('Auth')) {
					?>
					<?php if ($this->request->session()->read('Auth.User.icon_image_path')) { ?>
						<img src="<?= $this->request->session()->read('Auth.User.icon_image_path') ?>" alt="user-icon"
								 class="rounded-circle"/>
					<?php } else { ?>
						<img src="/assets/images/users/avatar.png" alt="user-icon" class="rounded-circle"/>
					<?php } ?>
					<span class="pro-user-name ml-1"><?= $this->request->session()->read('Auth.User.nick_name') ?></span>
					<?php
				} else {
					?>
					<i class="fe-user noti-icon"></i>
					<?php
				}
				?>
			</a>
			<div class="dropdown-menu dropdown-menu-right profile-dropdown ">
				<!-- item-->
				<div class="dropdown-item noti-title">
					<h6 class="m-0">
						アカウント
					</h6>
				</div>

				<?php
				if ($this->request->session()->read('Auth.User.user_role') == ROLE_SYSTEM) {
					?>
					<!-- item-->
					<a
						href="<?php echo $this->Url->build(['controller' => 'Users',
							'action' => 'view',
							$this->request->session()->read('Auth.User.id')]); ?>"
						class="dropdown-item notify-item">
						<i class="fe-user"></i>
						<span>アカウント情報</span>
					</a>

					<!-- item-->
					<a
						href="<?php echo $this->Url->build(['controller' => 'Users',
							'action' => 'edit',
							$this->request->session()->read('Auth.User.id')]); ?>"
						class="dropdown-item notify-item">
						<i class="fe-settings"></i>
						<span>アカウント設定</span>
					</a>

					<div class="dropdown-divider"></div>
					<?php
				}
				?>
				<?php
				if ($this->request->session()->check('Auth')) {
					?>
					<a
						href="<?= $this->Url->build(['controller' => 'Users',
							'action' => 'view',
							$this->request->session()->read('Auth.User.id')]); ?>"
						class="dropdown-item notify-item">
						<i class="fe-user"></i>
						<span>ユーザー情報</span>
					</a>
					<div class="dropdown-divider"></div>
					<a href="<?= $this->Url->build(['controller' => 'Users',
						'action' => 'logout']); ?>"
						 class="dropdown-item notify-item">
						<i class="fe-log-out"></i>
						<span>ログアウト</span>
					</a>
					<a
						href="<?= $this->Url->build(['controller' => 'Users',
							'action' => 'unsubscribe',
							$this->request->session()->read('Auth.User.id')]); ?>"
						class="dropdown-item notify-item">
						<i class="fe-trash"></i>
						<span>退会する</span>
					</a>
					<?php
				} else {
					?>
					<a href="<?= $this->Url->build(['controller' => 'Users',
						'action' => 'add']); ?>"
						 class="dropdown-item notify-item">
						<i class="fe-log-out"></i>
						<span>新規会員登録</span>
					</a>
					<a href="<?= $this->Url->build(['controller' => 'Users',
						'action' => 'login']); ?>"
						 class="dropdown-item notify-item">
						<i class="fe-log-out"></i>
						<span>ログイン</span>
					</a>
					<?php
				}
				?>

			</div>
		</li>
	</ul>
	<ul class="list-unstyled menu-left mb-0">
		<li class="float-left">
			<button class="button-menu-mobile open-left disable-btn">
				<i class="fe-menu"></i>
			</button>
		</li>
		<li class="app-search d-none d-sm-block">
			<form>
				<div class="input-group">
					<input type="text" class="form-control" placeholder="イベントを探す...">
					<div class="input-group-append">
						<button class="btn btn-dark" type="submit">
							<i class="fe-search"></i>
						</button>
					</div>
				</div>
			</form>
		</li>
	</ul>
</div>
<!-- end Topbar -->
