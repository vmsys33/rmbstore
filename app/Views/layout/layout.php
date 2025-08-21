<!doctype html>
<html lang="en" dir="ltr">

<?= $this->include('partials/head') ?> 

<body class="geex-dashboard">

    <?= $this->include('partials/header') ?> 

    <main class="geex-main-content">

        <?= $this->include('partials/sidebar') ?> 

        <?= $this->include('partials/customizer') ?> 
        

        <div class="geex-content">
            <?= $this->include('partials/contentHeader') ?> 
                <?= $this->renderSection('content') ?> <!-- Main content from the page -->

        </div>
    </main>

    <!-- JAVASCRIPTS START -->
    <script src="<?= base_url('assets/vendor/js/jquery/jquery-3.5.1.min.js') ?>"></script>
	<script src="<?= base_url('assets/vendor/js/jquery/jquery-ui.js') ?>"></script>
	<script src="<?= base_url('assets/vendor/js/bootstrap/bootstrap.min.js') ?>"></script>

    <?= $this->renderSection('custom_scripts') ?> 
    
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.27.0/dist/apexcharts.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dragula/3.6.6/dragula.min.js" referrerpolicy="origin"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?= base_url('assets/js/main.js?v=' . time()) ?>"></script>

    <!-- JAVASCRIPTS END -->
    
            <!-- Chatbot removed from admin layout -->
</body>

</html>