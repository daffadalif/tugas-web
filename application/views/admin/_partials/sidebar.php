<!-- Sidebar -->
<ul class="sidebar navbar-nav">
    <li class="nav-item <?php echo $this->uri->segment(1) == 'admin' ? 'active': '' ?>">
        <a class="nav-link" href="<?php echo site_url('admin') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Overview</span>
        </a>
    </li>
    <li class="nav-item <?php echo $this->uri->segment(1) == 'crud' ? 'active': '' ?>">
        <a class="nav-link" href="<?php echo site_url('crud') ?>">
            <i class="fas fa-fw fa-boxes"></i>
            <span>Products</span></a>
    </li>
</ul>