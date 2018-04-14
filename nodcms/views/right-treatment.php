<?php //include('header.php'); ?>

    <section class="inner-page-banner">
        <div class="banner_wrapper">
            <div class="banner_content">
                <h1>Find the right treatment</h1>
            </div>
        </div>
    </section>

    <section class="faq-page">
        <div class="container">
            <div class="section-heading">
                <h1>All The Available Treatments</h1>
                <div class="cus-hr"></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="faq_for_dentist">
                        <div class="faq-inner">

                            <div class="panel-group faq-accordion" id="accordion">

                                <?php foreach($subCats as $allCats){ ?>

                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" class="collapsed" data-parent="#accordion" href="#collapse<?php echo $allCats['subcat_id']; ?>">
                                                    <?php echo $allCats['subcat_name']; ?>
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapse<?php echo $allCats['subcat_id']; ?>" class="panel-collapse collapse ">
                                            <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                                                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad
                                                minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
                                                commodo consequat.</div>
                                        </div>
                                    </div>

                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

<?php //include('footer.php'); ?>