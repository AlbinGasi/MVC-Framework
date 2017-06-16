<?php	
$active = LeftMenu::show_active_nav();
$part = LeftMenu::show_active_nav_part();
$user_id = (isset($_SESSION['user_ag']['user_id'])) ? $_SESSION['user_ag']['user_id'] : -122;
?>
<input type="hidden" id="active" value="<?php echo $active ?>">
<input type="hidden" id="part" value="<?php echo $part ?>">
<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="index"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>	
                    </li>
					<?php
						
						if(Admin::can_view()){
							?>
							<li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#posts"><i class="fa fa-fw fa-book"></i> Posts <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="posts" class="collapse">
                            <li>
                                <a id="all" href="posts/all">All Post</a>
                            </li>
                            <li>
                                <a id="add" href="posts/add">Add New</a>
                            </li>
							
							<?php 
								if(Admin::can_view_2()){
							?>
							<li>
                                <a id="categories" href="posts/categories">Categories</a>
                            </li>
							<?php
								}
							?>
						</ul>
                    </li>

                    <?php
                        
                        if(Admin::can_view()){
                            ?>
                        <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#pages"><i class="fa fa-fw fa-book"></i> Pages <i class="fa fa-fw fa-caret-down"></i></a>
                            <ul id="pages" class="collapse">
                                <li>
                                    <a id="all" href="pages/all">All Pages</a>
                                </li>
                                <li>
                                    <a id="add" href="pages/add">Add New</a>
                                </li>
                            </ul>
                        </li>
                        <?php
                        }
                        ?>






					<li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#media"><i class="fa fa-fw fa-camera"></i> Media <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="media" class="collapse">
                            <li>
                                <a id="library" href="media/library">Library</a>
                            </li>
							<li>
                                <a id="index" href="media/index">All gallery</a>
                            </li>
                            <!--li>
                                <a href="media/add">Add New</a>
                            </li-->
						</ul>
                        
                    </li>

							<?php
						}
						
						if(Admin::can_view()){
							?>
							<li>
                        <a id="categories" href="comments"><i class="fa fa-fw fa-comments"></i> Comments</a>	
							</li>
							
							<?php
						}
					
					?>
					
					<!--li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#pages"><i class="fa fa-fw fa-tasks"></i> Pages <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="pages" class="collapse">
                            <li>
                                <a href="pages/all">All Post</a>
                            </li>
                            <li>
                                <a href="pages/add">Add New</a>
                            </li>
						</ul>
                    </li>
					<li>
                        <a href="comments"><i class="fa fa-fw fa-comment"></i> Comments</a>
                    </li>
					<li>
                        <a href="settings"><i class="fa fa-fw fa-wrench"></i> Settings</a>
                    </li-->

                </ul>
            </div>
            <!-- /.navbar-collapse -->
			</nav>
			
<?php
SiteFunc::get_script("public/js/custom/active_menu_selection.js");
?>