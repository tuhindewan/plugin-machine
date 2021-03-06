<?php

class WPVR_OXY_INTEGRATION
{
    /* we will need this later to show subsections */
    public $section_slug = "wpvr";

    /* we will need this later to attach an element to a specific subsection */
    public $tab_slug = "wpvr" ;

    /* slugs for different subsection (will be used later inside our elements) */
    public $subsection_dynamic = "dynamic";
    public $subsection_other = "other";

    public function __construct()
    {
        /* show a section in +Add */
        add_action('oxygen_add_plus_sections', [$this, 'add_plus_sections']);

        /* global_settings_tab */
        add_action('oxygen_vsb_global_styles_tabs', [$this, 'global_settings_tab']);

        /* +Add subsections content */
        /* oxygen_add_plus_{$id}_section_content */
        add_action("oxygen_add_plus_" . $this->section_slug . "_section_content", [$this, 'add_plus_subsections_content']);

    }

    public function add_plus_sections()
    {
        /* show a section in +Add dropdown menu and name it "My Custom Elements" */
        CT_Toolbar::oxygen_add_plus_accordion_section($this->section_slug, __("Build with WP VR"));
    }

    public function global_settings_tab()
    {
        global $oxygen_toolbar;
        $oxygen_toolbar->settings_tab(__("WP VR"), $this->tab_slug, "panelsection-icons/styles.svg");
    }

    public function add_plus_subsections_content()
    {
        do_action("oxygen_add_plus_" . $this->tab_slug . "_other");
    }
}
