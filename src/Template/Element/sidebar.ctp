<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">

	<div class="slimscroll-menu">

		<!-- LOGO -->
		<a href="<?php echo $this->Url->build(['controller' => 'Tops',
			'action' => 'index']); ?>"
			 class="logo text-center mb-4">
			<span class="logo-lg">
				<img src="/assets/images/logo.png" alt="" height="60">
			</span>
			<span class="logo-sm">
				<img src="/assets/images/logo-sm.png" alt="" height="40">
			</span>
		</a>

		<!--- Sidemenu -->
		<div id="sidebar-menu">

			<ul class="metismenu" id="side-menu">

				<?php
				if ($this->request->session()->read('Auth.User.role') == ROLE_SYSTEM) {
					?>
					<li>
						<a href="javascript: void(0);">
							<i class="fe-users"></i>
							<span> 会員情報 </span>
							<span class="menu-arrow"></span>
						</a>
						<ul class="nav-second-level" aria-expanded="false">
							<li>
								<?= $this->Html->link(__('新規会員追加'), ['controller' => 'Users',
									'action' => 'add']) ?>
							</li>
							<li>
								<?= $this->Html->link(__('会員情報一覧'), ['controller' => 'Users',
									'action' => 'index']) ?>
							</li>
						</ul>
					</li>
					<li>
						<a href="javascript: void(0);">
							<i class="fe-calendar"></i>
							<span> イベント </span>
							<span class="menu-arrow"></span>
						</a>
						<ul class="nav-second-level" aria-expanded="false">
							<li>
								<?= $this->Html->link(__('新規登録'), ['controller' => 'Events',
									'action' => 'add']) ?>
							</li>
							<li>
								<?= $this->Html->link(__('イベント一覧'), ['controller' => 'Events',
									'action' => 'index']) ?>
							</li>
						</ul>
					</li>
					<li>
						<a href="javascript: void(0);">
							<i class="fe-heart"></i>
							<span> ともだち </span>
							<span class="menu-arrow"></span>
						</a>
						<ul class="nav-second-level" aria-expanded="false">
							<li>
								<?= $this->Html->link(__('ともだち一覧'), ['controller' => 'Friends',
									'action' => 'index']) ?>
							</li>
						</ul>
					</li>
					<li>
						<a href="javascript: void(0);">
							<i class="fe-cloud"></i>
							<span> チーム </span>
							<span class="menu-arrow"></span>
						</a>
						<ul class="nav-second-level" aria-expanded="false">
							<li>
								<?= $this->Html->link(__('新規チーム登録'), ['controller' => 'Teams',
									'action' => 'add']) ?>
							</li>
							<li>
								<?= $this->Html->link(__('参加チーム一覧'), ['controller' => 'Teams',
									'action' => 'index']) ?>
							</li>
							<li>
								<?= $this->Html->link(__('チームランキング'), ['controller' => 'Teams',
									'action' => 'index']) ?>
							</li>
						</ul>
					</li>
					<?php
				}
				?>
				<li>
					<a href="javascript: void(0);">
						<i class="fe-database"></i>
						<span> ダッシュボード </span>
						<span class="menu-arrow"></span>
					</a>
					<ul class="nav-second-level" aria-expanded="false">
						<li>
							<?= $this->Html->link(__('トップ'), ['controller' => 'Tops',
								'action' => 'index']) ?>
						</li>
					</ul>
				</li>
			</ul>


		</div>
		<!-- End Sidebar -->

		<div class="clearfix"></div>

	</div>
	<!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
