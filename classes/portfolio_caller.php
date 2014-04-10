<?php

/**
 * Handles the portfolio button being pressed.
 */
class mod_certificate_portfolio_caller extends portfolio_module_caller_base {

    /**
     * @var int
     */
    protected $certificateid;

    /**
     * @return array|void
     */
    public static function expected_callbackargs() {
        return array(
            'certificateid' => true
        );
    }

    /**
     * How long does this reasonably expect to take..
     * Should we offer the user the option to wait..?
     * This is deliberately nonstatic so it can take filesize into account
     * the portfolio plugin can override this.
     * (so for example even if a huge file is being sent,
     * the download portfolio plugin doesn't care )
     */
    public function expected_time() {
        return 2; // Assuming seconds?
    }

    /**
     * Helper function to get sha1
     */
    public function get_sha1() {
        // TODO: Implement get_sha1() method.
    }

    /**
     * Called before the portfolio plugin gets control.
     * This function should copy all the files it wants to
     * the temporary directory, using copy_existing_file
     * or write_new_file
     *
     * @see copy_existing_file()
     * @see write_new_file()
     */
    public function prepare_package() {
        // TODO: Implement prepare_package() method.
    }

    /**
     * Callback to do whatever capability checks required
     * in the caller (called during the export process
     */
    public function check_permissions() {
        require_capability('mod/certificate:view', $this->get_context());
    }

    /**
     * Load data
     */
    public function load_data() {
        // TODO: Implement load_data() method.
    }

    /**
     * @return context_module
     */
    private function get_context() {
        return context_module::instance($this->certificateid);
    }

    /**
     * @return stdClass
     */
    private function get_coursemodule() {
        return get_coursemodule_from_instance('certificate', $this->certificateid);
    }

    /**
     * @return mixed
     */
    private function get_certificate_record() {
        global $DB;

        return $DB->get_record('certificate', array('id' => $this->certificateid));
    }
}