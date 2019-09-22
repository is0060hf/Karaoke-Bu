<!-- Topbar Start -->
<div class="navbar-custom">
	<ul class="list-unstyled topbar-right-menu float-right mb-0">

		<li class="dropdown notification-list">
			<a class="nav-link dropdown-toggle nav-user mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
				<img src="/assets/images/users/avatar.png" alt="user-image" class="rounded-circle">
				<small class="pro-user-name ml-1">
					<?= $this->request->session()->read('Auth.User.username'); ?>
				</small>
			</a>
			<div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown ">
				<!-- item-->
				<div class="dropdown-header noti-title">
					<h6 class="text-overflow m-0">アカウント</h6>
				</div>

				<?php
				if ($this->request->session()->read('Auth.User.user_role') == ROLE_SYSTEM) {
						?>
						<!-- item-->
						<a href="<?php echo $this->Url->build(['controller' => 'Users', 'action' => 'view', $this->request->session()->read('Auth.User.id')]); ?>" class="dropdown-item notify-item">
							<i class="fe-user"></i>
							<span>アカウント情報</span>
						</a>

						<!-- item-->
						<a href="<?php echo $this->Url->build(['controller' => 'Users', 'action' => 'edit', $this->request->session()->read('Auth.User.id')]); ?>" class="dropdown-item notify-item">
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
						href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'view', $this->request->session()->read('Auth.User.id')]); ?>"
						class="dropdown-item notify-item">
						<i class="fe-user"></i>
						<span>ユーザー情報</span>
					</a>
					<div class="dropdown-divider"></div>
					<a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout']); ?>"
						 class="dropdown-item notify-item">
						<i class="fe-log-out"></i>
						<span>ログアウト</span>
					</a>
					<a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'unsubscribe', $this->request->session()->read('Auth.User.id')]); ?>"
						 class="dropdown-item notify-item">
						<i class="fe-trash"></i>
						<span>退会する</span>
					</a>
					<?php
				} else {
					?>
					<a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'add']); ?>"
						 class="dropdown-item notify-item">
						<i class="fe-log-out"></i>
						<span>新規会員登録</span>
					</a>
					<a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'login']); ?>"
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
	<button class="button-menu-mobile open-left disable-btn">
		<i class="fe-menu"></i>
	</button>
	<div class="app-search" style="height: 70px;">
		<form style="display: none;">
			<div class="input-group">
				<input type="text" class="form-control" placeholder="Search...">
				<div class="input-group-append">
					<button class="btn btn-primary" type="submit">
						<i class="fe-search"></i>
					</button>
				</div>
			</div>
		</form>
	</div>
</div>
<!-- end Topbar -->
