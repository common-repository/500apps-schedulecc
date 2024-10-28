<?php
$plugin_name = basename(plugin_dir_path(dirname(__FILE__, 1)));
?>
<div id="scheduleModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <div class="header-border-bottom">
            <span class="close">&times;</span>
            <p class="apps">Other Plugins In 500apps</p>
        </div>
        <div class="plugins">
            <?php if ($plugin_name != 'Formsio') { ?>
                <div class="plugins-card">
                    <div class="card lift">
                        <div class="card-body card-hover-animation">
                            <div class="mb-2 mx-auto">
                                <img src="<?php echo plugin_dir_url(__FILE__) . 'images/forms.svg'; ?>" />
                            </div>
                            <div class="padding-left-right-15 d-flex-justify-content">
                                <h5 class="mt-3 font-weight-bold text-dark">Forms</h5>
                                <div class="btn-center"><a target="_blank" href="https://wordpress.org/plugins/formsio/" class="btn-primary">Install</a></div>
                            </div>
                            <p class="mb-3 text-card-height multi-line-clamp-2 padding-left-right-15 padding-bottom-18 margin-0">
                                Build forms and manage responses like never before with a new-age form builder and response manager.
                            </p>

                        </div>
                    </div>
                </div>
            <?php }
            if ($plugin_name != 'NinjaSEO') { ?>
                <div class="plugins-card">
                    <div class="card lift">
                        <div class="card-body card-hover-animation">
                            <div class="mb-2 mx-auto">
                                <img src="<?php echo plugin_dir_url(__FILE__) . 'images/ninjaseo.svg'; ?>" />
                            </div>
                            <div class="padding-left-right-15 d-flex-justify-content">
                                <h5 class="mt-3 font-weight-bold text-dark">NinjaSEO</h5>
                                <div class="btn-center"><a target="_blank" href="https://wordpress.org/plugins/ninjaseo/" class="btn-primary">Install</a></div>
                            </div>
                            <p class="mb-3 text-card-height multi-line-clamp-2 padding-left-right-15 padding-bottom-18 margin-0">
                                NinjaSEO is an exclusive page grader, web crawler plugin with built in AI Linkbot and Position.
                            </p>

                        </div>
                    </div>
                </div>
            <?php }
            if ($plugin_name != 'PushNinja') { ?>
                <div class="plugins-card">
                    <div class="card lift">
                        <div class="card-body card-hover-animation">
                            <div class="mb-2 mx-auto">
                                <img src="<?php echo plugin_dir_url(__FILE__) . 'images/pushninja.svg'; ?>" />
                            </div>
                            <div class="padding-left-right-15 d-flex-justify-content">
                                <h5 class="mt-3 font-weight-bold text-dark">PushNinja</h5>
                                <div class="btn-center"><a target="_blank" href="https://wordpress.org/plugins/pushninja/" class="btn-primary">Install</a></div>
                            </div>
                            <p class="mb-3 text-card-height multi-line-clamp-2 padding-left-right-15 padding-bottom-18 margin-0">Send push notifications from your WordPress website to all the site visitors to improve customer experience and increase engagement on your website.
                            </p>

                        </div>
                    </div>
                </div>
            <?php }  ?>
        </div>
    </div>
</div>