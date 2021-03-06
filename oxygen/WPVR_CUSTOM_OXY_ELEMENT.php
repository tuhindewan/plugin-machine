<?php

abstract class WPVR_CUSTOM_OXY_ELEMENT extends OxyEl
{
    /*
     * used by OxyEl class to show the element button in a specific section/subsection
     * @returns {string}
     */
    public function button_place()
    {
        /*
         * Our plugin class that holds variables we need to use across our plugin files
         * we will get this from our plugin main file
         */
        global $wpvr_oxy_integration;

        /*
         * if child element didn't specify a button place,
         * lets add button to "other" tab (more on this later)
         */
        return $wpvr_oxy_integration->tab_slug . "::" . $wpvr_oxy_integration->subsection_other;
    }
}
